@extends('layouts.app')
@section('content')
    @livewire('component.navbar')
    <section>
        <div class="h-full pt-[3rem]">
            <div class="relative flex justify-center max-h-full overflow-hidden lg:px-0 md:px-12">
                <div class="hidden bg-white lg:block lg:flex-1 lg:relative sm:contents">
                    <div class="relative inset-0 object-cover w-full h-full bg-black" alt="" height="1866"
                        width="1664">
                        <img class="object-cover object-center w-full h-full bg-gray-200"
                            src="{{ url('storage/heroimage/hero_managebooking.jpg') }}" alt="" width="1310"
                            height="873">
                        <div class="absolute inset-0 bg-black opacity-20"></div>
                    </div>
                </div>
                <div
                    class="relative z-10 flex flex-col flex-1 px-4 py-10 bg-white lg:border-r lg:py-24 md:flex-none md:px-28 sm:justify-center">
                    <div class="w-full max-w-md mx-auto md:max-w-sm md:px-0 md:w-96 sm:px-4">
                        <div class="flex flex-col">
                            <h1 class="text-3xl font-semibold tracking-tighter text-gray-900">
                                Kelola pemesanan yang terbit pada
                                <span class="text-gray-600"> Control Room Booking.</span>
                            </h1>
                            <p class="mt-4 text-base font-medium text-gray-500">
                                Di sini Anda berada di pusat kontrol pemesanan Anda. Isilah kolom di bawah dengan informasi
                                yang benar untuk mengakses detail pesanan Anda.
                            </p>
                        </div>
                        <div class="mt-8">
                            <div class="relative py-3">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-2 text-sm text-black bg-white">Continue with</span>
                                </div>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="p-5" x-data="{ showError: true }" x-init="setTimeout(() => { showError = false }, 2000)">
                                <div x-show="showError" role="alert" class="alert alert-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Reservasi tidak ditemukan</span>
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('managebooking.store') }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label for="email" class="block mb-3 text-sm font-medium text-black">
                                        Email
                                    </label>
                                    <input type="email" id="email" placeholder="Your email" name="email" required
                                        class="block w-full h-12 px-4 py-2 text-blue-500 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                </div>
                                <div class="col-span-full">
                                    <label for="noinvoice" class="block mb-3 text-sm font-medium text-black">
                                        No Invoice
                                    </label>
                                    <input id="noinvoice" name="noinvoice" required
                                        class="block w-full h-12 px-4 py-2 text-blue-500 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm"
                                        placeholder="Masukan kode booking anda..." type="text">
                                </div>
                                <div class="col-span-full">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-full h-12 gap-3 px-5 py-3 font-medium text-white duration-200 bg-gray-900 rounded-xl hover:bg-gray-700 focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                        Cari Pesanan
                                    </button>
                                </div>
                            </div>
                            <div class="mt-6">
                                <p class="flex mx-auto text-sm font-medium leading-tight text-center text-black">
                                    Forget ur invoice?
                                    <a class="ml-auto text-blue-500 hover:text-black" href="/forms/signup">
                                        Contact admin
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-navigation.footer />
@endsection
