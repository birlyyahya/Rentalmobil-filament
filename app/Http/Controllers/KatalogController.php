<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Mobil;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class KatalogController extends Controller
{
    public function index(Request $request)
    {

        $date['tanggalAmbil'] = $request->tanggalAmbil;
        $date['tanggalKembali'] = $request->tanggalKembali;
        $date['waktu'] = $request->durasi;

        $tanggalAmbil = DateTime::createFromFormat("M d, Y H:i", $date['tanggalAmbil'] . " " . $date['waktu'])->format("Y-m-d H:i:s");
        $tanggalKembali = DateTime::createFromFormat("M d, Y H:i", $date['tanggalKembali'] . " " . $date['waktu'])->format("Y-m-d H:i:s");

        $tanggalAmbil = Carbon::parse($tanggalAmbil);
        $tanggalKembali = Carbon::parse($tanggalKembali);

        $mobilTersedia = Mobil::where('status', '!=', 'away') // Pastikan mobil tidak dalam status 'away'
        ->whereDoesntHave('reservasi_detail', function ($query) use ($tanggalAmbil, $tanggalKembali) {
            // Pastikan tidak ada reservasi detail yang tumpang tindih dengan rentang tanggal yang dipilih
            $query->where(function ($q) use ($tanggalAmbil, $tanggalKembali) {
                $q->where('tanggal_kembali', '>=', $tanggalAmbil)
                    ->where('tanggal_ambil', '<=', $tanggalKembali);
            });
        })
            ->get();
        $mobilTersedia->map(function ($mobil) use ($date) {
            // Hitung jumlah testimoni untuk mobil saat ini dan tambahkan ke dalam objek mobil

            $mobil->countReviews = Testimoni::where('mobil_id', $mobil->id)->count();

            // Mengembalikan objek mobil yang telah dimodifikasi
            return $mobil;
        });


        return view('katalog', ['mobil' => $mobilTersedia, 'keyword' => $date]);
    }


    public function show(mobil $id, $tanggalAmbil, $tanggalKembali, $waktu)
    {
        $data = Testimoni::where('mobil_id', $id->id)->get();
        return view('DetailProduk', ['mobil' => $id, 'keyword' => [
            'tanggalAmbil'=> $tanggalAmbil,
            'tanggalKembali'=> $tanggalKembali,
            'waktu'=> $waktu,

        ],'review' => $data]);
    }
}
