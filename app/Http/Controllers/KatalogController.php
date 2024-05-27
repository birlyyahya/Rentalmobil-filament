<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Mobil;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Query untuk mencari mobil yang tersedia
        $mobilTersedia = Mobil::leftJoin('reservasi_details', function ($join) use ($tanggalAmbil, $tanggalKembali) {
            $join->on('mobils.id', '=', 'reservasi_details.mobil_id')
                ->where(function ($query) use ($tanggalAmbil, $tanggalKembali) {
                    $query->where(function ($query) use ($tanggalAmbil, $tanggalKembali) {
                        $query->where('reservasi_details.tanggal_ambil', '<=', $tanggalKembali)
                            ->where('reservasi_details.tanggal_kembali', '>=', $tanggalAmbil);
                    })
                        ->orWhere(function ($query) use ($tanggalAmbil) {
                            $query->where('mobils.status', '=', 'away')
                                ->where('reservasi_details.tanggal_kembali', '>=', $tanggalAmbil);
                        });
                });
        })
            ->where(function ($query) use ($tanggalAmbil, $tanggalKembali) {
                $query->where('mobils.status', '=', 'ready')
                    ->orWhere(function ($query) use (
                        $tanggalAmbil,
                        $tanggalKembali
                    ) {
                        $query->where('mobils.status', '=', 'away')
                            ->where(function ($query) use ($tanggalAmbil, $tanggalKembali) {
                                $query->whereNull('reservasi_details.id')
                                    ->orWhere(function ($query) use ($tanggalAmbil, $tanggalKembali) {
                                        $query->where('reservasi_details.tanggal_ambil', '>', $tanggalKembali)
                                            ->orWhere('reservasi_details.tanggal_ambil', '=', $tanggalKembali);
                                    });
                            });
                    });
            })
            ->select('mobils.*')
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
        return view('DetailProduk', ['mobil' => $id, 'keyword' => [
            'tanggalAmbil'=> $tanggalAmbil,
            'tanggalKembali'=> $tanggalKembali,
            'waktu'=> $waktu,
        ]]);
    }
}
