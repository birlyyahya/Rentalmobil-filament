<?php

namespace App\Livewire;

use DateTime;
use Carbon\Carbon;
use App\Models\Mobil;
use App\Models\Driver;
use App\Models\Reservasi as InputReservasi;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Reservasi_detail;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Reservasi extends Component
{

    public $keyword;
    public $pajak;
    public $totalPajak;
    public $driver;
    public $isLoggedIn;
    public $mobil;

    public $form = [
        "status" => "login",
        "nama_lengkap" => "",
        "jenis_identitas" => "KTP",
        "no_identitas" => "",
        "emailGuest" => "",
        "password" => "",
        "telp" => "",
        "alamat" => "",
        "anon_nama_lengkap" => "",
        "anon_telp" => "",
        "anon_email" => "",
        "tujuan" => "",
        "waktu" => "10:00",
        "payment" => "qris",
        "avatar" => "",
    ];


    public function mount(Request $request)
    {
        $this->driver = ['driver' => false, 'harga' => 0, 'hari' => 0];
        if($request->session()->only(['mobil'])){
            $this->keyword = $request->session()->only(['keyword']);
            $this->mobil = $request->session()->only(['mobil']);
            $this->handleLoginSuccess();
            $this->mobil = $this->mobil['mobil'];
        }else {
            redirect()->route('home');
        }
    }

    #[On('handleDataHarga')]
    public function handleDataHarga($totalpajak,$driver){
        $this->totalPajak = $totalpajak;
        $this->driver = $driver;
    }

    #[On('submitForm')]
    public function submitForm()
    {
        if($this->form['status'] == 'login'){

            $validatedData = $this->validate([
                'form.tujuan' => 'required',
                'form.waktu' => 'required',
                'form.payment' => 'required',
            ]);
            $this->create_reservasi();

        }else {
            $validatedData = $this->validate([
                'form.nama_lengkap' => 'required',
                'form.no_identitas' => 'required',
                'form.jenis_identitas' => 'required',
                'form.emailGuest' => 'required|email',
                'form.anon_nama_lengkap' => '',
                'form.anon_telp' => '',
                'form.anon_email' => 'email',
                'form.telp' => 'required',
                'form.alamat' => 'required',
                'form.tujuan' => 'required',
                'form.waktu' => 'required',
                'form.payment' => 'required',
            ]);

            $this->create_customer();
        }

    }
    #[On('getAlldata')]
    public function getAlldata() {
        dd($this->totalPajak);
    }

    #[On('create_customer')]
    public function create_customer(){
        $data = [
            'no_identitas' => $this->form['no_identitas'],
            'nama_lengkap' => $this->form['nama_lengkap'],
            'jenis_identitas' => $this->form['jenis_identitas'],
            'email' => $this->form['emailGuest'],
            'alamat' => $this->form['alamat'],
            'telp' => $this->form['telp'],
            'password' => Hash::make('12345678'),
            'avatar' => 'customer_avatar/avatardefault.png',
            'status' => 'nonactive',
        ];

        $customer =  Customer::create($data);

        Auth::guard('members')->attempt([
            'email' => $customer->email,
            'password' => $customer->password,
        ], true);

        $customer->setRememberToken(Str::random(60));
        $customer->save();

        $this->create_reservasi();
    }
    #[On('create_reservasi')]
    public function create_reservasi()
    {
        $data = [
            'customer_id' => Auth::guard('members')->user()->id,
            'kode_transaksi' => Auth::guard('members')->user()->id . mt_rand(100, 9999),
            'total_bayar' => $this->totalPajak,
            'status_reservasi' => 'pending',
            'status_pembayaran' => 'unpaid',
            'keterangan' => 'pay:'.$this->form['payment'].', driver:'.$this->driver['driver'],
        ];
        $reservasi =  InputReservasi::create($data);

        $this->create_detail_reservasi($reservasi->id);
    }
    #[On('create_detail_reservasi')]
    public function create_detail_reservasi($id)
    {
        $data = [
            'reservasi_id' => $id,
            'mobil_id' => $this->mobil['id'],
            'driver_id' => NULL,
            'tanggal_ambil' => $this->create_date($this->keyword['keyword']['tanggalAmbil'],$this-> keyword['keyword']['waktu']),
            'tanggal_kembali' => $this->create_date($this->keyword['keyword']['tanggalAmbil'], $this-> keyword['keyword']['waktu']),
            'durasi_sewa' => $this->CountDayDriver(),
            'tujuan' => $this->form['tujuan'],
            'biaya_sewa' => $this->mobil['harga_sewa'],
            'biaya_driver' => $this->driver['harga'],
            'status_pengembalian' => 'menunggu',
        ];
        $reservasi_detail =  Reservasi_detail::create($data);

        return redirect()->route('invoice.show', ['invoice' => $reservasi_detail->reservasi->kode_transaksi]);
    }
    public function create_date($tanggal,$waktu) {
        return DateTime::createFromFormat("M d, Y H:i", $tanggal . " " . $waktu)->format("Y-m-d H:i:s");
    }

    #[On('handleLoginSuccess')]
    public function handleLoginSuccess()
    {
        $this->isLoggedIn = Auth::guard('members')->user();
    }

    public function CountDayDriver() {
        $tanggalAmbil = Carbon::parse($this->keyword['keyword']['tanggalAmbil']);
        $tanggalkembali = Carbon::parse($this->keyword['keyword']['tanggalKembali']);

        return $tanggalAmbil->diffInDays($tanggalkembali);
    }

    public function addcart()
    {
        $countDay = $this->CountDayDriver();
        if($this->driver == NULL) {
            $this->driver = ['driver' => true, 'harga' => 200000,'hari'=> $countDay];
            $this->dispatch('updatedDriver', $countDay);
        }else{
            $this->driver = ['driver' => false, 'harga' => 0, 'hari' => 0];
            $this->dispatch('updatedDriver', $countDay);
        }
    }

    public function render()
    {
        return view('livewire.reservasi-form')->extends('layouts.app');
    }
}
