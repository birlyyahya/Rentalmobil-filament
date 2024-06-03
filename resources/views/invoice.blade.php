@extends('layouts.app')

@section('content')
    @livewire('component.navbar')
    <section class="h-full px-8 mx-auto pt-36 max-w-8xl md:px-12 lg:px-32">
        <div class="grid grid-cols-7">
            <div class="col-span-5 space-y-10 pe-10">
                <div class="flex space-x-5">
                    <div class="col-span-1">
                        <img class="w-16 rounded-full" src="{{ url('storage/' . $data->customer->avatar) }}" alt="">
                    </div>
                    <div class="flex flex-col space-y-2 text-start">
                            <h1 class="text-2xl font-bold">Invoice #{{ $data->kode_transaksi }}</h1>
                        <div class="flex space-x-2 text-sm text-neutral-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="self-end size-5"
                                id="fi_12253921" data-name="Layer 1" viewBox="0 0 64 64">
                                <path
                                    d="M3.82,5.12A3.76,3.76,0,0,0,0,8.81v7H0v32.6a4.69,4.69,0,0,0,4.68,4.68H28.17a1,1,0,1,0,0-2H4.72A2.71,2.71,0,0,1,2,48.43V16.82H59v15.7a1,1,0,1,0,2,0V15.83h0v-7a3.76,3.76,0,0,0-3.82-3.69H54.32V8.46a3,3,0,0,1-3,3H48.44a3,3,0,0,1-3-3V5.12h-4V8.46a3,3,0,0,1-3,3H35.54a3,3,0,0,1-3-3V5.12h-4V8.46a3,3,0,0,1-3,3H22.64a3,3,0,0,1-3-3V5.12h-4V8.46a3,3,0,0,1-3,3H9.73a3,3,0,0,1-3-3V5.12Z">
                                </path>
                                <rect x="19.99" y="19.53" width="8.48" height="8.04" rx="0.98"></rect>
                                <path
                                    d="M33.55,19.53a1,1,0,0,0-1,1v6.07a1,1,0,0,0,1,1h6.51a1,1,0,0,0,1-1V20.51a1,1,0,0,0-1-1Zm5.53,6.07H34.53V21.5h4.55Z">
                                </path>
                                <rect x="45.14" y="19.53" width="8.48" height="8.04" rx="0.98"></rect>
                                <rect x="7.42" y="29.96" width="8.48" height="8.04" rx="0.98"></rect>
                                <path
                                    d="M28.47,30.94a1,1,0,0,0-1-1H21a1,1,0,0,0-1,1V37a1,1,0,0,0,1,1h6.52a1,1,0,0,0,1-1ZM26.5,36H22v-4.1H26.5Z">
                                </path>
                                <path
                                    d="M8.4,48.43h6.52a1,1,0,0,0,1-1V41.37a1,1,0,0,0-1-1H8.4a1,1,0,0,0-1,1v6.07A1,1,0,0,0,8.4,48.43Zm1-6.07h4.54v4.1H9.39Z">
                                </path>
                                <rect x="19.99" y="40.39" width="8.48" height="8.04" rx="0.98"></rect>
                                <rect x="8.68" y="0.51" width="4.96" height="9" rx="1.05"></rect>
                                <rect x="21.59" y="0.51" width="4.96" height="9" rx="1.05"></rect>
                                <rect x="34.49" y="0.51" width="4.96" height="9" rx="1.05"></rect>
                                <rect x="47.39" y="0.51" width="4.96" height="9" rx="1.05"></rect>
                                <path
                                    d="M47.67,30.82A16.34,16.34,0,1,0,64,47.15,16.33,16.33,0,0,0,47.67,30.82Zm10,21.79a1,1,0,0,1-1.34.39L47.2,48a1,1,0,0,1-.52-.87V36.31a1,1,0,0,1,2,0V46.57l8.66,4.7A1,1,0,0,1,57.71,52.61Z">
                                </path>
                            </svg>
                            <p class="text-neutral-600">
                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('l, F j, Y \a\t H:i:s') }}
                            </p>
                        </div>
                        <a href="{{ route('generatePDF',['kode_transaksi' => $data->kode_transaksi]) }}" class="badge badge-accent">Download PDF <x-heroicon-o-printer class="size-5"/></a>
                    </div>
                    <div class="p-5 " style="margin-left:auto;">
                        @if ($data->status_pembayaran == 'unpaid')
                            <div class="flex px-6 py-2 rounded-lg outline outline-2 outline-orange-500">
                                <p class="px-5 py-1 font-bold text-orange-500">{{ ucwords($data->status_pembayaran) }}</p>
                            </div>
                        @elseif($data->status_pembayaran == 'paid')
                            <div class="flex px-6 py-2 rounded-lg outline outline-2 outline-green-500">
                                <p class="px-5 py-1 font-bold text-green-500">{{ ucwords($data->status_pembayaran) }}</p>
                            </div>
                        @elseif($data->status_pembayaran == 'expired')
                            <div class="flex px-6 py-2 rounded-lg outline outline-2 outline-gray-500">
                                <p class="px-5 py-1 font-bold text-gray-500">{{ ucwords($data->status_pembayaran) }}</p>
                            </div>
                        @elseif($data->status_pembayaran == 'refund')
                            <div class="flex px-6 py-2 rounded-lg outline outline-2 outline-blue-500">
                                <p class="px-5 py-1 font-bold text-blue-500">{{ ucwords($data->status_pembayaran) }}</p>
                            </div>
                        @endif
                        <p class="font-bold text-green-500"></p>
                    </div>
                </div>
                <hr class="w-full h-1 mt-5 bg-gray-200 rounded-lg">
                <div class="pb-10 header">
                    <div class="flex justify-between">
                        <div class="text-sm">
                            <b>From</b>
                            <p class="text-neutral-600">Berlian Rent Car Transportation</p>
                            <p class="text-neutral-600">42 Catur Warga</p>
                            <p class="text-neutral-600">Mataram</p>
                        </div>
                        <div class="">
                            <b>To:</b>
                            <p class="text-sm text-neutral-600">
                                {{ $data->customer->nama_lengkap }}
                            </p>
                            <p class="text-sm text-neutral-600">
                                {{ substr($data->customer->alamat, 25) }}
                            </p>
                            <p class="text-sm text-neutral-600">
                                {{ substr($data->customer->alamat, 10, 15) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="border border-2 rounded-lg shadow-sm">
                    <div class="p-10 space-y-5">
                        <div class="flex justify-between pb-2 text-sm border-b-2">
                            <b>Kendaraan </b>
                            <p>{{ $data->reservasi_details->mobil->nama_mobil }}</p>
                        </div>
                        <div class="flex justify-between pb-2 text-sm border-b-2">
                            <b>Driver :</b>
                            @if ($data->reservasi_details->driver_id !== null)
                                <div x-data="{
                                    tooltipVisible: false,
                                    tooltipText: '{{ $data->reservasi_details->driver->telp }}',
                                    tooltipArrow: false,
                                    tooltipPosition: 'top',
                                }" x-init="$refs.content.addEventListener('mouseenter', () => { tooltipVisible = true; });
                                $refs.content.addEventListener('mouseleave', () => { tooltipVisible = false; });" class="relative">
                                    <div x-ref="tooltip" x-show="tooltipVisible"
                                        :class="{
                                            'top-0 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full': tooltipPosition ==
                                                'top',
                                            'top-1/2 -translate-y-1/2 -ml-0.5 left-0 -translate-x-full': tooltipPosition ==
                                                'left',
                                            'bottom-0 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full': tooltipPosition ==
                                                'bottom',
                                            'top-1/2 -translate-y-1/2 -mr-0.5 right-0 translate-x-full': tooltipPosition ==
                                                'right'
                                        }"
                                        class="absolute w-auto text-sm" x-cloak>
                                        <div x-show="tooltipVisible" x-transition
                                            class="relative px-2 py-1 text-white bg-blue-600 rounded-md bg-opacity-90">
                                            <p x-text="tooltipText" class="flex-shrink-0 block text-xs whitespace-nowrap">
                                            </p>
                                            <div x-ref="tooltipArrow" x-show="tooltipArrow"
                                                :class="{
                                                    'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full': tooltipPosition ==
                                                        'top',
                                                    'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full': tooltipPosition ==
                                                        'left',
                                                    'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full': tooltipPosition ==
                                                        'bottom',
                                                    'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full': tooltipPosition ==
                                                        'right'
                                                }"
                                                class="absolute inline-flex items-center justify-center overflow-hidden">
                                                <div :class="{
                                                    'origin-top-left -rotate-45': tooltipPosition ==
                                                        'top',
                                                    'origin-top-left rotate-45': tooltipPosition ==
                                                        'left',
                                                    'origin-bottom-left rotate-45': tooltipPosition ==
                                                        'bottom',
                                                    'origin-top-right -rotate-45': tooltipPosition == 'right'
                                                }"
                                                    class="w-1.5 h-1.5 transform bg-blue-600 bg-opacity-90"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        {{ $data->reservasi_details->driver->nama_driver }}
                                        <div x-ref="content" class="ml-2">
                                            <svg class="size-4 "height="512" viewBox="0 0 512 512" width="512"
                                                xmlns="http://www.w3.org/2000/svg" id="fi_10308619">
                                                <g id="Layer_2" data-name="Layer 2">
                                                    <g id="exclamation">
                                                        <path
                                                            d="m256 0c-141.38 0-256 114.62-256 256s114.62 256 256 256 256-114.62 256-256-114.62-256-256-256zm35.83 360.17a35.83 35.83 0 0 1 -35.83 35.83 35.83 35.83 0 0 1 -35.83-35.83 35.83 35.83 0 0 1 35.83-35.83 35.83 35.83 0 0 1 35.83 35.83zm4.76-206.87-4.73 119.44a35.89 35.89 0 0 1 -35.86 34.46 35.89 35.89 0 0 1 -35.86-34.46l-4.73-119.44a35.89 35.89 0 0 1 35.86-37.3h9.46a35.89 35.89 0 0 1 35.86 37.3z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>Not Using Driver</p>
                            @endif
                        </div>

                        <div class="flex justify-between pb-2 text-sm border-b-2">
                            <b>Status Reservasi :</b>
                            @if ($data->status_reservasi == 'pending')
                                <div class="flex items-center px-4 py-1 space-x-1 text-white bg-yellow-500 rounded">
                                    <x-heroicon-m-clock class="text-white size-4" />
                                    <span">
                                        {{ ucwords($data->status_reservasi) }}</span>
                                </div>
                            @elseif($data->status_reservasi == 'menunggu')
                                <div class="flex items-center px-4 py-1 space-x-1 text-white bg-blue-500 rounded">
                                    <x-heroicon-m-clock class="text-white size-4" />
                                    <span">
                                        {{ ucwords($data->status_reservasi) }}</span>
                                </div>
                            @elseif($data->status_reservasi == 'diterima')
                                <div class="flex items-center px-4 py-1 space-x-1 text-white bg-green-500 rounded">
                                    <x-heroicon-m-check-circle class="text-white size-4" />
                                    <span">
                                        {{ ucwords($data->status_reservasi) }}</span>
                                </div>
                            @elseif($data->status_reservasi == 'diproses')
                                <div class="flex items-center px-4 py-1 space-x-1 text-white bg-orange-500 rounded">
                                    <x-heroicon-m-clock class="text-white size-4" />
                                    <span">
                                        {{ ucwords($data->status_reservasi) }}</span>
                                </div>
                            @elseif($data->status_reservasi == 'ditolak')
                                <div class="flex items-center px-4 py-1 space-x-1 text-white bg-red-500 rounded">
                                    <x-heroicon-m-x-circle class="text-white size-4" />
                                    <span">
                                        {{ ucwords($data->status_reservasi) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="border">
                    <div class="p-5">
                        <table class="min-w-full overflow-x-auto divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Item
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Durasi
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Status Pengembalian
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ $data->reservasi_details->mobil->nama_mobil }}
                                    </td>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ date('F j Y', strtotime($data->reservasi_details->tanggal_ambil)) . ' - ' . date('F j Y', strtotime($data->reservasi_details->tanggal_kembali)) }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @php
                                                // Membuat objek DateTime dari string tanggal_ambil dan tanggal_kembali
                                                $tanggal_ambil = new DateTime($data->reservasi_details->tanggal_ambil);
                                                $tanggal_kembali = new DateTime(
                                                    $data->reservasi_details->tanggal_kembali,
                                                );

                                                // Menghitung selisih tanggal menggunakan date_diff()
                                                $selisih = date_diff($tanggal_ambil, $tanggal_kembali);

                                                // Mengambil nilai selisih dalam format yang diinginkan
                                                echo $selisih->format('%a days');
                                            @endphp
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($data->reservasi_details->status_pengembalian)
                                            @case('berjalan')
                                                <div class="px-4 py-2 badge badge-secondary">
                                                    {{ ucwords($data->reservasi_details->status_pengembalian) }}</div>
                                            @break

                                            @case('kembali')
                                                <div class="px-4 py-2 badge badge-primary">
                                                    {{ ucwords($data->reservasi_details->status_pengembalian) }}</div>
                                            @break

                                            @default
                                                <div class="px-4 py-2 badge badge-neutral">
                                                    {{ ucwords($data->reservasi_details->status_pengembalian) }}</div>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ Number::currency($data->reservasi_details->mobil->harga_sewa, 'IDR') }}
                                    </td>
                                </tr>
                                @if ($data->reservasi_details->driver_id !== null)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            Driver
                                        </td>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ date('F j Y', strtotime($data->reservasi_details->tanggal_ambil)) . ' - ' . date('F j Y', strtotime($data->reservasi_details->tanggal_kembali)) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @php
                                                    // Membuat objek DateTime dari string tanggal_ambil dan tanggal_kembali
                                                    $tanggal_ambil = new DateTime(
                                                        $data->reservasi_details->tanggal_ambil,
                                                    );
                                                    $tanggal_kembali = new DateTime(
                                                        $data->reservasi_details->tanggal_kembali,
                                                    );

                                                    // Menghitung selisih tanggal menggunakan date_diff()
                                                    $selisih = date_diff($tanggal_ambil, $tanggal_kembali);

                                                    // Mengambil nilai selisih dalam format yang diinginkan
                                                    echo $selisih->format('%a days');
                                                @endphp
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            data
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ Number::currency($data->reservasi_details->biaya_driver, 'IDR') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @livewire('component.testimoni-form',['customer' => $data->customer,'id' =>  $data->reservasi_details->mobil->id])
            </div>
            <div class="w-full h-auto col-span-2 space-x-3">
                <div class="p-5 border border-2 rounded-lg">
                    <h1 class="text-2xl font-bold ">Transaction</h1>
                    <p class="text-xs text-neutral-400">Lakukan pengecekan pada riwayat transaksi anda</p>
                    <br>
                    <div>
                        @livewire('component.changepayment', ['id' => $data->id, 'status' => $data->status_pembayaran, 'payment' => $paymentMethod])
                    </div>
                    <p class="p-1 text-xs text-end text-neutral-400">Change payment method</p>
                    <h1 class="my-5 text-xl font-bold">Summary</h1>
                    <div class="p-2 space-y-3">
                        <div class="flex justify-between">
                            <p class="text-sm text-neutral-600">Subtotal</p>
                            <p class="text-sm font-bold">
                                {{ Number::currency($data->reservasi_details->biaya_sewa + $data->reservasi_details->biaya_driver, 'IDR') }}
                            </p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-neutral-600">Pajak 11%</p>
                            <p class="text-sm font-bold">
                                {{ Number::currency($totalTax, 'IDR') }}</p>
                        </div>
                        <hr class="border border-2 rounded-lg shadow-sm border-neutral-200/70">
                        <div class="flex justify-between">
                            <p class="text-sm text-neutral-600">Total Harga</p>
                            <p class="text-lg font-bold">{{ Number::currency($data->total_bayar , 'IDR') }}</p>
                        </div>
                    </div>
                    <div class="w-full px-5 py-4 mt-10 mb-5 bg-blue-500 rounded-lg">
                        <div class="flex items-center justify-center space-x-2 text-center text-white">
                            <x-heroicon-m-shield-check class="text-white size-8" />
                            <div class="flex flex-col">
                                <p class="text-sm font-bold">100% Uang Pembatalan</p>
                                <p class="text-xs">24 Jam sebelum pengambilan</p>
                            </div>
                        </div>
                    </div>
                    @if ($data->status_pembayaran == 'paid')
                        <button onclick="cancel()"
                            class="w-full px-4 py-2 font-bold text-white bg-orange-500 rounded-md hover:bg-orange-600">Batalkan
                            Pesanan</button>
                    @elseif ($data->status_pembayaran == 'unpaid')
                        <button id="pay-button"
                            class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-600">Bayar
                            Sekarang</button>
                    @else
                        <button
                            class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-md disabled:bg-gray-300 hover:bg-blue-600"
                            disabled>Expired</button>
                    @endif
                </div>
                <div class="pt-10 pb-5 space-x-3 space-y-5">
                    <h1 class="text-2xl font-bold">Timeline</h1>
                    <div class="space-y-6 border-l-2 border-dashed">
                        <div class="relative w-full text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="absolute -top-0.5 z-10 -ml-3.5 h-7 w-7 rounded-full text-blue-500">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="ml-6">
                                <h4 class="font-bold text-blue-500">Invoice Created</h4>
                                <p class="max-w-screen-sm mt-2 text-sm text-gray-500">Dibuat pada {{ $data->created_at }}
                                </p>
                            </div>
                        </div>
                        <div class="relative w-full text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="absolute -top-0.5 z-10 -ml-3.5 h-7 w-7 rounded-full text-blue-500">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="ml-6">
                                <h4 class="font-bold text-blue-500">Payment</h4>
                                <p class="max-w-screen-sm mt-2 text-sm text-gray-500">Selesaikan Pembayaran</p>
                                <span class="block mt-1 text-sm font-semibold text-blue-500"></span>
                            </div>
                        </div>
                        <div class="relative w-full text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="absolute -top-0.5 z-10 -ml-3.5 h-7 w-7 rounded-full text-blue-500">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="ml-6">
                                <h4 class="font-bold text-blue-500">Waiting Confirmation</h4>
                                <p class="max-w-screen-sm mt-2 text-sm text-gray-500">Tunggu konfirmasi pemesanan oleh
                                    admin</p>
                                <span class="block mt-1 text-sm font-semibold text-blue-500"></span>
                            </div>

                        </div>
                        <div class="relative w-full text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="absolute -top-0.5 z-10 -ml-3.5 h-7 w-7 rounded-full text-blue-500">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="ml-6">
                                <h4 class="font-bold text-blue-500">Released Status Reservasi</h4>
                                <p class="max-w-screen-sm mt-2 text-sm text-gray-500">Cek status konfirmasi yang sudah di
                                    konfirmasi</p>
                                <span class="block mt-1 text-sm font-semibold text-blue-500"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <x-navigation.footer />
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('CLIENT_KEY') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    console.log(result)
                    /* You may add your own js here, this is just example */
                    sendDataToController(result);
                },
                // Optional
                onPending: function(result) {
                    console.log(result)
                    /* You may add your own js here, this is just example */
                },
                // Optional
                onError: function(result) {
                    console.log(result)
                    /* You may add your own js here, this is just example */
                }
            });
        };

        function sendDataToController(data) {
            var csrfToken = $('input[name="_token"]').val();
            var response = {
                'status_code': '200',
                'status_message': 'Success, transaction is found',
                'transaction_id': '7a69f054-7ce1-47f0-a772-f287d6691437',
                'transaction_status': 'settlement',
                'order_id': '513935636',
                'payment_type': 'Bank Transfer',
                'gross_amount': '1223631.00',
            };
            // Kirim data ke controller menggunakan AJAX
            $.ajax({
                url: '{{ route('midtrans.store') }}',
                type: 'POST',
                data: {
                    data: data,
                    id: {{ $data->id }},
                    _token: csrfToken,
                },
                success: function(response) {
                    console.log(response)
                    location.reload();
                    // location.reload(); // Sembunyikan alert setelah beberapa detik
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan jika terjadi
                    console.error(error);
                }
            });
        }

        function cancel() {
            var csrfToken = $('input[name="_token"]').val();
            Swal.fire({
                title: "Konfirmasi proses refund",
                text: "proses refund akan diarahkan ke whatsapp untuk menghubungi admin",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Lanjutkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('refund') }}',
                        type: 'POST',
                        data: {
                            id: '{{ $data->kode_transaksi }}',
                            nomor: '{{ $data->customer->telp }}',
                            product: '{{ $data->reservasi_details->mobil->nama_mobil }}',
                            tanggalAmbil: '{{ $data->reservasi_details->tanggal_ambil }}',
                            tanggalKembali: '{{ $data->reservasi_details->tanggal_kembali }}',
                            _token: csrfToken,
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.success) {
                                window.open(response.url_whatsapp, '_blank');
                            }
                            // location.reload(); // Sembunyikan alert setelah beberapa detik
                        },
                        error: function(xhr, status, error) {
                            // Tangani kesalahan jika terjadi
                            console.error(error);
                        }
                    });
                }
            });
        }
    </script>
@endsection
