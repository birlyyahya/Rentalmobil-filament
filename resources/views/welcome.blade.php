@extends('layouts.app')

@section('content')
    <x-navigation.navbar />

    {{-- Hero title --}}
    <section
        class="bg-[url(https://images.unsplash.com/photo-1604014237800-1c9102c219da?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80)] bg-cover bg-center bg-fixed bg-no-repeat relative">
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
                            What does Jamstack entail?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                            JAMstack is an innovative approach to web development that stands
                            for JavaScript, APIs, and Markdown. It's all about creating faster
                            websites with improved SEO rankings and a better overall user
                            experience.
                        </p>
                    </details>
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            What coding languages ?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                            We utilize a range of modern technologies and languages to create
                            your websites, including HTML, CSS, JavaScript, and various
                            frameworks like React or Vue.js. Additionally, we work with headless
                            Content Management Systems (CMS) and APIs to manage content
                            efficiently.
                        </p>
                    </details>
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            How fast will I get my coded website?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                            The speed of delivery depends on the complexity of your project and
                            your specific requirements. We aim to provide swift delivery, and
                            we'll discuss the timeline during our initial consultation. Rest
                            assured, we're committed to delivering your website as efficiently
                            as possible.
                        </p>
                    </details>
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            How can I check the progress of my website?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                            We'll set up a convenient communication channel, such as email or a
                            project management platform, to keep you updated on the progress of
                            your website. You can communicate with us, ask questions, and
                            provide feedback through this channel to ensure a smooth
                            collaboration.
                        </p>
                    </details>
                    <details>
                        <summary class="text-base font-medium tracking-tight text-gray-900">
                            If I have a blog, do you count each post as a separate page?
                        </summary>
                        <p class="pt-4 text-sm text-gray-500">
                            The way we structure and charge for your blog pages can vary
                            depending on your specific needs. Generally, individual blog posts
                            can be counted as separate pages, but this can be discussed and
                            tailored to your preferences during our project discussions. We aim
                            to be flexible and accommodating to meet your requirements.
                        </p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <x-navigation.footer />
@endsection
