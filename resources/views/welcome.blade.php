@extends('layouts.app')

@section('content')
    @livewire('component.navbar')

    {{-- Hero title --}}
    <section id="home"
        class="bg-[url('http://127.0.0.1:8000/storage/heroimage/heroimage.jpg')] bg-cover bg-center bg-fixed bg-no-repeat relative">
        <div class="bg-black/25">

            <div class="relative h-full max-w-6xl px-8 mx-auto py-36 md:px-12 lg:pt-24 lg:px-32 ">
                <div class="lg:p-20 lg:text-center">
                    <p class="text-4xl font-semibold tracking-tighter text-white lg:text-6xl">
                        Taklukan jalan dengan gaya.
                        <span>Dapatkan Kunci untuk Mobilitas Tanpa Batas.</span>
                    </p>
                </div>
            </div>

            {{-- Searchbar --}}
            <section>
                <div class="h-full max-w-6xl pb-12 mx-auto">
                    <div class="px-6 mx-auto max-w-7xl">
                        <form class="flex gap-5" action="{{ route('search') }}" method="GET">
                            <div class="flex px-4 pt-4 bg-white border rounded-lg shadow-md">
                                {{-- tanggal ambil --}}
                                <x-datepicker-ambil />
                                <div class="w-6 mx-3 text-neutral-400" style="align-content: center">
                                    <x-heroicon-o-arrows-right-left />
                                </div>
                                {{-- tanggal kembali --}}
                                <x-datepicker-kembali />

                            </div>
                            <div class="relative p-2 bg-white border rounded-lg shadow-m">
                                <label for="durasi"
                                    class="block px-1 py-2 pt-4 overflow-hidden border-gray-200 rounded-md shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
                                    <span class="block mb-1 text-sm font-medium text-neutral-500">Waktu</span>
                                </label>
                                <input type="time" id="durasi" name="durasi" value="10:00"
                                    class="w-full pt-0 border-none text-md focus:border-transparent focus:outline-none focus:ring-0 sm:text-md" />
                            </div>

                            <button
                                class="flex items-center justify-between w-full gap-4 px-5 py-3 transition-colors bg-indigo-600 border border-indigo-600 rounded-lg group focus:outline-none focus:ring hover:bg-indigo-700">
                                <span class="font-medium text-white transition-colors group-active:text-indigo-500">
                                    Cari Mobil
                                </span>
                                <span
                                    class="p-2 text-indigo-600 bg-white border border-current rounded-full shrink-0 group-active:text-indigo-500">
                                    <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>

                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>

    {{-- Best Deals --}}
            <livewire:homepage.mobil-offer-today />

    @livewire('homepage.testimonial')
    {{-- faq --}}
    <section class="scroll-mt-24" id="faq">
        <div class="h-full max-w-6xl px-8 py-24 mx-auto md:px-12 lg:px-32">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                <div>
                    <p class="text-4xl font-semibold tracking-tighter text-gray-900 lg:text-6xl">
                        FAQ
                    </p>
                    <p class="max-w-xs mx-auto mt-4 text-sm text-gray-500">
                        Frequent questions & answers
                    </p>
                </div>
                <div class="flex flex-col gap-6 text-base text-gray-400 lg:col-span-2">
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            Bagaimana prosedur terjadinya kecelakaan atau kerusakan?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                            Mohon hubungi perusahaan rental dan polisi segera, jika mobil dicuri, rusak parah, atau rusak
                            akibat kecelakaan dengan pihak lain. Anda akan bertanggung jawab sepenuhnya untuk biaya
                            penggantian/perbaikan mobil jika Anda tidak bisa menunjukkan dokumen yang diperlukan dari
                            polisi. Mohon hubungi perusahaan rental segera jika kerusakan kecil dialami mobil dan tidak
                            melibatkan pihak lain.
                            <br>
                            Perusahaan rental mobil tidak bertanggung jawab atas kehilangan/pencurian/kerusakan
                            barang-barang di dalam mobil, selama atau setelah rental.
                            <br>
                            Kerusakan pada mobil akan dikenakan biaya oleh perusahaan persewaan mobil setelah mobil
                            dikembalikan dan akan dikenai biaya administrasi kerusakan sebagai daftar teratas pada jumlah
                            yang dikurangi dari lebihan.
                            <br>
                            Tidak termasuk dalam pertanggungan rental (CDW & TP)
                            Kehilangan/pencurian/kerusakan pada: kunci, antena, dongkrak, segitiga pengaman dan rompi, wiper
                            kaca depan, tutup bensin, penutup bagasi, atau komponen mobil tetap atau bergerak lainnya.
                        </p>
                    </details>
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            Tidak termasuk dalam harga rental
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                        <ul>
                            <li>Biaya Daerah</li>
                            <li>Bensin</li>
                            <li>Parkir</li>
                            <li>Supir</li>
                            <li>Kehilangan atau kerusakan</li>
                            <li>Tanggung Gugat Pihak Ketiga (TPL)</li>
                        </ul>
                        </p>
                    </details>
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            Apa yang dibutuhkan saat pengambilan?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                        <ul>
                            <li>SIM yang utuh dan valid untuk setiap pengemudi</li>
                            <li>Paspor setiap pengemudi </li>
                            <li>Informasi valid alamat rumah pengemudi utama</li>
                        </ul>
                        </p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <x-navigation.footer />
@endsection

@section('script')
    <link href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" rel="stylesheet" />

    <script type="module">
        import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

        const keenSlider = new KeenSlider(
            '#keen-slider', {
                loop: true,
                slides: {
                    origin: 'center',
                    perView: 1.25,
                    spacing: 16,
                },
                breakpoints: {
                    '(min-width: 1024px)': {
                        slides: {
                            origin: 'auto',
                            perView: 2.5,
                            spacing: 32,
                        },
                    },
                },
            },
            []
        )

        const keenSliderPrevious = document.getElementById('keen-slider-previous')
        const keenSliderNext = document.getElementById('keen-slider-next')

        keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
        keenSliderNext.addEventListener('click', () => keenSlider.next())
    </script>
@endsection
