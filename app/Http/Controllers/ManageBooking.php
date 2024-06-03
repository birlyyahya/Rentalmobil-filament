<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class ManageBooking extends BaseController
{
    public function index()
    {
        return view("managebooking");
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'noinvoice' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        $noinvoice = $request->input('noinvoice');

        $booking = Reservasi::whereHas('customer', function ($query) use ($email) {
            $query->where('email', $email);
        })
            ->where('kode_transaksi', $noinvoice)
            ->first();



        if ($booking) {
            // Reservasi ditemukan, redirect ke route invoice.show dengan parameter noinvoice
            return redirect()->route('invoice.show', ['invoice' => $noinvoice]);
        } else {
            // Reservasi tidak ditemukan, mungkin menampilkan pesan error atau melakukan tindakan lainnya
            return redirect()->back()->with('error', 'invalid');
        }
    }
    // $data = [
    //     [
    //         'nama' => $kode_transaksi->customer->nama_lengkap,
    //         'alamat' => $kode_transaksi->customer->alamat,
    //         'telp' => $kode_transaksi->customer->telp,
    //         'tanggalFaktur' => Carbon::parse($kode_transaksi->created_at)->format('l d M Y h:i A'),
    //         'namaLayanan' => $kode_transaksi->reservasi_details->mobil->nama_mobil,
    //         'statusPembayaran' => $kode_transaksi->status_pembayaran,
    //         'kodeTransaction' => $kode_transaksi->,
    //         'totalHarga' => $kode_transaksi->,
    //         'kodeTransaction' => $kode_transaksi->,
    //     ]
    // ];
    public function generatePDF(Reservasi $kode_transaksi)
    {
        $tax = $kode_transaksi->reservasi_details->biaya_driver + $kode_transaksi->reservasi_details->biaya_sewa;
        $data = [
            'tanggalAmbil' => Carbon::parse($kode_transaksi->reservasi_details->tanggal_ambil)->format('d/m/Y h:i a'),
            'tanggalKembali' => Carbon::parse($kode_transaksi->reservasi_details->tanggal_kembali)->format('d/m/Y h:i a'),
            'tax' => $tax * 0.11,
        ];


        // Panggil extractValue dengan dua parameter
        $order_id = $this->extractValue($kode_transaksi->keterangan, 'order_id');
        $transaction_id = $this->extractValue($kode_transaksi->keterangan, 'transaction_id');

        $path = public_path().'\storage\logo\logoauthtest.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $getImage = file_get_contents($path);
        $convertImage = 'data:image/' . $type . ';base64,' . base64_encode($getImage);


        $pdf = Pdf::loadView('invoicepdf', compact('kode_transaksi', 'data', 'order_id', 'transaction_id','convertImage'))->setPaper('A4','potrait')->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download();


        // Tambahkan order_id dan transaction_id ke data yang dikirim ke view
        // return view("invoicepdf", compact('kode_transaksi', 'data', 'order_id', 'transaction_id'));
    }

    private function extractValue($description, $key)
    {
        preg_match('/' . $key . ':([^,]+)/', $description, $matches);
        return $matches[1] ?? null;
    }

}
