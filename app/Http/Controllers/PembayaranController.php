<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Reservasi_detail;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
    }
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $reservasi = Reservasi::find($data['id']);

            $reservasi->status_pembayaran = 'paid';

            $keterangan = $reservasi->keterangan;
            if (preg_match('/driver:([^,]+)/', $keterangan, $matches)) {
                $hasil = $matches[1];
                if ($hasil == 1) {
                    $reservasi->keterangan = $reservasi->keterangan . ',order_id:' . $data['data']['order_id'] . ', transaction_id:' . $data['data']['transaction_id'] . ', timeTransaction:' . $data['data']['transaction_time'] . ',driver=1';
                } else {
                    $reservasi->keterangan = $reservasi->keterangan . ',order_id:' . $data['data']['order_id'] . ', transaction_id:' . $data['data']['transaction_id'] . ', timeTransaction:' . $data['data']['transaction_time'];
                }
            }

            $reservasi->status_reservasi = 'menunggu';

            $reservasi->save();


            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function show($invoice)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config("midtrans.server_key");
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $data = Reservasi::with(['reservasi_details.mobil', 'reservasi_details.driver', 'customer'])->where('kode_transaksi', $invoice)->get()->first();

        $tax = $data->reservasi_details->biaya_sewa + $data->reservasi_details->biaya_driver;
        $totalTax = $tax * 0.11;

        $keterangan = $data->keterangan;

        if (preg_match('/pay:([^,]+)/', $keterangan, $matches)) {
            $paymentMethod = $matches[1];
            if ($paymentMethod == 'qris') {
                $paymentMethod = 'gopay';
            }
        }
        $params = array(
            'transaction_details' => [
                'order_id' => rand(), // Generate a random order ID
                'gross_amount' => (int) $data->total_bayar // Ensure the total amount is an integer
            ],
            'customer_details' => [
                'first_name' => $data->customer->nama_lengkap,
                'email' => $data->customer->email,
                'phone' => $data->customer->telp,
                'billing_address' => [
                    'first_name'   => $data->customer->nama_lengkap,
                    'address'      => $data->customer->alamat,
                    'phone'        => $data->customer->telp,
                    'country_code' => 'IDN' // Country code set to Indonesia
                ],
            ],
            'enabled_payments' => [$paymentMethod], // Specify the payment method
            'item_details' => [
                [
                    'id'       => 'mobil-' . $data->reservasi_details->id,
                    'price'    => (int)$data->total_bayar,
                    'quantity' => 1, // Assuming the quantity is 1 for this example
                    'name'     => $data->reservasi_details->mobil->nama_mobil
                ]
            ],
            'custom_field1' => $data->customer->jenis_identitas . ' ' . $data->customer->no_identitas,
        );

        // Mendapatkan snap token dari Midtrans

        $snapToken = \Midtrans\Snap::getSnapToken($params);


        return view('invoice', compact('data', 'snapToken', 'paymentMethod','totalTax'));
    }

    public function refund(Request $request)
    {
        try {
            $data = $request->all();

            // Nomor telepon penerima (misal: nomor telepon yang terhubung dengan akun WhatsApp)
            $nomor_telepon = '6285158551580';

            // Pesan yang ingin Anda kirimkan
            $pesan = "Halo Admin,\n\nSaya ingin mengajukan pembatalan reservasi dan refund untuk pesanan dengan nomor invoice *INV-" . $data['id'] . "*. Berikut detail pesanan saya:\n\n- Produk: *" . $data['product'] . "*\n- Tanggal Penyewaan: *" . $data['tanggalAmbil'] . "* hingga *" . $data['tanggalKembali'] . "*\n\nMohon bantuan dan tindak lanjutnya.\n\nTerima kasih.";
            // Format URL untuk membuka aplikasi WhatsApp dengan nomor tujuan dan pesan yang disiapkan
            $url_whatsapp = 'https://wa.me/' . $nomor_telepon . '?text=' . urlencode($pesan);

            return response()->json(['success' => true, 'url_whatsapp' => $url_whatsapp]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


}
