<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    body {
        font-family: 'poppins', sans-serif;
    }
</style>

<body>
    <div id="invoice"
        style=" position:relative;max-width: 900px; margin: 1.5rem auto; background-color: #ffffff; border-radius: 0.5rem; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="padding: 3rem 3.5rem;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 45%; vertical-align: top;">
                        <!--  Company logo  -->
                        <img src="{{ $convertImage }}" alt="company-logo" height="100" width="100">

                    </td>
                    <td style="width: 55%; margin-right:0; text-align: right; ">
                        <div style="max-width: 27rem; margin: 0;">
                            <b>
                                Berlian Rent Car and Transportation
                            </b>
                            <p style="font-size: 0.875rem; margin: 5px 0px; color: #808080;">
                                Jl. Catur Warga Lombok, no.42 Pejanggik, Kec. Mataram, Kota Mataram, Nusa Tenggara
                                Barat.
                            </p>
                            <p style="margin: 0; font-size: 0.875rem; color: #808080;">
                                082232576990
                            </p>
                        </div>
                    </td>
                </tr>
            </table>

            <div style="width: 100%; margin: 2.5rem 0;">
                <div style="position: absolute; left: 0; background-color: #2f2f2f; width: 94%;">
                    <table style="width: 100%; margin-right:0; border-collapse: collapse;">
                        <tr>
                            <td style="background-color: #0d67f8; padding: 1rem; width: 100%;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="color: #ffffff; font-weight: bold; font-size: 1.5rem;">INVOICE #{{ $kode_transaksi->kode_transaksi }}
                                        </td>
                                        <td
                                            style="color: #ffffff; font-weight: bold; font-size: 1.5rem; text-align: right;">
                                            {{ strtoupper($kode_transaksi->status_pembayaran) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <!-- Client info -->
            <div style="width: 100%; display: table;">
                <div style="display: table-row">
                    <div style="display: table-cell; vertical-align: top; padding-right: 1rem;">
                        <p style="font-size: 0.875rem; color: #808080; margin-bottom: 1rem;">
                            <span style="font-weight: bold; color: #333;">No Transaction: </span>
                            {{ $order_id }}<br>{{ $transaction_id }}
                        </p>
                        <p style="font-size: 0.875rem; color: #808080; margin-bottom: 1rem;">
                            <span style="font-weight: bold; color: #333;">Tanggal Faktur: </span>
                            {{ $kode_transaksi->created_at->format('d/m/Y h:i') }}
                        </p>
                        <p style="font-size: 0.875rem; color: #808080; margin-bottom: 1rem;">
                            <span style="font-weight: bold; color: #333;">Nama Layanan: </span> Mobil
                            {{ $kode_transaksi->reservasi_details->mobil->nama_mobil }}
                        </p>
                    </div>
                    <div style="display: table-cell; vertical-align: top; text-align: right;">
                        <p style="font-size: 0.875rem; font-weight: bold; color: #333; margin-top: 0;">Bill to:</p>
                        <p
                            style="width: 12rem; margin-left: auto; font-size: 0.875rem; color: #808080; margin-bottom: 0;">
                            {{ $kode_transaksi->customer->nama_lengkap }}
                            <br />
                            {{ Str::limit($kode_transaksi->customer->alamat, 22, '') }}
                        </p>
                        <p style="font-size: 0.875rem; color: #808080; margin-top: 0;">
                            {{ $kode_transaksi->customer->email }}
                        </p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <!-- Invoice Items -->
            <div style="margin-top: 4rem;">
                <b style="font-size: 0.875rem;">Rincian Tagihan</b>
                <table style="width: 100%; margin-top: 1.25rem;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <!-- head -->
                            <thead>
                                <tr style="background-color: #ededed;">
                                    <th style="padding: 8px; text-align: left; font-size:0.875rem;">Nama Layanan</th>
                                    <th style="padding: 8px; text-align: left;font-size:0.875rem;">Tanggal Ambil</th>
                                    <th style="padding: 8px; text-align: left;font-size:0.875rem;">Tanggal Kembali</th>
                                    <th style="padding: 8px; text-align: right;font-size:0.875rem;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr>
                                    <td style="padding: 8px; font-size:0.875rem; color:#808080;">
                                        {{ $kode_transaksi->reservasi_details->mobil->nama_mobil }}</td>
                                    <td style="padding: 8px; color:#808080; font-size:0.875rem;">
                                        {{ $data['tanggalAmbil'] }}</td>
                                    <td style="padding: 8px; color:#808080;font-size:0.875rem;">
                                        {{ $data['tanggalKembali'] }}</td>
                                    <td
                                        style="padding: 8px; text-align: right; font-weight: bold; color:#808080; font-size:0.875rem;">
                                        {{ Number::currency($kode_transaksi->reservasi_details->mobil->harga_sewa, 'Rp ') }}
                                    </td>
                                </tr>
                                @if ($kode_transaksi->reservasi_details->driver_id !== null)
                                    <tr>
                                        <td style="padding: 8px; font-size:0.875rem; color:#808080;  ">
                                            {{ $kode_transaksi->reservasi_details->driver->nama_driver }}</td>
                                        <td style="padding: 8px; font-size:0.875rem;color:#808080;">
                                            {{ $data['tanggalAmbil'] }}</td>
                                        <td style="padding: 8px; font-size:0.875rem;color:#808080;">
                                            {{ $data['tanggalKembali'] }}
                                        </td>
                                        <td
                                            style="padding: 8px; text-align: right; font-weight: bold; font-size:0.875rem;">
                                            {{ Number::currency($kode_transaksi->reservasi_details->biaya_driver, 'Rp ') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row" colspan="3"
                                        style="padding-top: 1.5rem; padding-left: 1rem; padding-right: 0.75rem; font-size: 0.875rem; font-weight: bold; color: #333; text-align: right;">
                                        Subtotal
                                    </th>
                                    <td
                                        style="padding-top: 1.5rem; padding-left: 0.75rem; font-size: 0.875rem; text-align: right; font-weight: bold; color: #333;">
                                        {{ Number::currency($kode_transaksi->reservasi_details->biaya_driver + $kode_transaksi->reservasi_details->biaya_sewa, 'Rp ') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3"
                                        style="padding-top: 1rem; padding-left: 1rem; padding-right: 0.75rem; font-size: 0.875rem; font-weight: bold; color: #333; text-align: right;">
                                        PPN 11%
                                    </th>
                                    <td
                                        style="padding-top: 1rem; font-weight: bold; padding-left: 0.75rem; font-size: 0.875rem; text-align: right; color: #333;">
                                        {{ Number::currency($data['tax'], 'Rp ') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <div style="height: 4rem; margin: 2.5rem 0; width: 100%;">
                            <p style="padding-bottom: 0.5rem; font-weight: bold; text-align: right;">Total Tagihan</p>
                            <div style="position: absolute; right: 0; background-color: #0d67f8; width: 93%;">
                                <div
                                    style="display: flex; justify-content: space-between; margin: 0 auto; width: 100%;">
                                    <div style="width: 92%; padding-right: 2rem; margin-right: auto;"
                                        id="invoice">
                                        <h1
                                            style="font-weight: bold; font-size: 1.5rem; color: #ffffff; text-align: right;">
                                            {{ Number::currency($kode_transaksi->reservasi_details->biaya_driver + $kode_transaksi->reservasi_details->biaya_sewa + $data['tax'], 'Rp ') }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  Footer  -->
                    <div
                        style="padding-top: 0.5rem; font-size: 0.75rem; text-align: center; text-gray-500; border-top: 1px solid #eee;">
                        Please pay the invoice before the due date. You can pay the invoice by logging in to your
                        account
                        from
                        our
                        client portal.
                    </div>
                </table>
            </div>
        </div>
    </div>


</body>


</html>
