<section class="bg-gray-50" wire:ignore>
    <div class="mx-auto max-w-[1340px] px-4 py-12 sm:px-6 lg:me-0 lg:py-16 lg:pe-0 lg:ps-8 xl:py-24">
        <div class="items-end justify-between max-w-7xl sm:flex sm:pe-6 lg:pe-8">
            <h2 class="max-w-xl font-bold tracking-tight text-gray-900 text-1xl sm:text-4xl">
                Best Offers Today
            </h2>

            <div class="flex gap-4 mt-8 lg:mt-0">
                <button wire:ignore aria-label="Previous slide" id="keen-slider-previous"
                    class="p-3 transition border rounded-full border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 rtl:rotate-180">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <button wire:ignore aria-label="Next slide" id="keen-slider-next"
                    class="p-3 transition border rounded-full border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white">
                    <svg class="size-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-8 -mx-6 lg:col-span-2 lg:mx-0">
            <div id="keen-slider" class="keen-slider">
                @foreach ($mobil as $item)
                    <div class="keen-slider__slide" style="max-width: 460px !important; min-width:400px !important;">
                        <blockquote class="flex flex-col justify-between h-full p-6 bg-white shadow-sm sm:p-8 lg:p-5">
                            <a href="#" class="block rounded-lg">
                                <img alt=""
                                    src="https://images.unsplash.com/photo-1613545325278-f24b0cae1224?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                                    class="object-cover w-full h-56 rounded-md" />

                                <div class="mt-4">
                                    <dl>
                                        <div>
                                            <dt class="sr-only">Price</dt>

                                            <dd class="text-sm text-gray-500">Rp
                                                {{ number_format($item->harga_sewa, 2, ',', '.') }}</dd>
                                        </div>

                                        <div>
                                            <dt class="sr-only">cars</dt>

                                            <dd class="font-medium">{{ $item->nama_mobil }}</dd>
                                        </div>
                                    </dl>

                                    <div class="flex items-center gap-8 mt-6 text-xs">
                                        <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                            <svg class="text-indigo-700 size-4" class="w-6 h-6"
                                                xmlns="http://www.w3.org/2000/svg" id="fi_2260179"
                                                enable-background="new 0 0 512.032 512.032" height="512"
                                                viewBox="0 0 512.032 512.032" fill="currentColor" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m205.433 491.171c-32.402-32.037-27.352-85.769 10.589-111.037v-64.255c-7.846-5.255-14.607-12.016-19.862-19.862h-84.138v84.143c37.953 25.476 43.318 79.847 9.721 111.932-28.336 27.063-72.668 26.41-100.31-.92-32.402-32.037-27.352-85.769 10.589-111.037v-248.262c-19.719-13.236-32-35.743-32-59.857 0-40.838 33.988-73.842 75.383-71.922 36.616 1.686 66.413 31.089 68.498 67.741 1.473 25.884-10.806 50.027-31.881 64.063v84.118h84.138c5.255-7.846 12.016-14.607 19.862-19.862v-64.281c-19.719-13.236-32-35.743-32-59.857 0-40.758 33.922-73.845 75.384-71.922 36.616 1.686 66.411 31.089 68.498 67.741 1.472 25.885-10.807 50.028-31.882 64.063v64.255c7.846 5.255 14.608 12.018 19.862 19.862h68.138c8.822 0 16-7.178 16-16v-68.118c-37.902-25.242-43.026-78.965-10.589-111.037 27.644-27.331 71.974-27.982 100.311-.92 33.587 32.077 28.241 86.449-9.722 111.932v68.143c0 52.935-43.065 96-96 96h-68.138c-5.254 7.845-12.017 14.607-19.862 19.862v64.281c19.719 13.236 32 35.743 32 59.857 0 63.753-77.261 95.972-122.589 51.156zm-109.411-227.155h109.396c6.176 0 11.801 3.555 14.452 9.134 3.95 8.314 10.704 15.068 19.018 19.018 5.579 2.65 9.134 8.275 9.134 14.452v82.793c0 6.176-3.555 11.801-9.134 14.452-14.781 7.023-23.73 22.141-22.799 38.515 1.146 20.151 17.847 36.664 38.021 37.593 22.951 1.055 41.912-17.164 41.912-39.956 0-15.362-8.976-29.552-22.866-36.152-5.579-2.65-9.134-8.275-9.134-14.452v-82.793c0-6.176 3.555-11.801 9.134-14.452 8.314-3.951 15.068-10.705 19.018-19.018 2.65-5.579 8.275-9.134 14.452-9.134h77.396c35.29 0 64-28.71 64-64v-77.396c0-6.176 3.555-11.801 9.134-14.452 25.247-11.996 30.81-45.676 10.486-65.085-24.661-23.55-65.641-7.036-67.553 26.57-.932 16.374 8.018 31.492 22.799 38.515 5.579 2.65 9.134 8.275 9.134 14.452v77.396c0 26.467-21.533 48-48 48h-77.396c-6.177 0-11.802-3.555-14.452-9.134-3.949-8.313-10.703-15.067-19.018-19.018-5.579-2.65-9.134-8.275-9.134-14.452v-82.792c0-6.176 3.555-11.801 9.134-14.452 14.781-7.023 23.73-22.141 22.799-38.515-1.146-20.151-17.848-36.664-38.021-37.593-22.891-1.052-41.911 17.11-41.911 39.956 0 15.362 8.976 29.552 22.866 36.152 5.579 2.65 9.134 8.275 9.134 14.452v82.793c0 6.176-3.555 11.801-9.134 14.452-8.314 3.95-15.068 10.704-19.018 19.018-2.65 5.579-8.275 9.134-14.452 9.134h-109.397c-8.836 0-16-7.164-16-16v-109.397c0-6.176 3.555-11.801 9.134-14.452 14.781-7.023 23.73-22.141 22.799-38.515-1.146-20.151-17.847-36.664-38.021-37.593-23.104-1.06-41.912 17.321-41.912 39.956 0 15.362 8.976 29.552 22.866 36.152 5.579 2.65 9.134 8.275 9.134 14.452v266.793c0 6.176-3.555 11.801-9.134 14.452-14.781 7.023-23.73 22.141-22.799 38.515 1.146 20.151 17.847 36.664 38.021 37.593 22.999 1.053 41.912-17.201 41.912-39.956 0-15.362-8.976-29.552-22.866-36.152-5.579-2.65-9.134-8.275-9.134-14.452v-109.397c0-8.836 7.164-16 16-16z">
                                                </path>
                                            </svg>

                                            <div class="mt-1.5 sm:mt-0">
                                                <p class="text-gray-500">Transmision</p>

                                                <p class="font-medium">{{ ucwords($item->transmisi) }}</p>
                                            </div>
                                        </div>

                                        <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                            <svg class="text-indigo-700 size-4" class=""
                                                xmlns="http://www.w3.org/2000/svg" id="fi_2260179"
                                                enable-background="new 0 0 512.032 512.032" height="512"
                                                viewBox="0 0 512.032 512.032" fill="currentColor" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path
                                                    d="m304,96c0-8.837-7.163-16-16-16h-160c-8.837,0-16,7.163-16,16v128c0,8.837 7.163,16 16,16h160c8.837,0 16-7.163 16-16v-128zm-32,112h-128v-96h128v96z">
                                                </path>
                                                <path
                                                    d="M487.538,113.453l-63.809-32c-7.922-3.969-17.42-0.742-21.373,7.156c-3.953,7.906-0.702,17.516,7.204,21.469l24.301,12.139   c-0.65,1.74-1.491,3.58-1.491,5.549c0,20.832,15.63,38.426,31.63,45.051v194.949c0,8.82-7.18,16-16,16s-16-7.18-16-16v-128   c0-38.631-32-70.949-64-78.383V63.766C368,28.477,340.053,0,304.764,0h-192C77.475,0,48,28.477,48,63.766v358.109l-23.156,11.578   c-5.422,2.711-8.844,8.25-8.844,14.313v48C16,504.602,23.928,512,32.764,512h352C393.6,512,400,504.602,400,495.766v-48   c0-6.063-3.422-11.602-8.844-14.313L368,421.875v-227.16c16,6.625,32,24.219,32,45.051v128c0,26.469,21.531,48,48,48   c26.469,0,48-21.531,48-48v-240C496,121.703,492.96,116.164,487.538,113.453z M368,480H48v-22.344l23.156-11.578   c5.422-2.711,8.844-8.25,8.844-14.313v-368C80,46.117,95.115,32,112.764,32h192C322.412,32,336,46.117,336,63.766v368   c0,6.063,3.422,11.602,8.844,14.313L368,457.656V480z">
                                                </path>
                                            </svg>

                                            <div class="mt-1.5 sm:mt-0">
                                                <p class="text-gray-500">Fuel</p>

                                                <p class="font-medium">{{ ucwords($item->jenis_bbm) }}</p>
                                            </div>
                                        </div>

                                        <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                            <svg class="text-indigo-700 size-4" class=""
                                                xmlns="http://www.w3.org/2000/svg" id="fi_2260179"
                                                enable-background="new 0 0 512.032 512.032" height="512"
                                                viewBox="0 0 512.032 512.032" fill="currentColor" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path
                                                    d="M6.575,32.883C6.56,32.829,6.588,32.938,6.575,32.883L6.575,32.883z">
                                                </path>
                                                <path d="M476.941,369.752c-16.625-14.585-37.491-21.077-58.74-18.291l-226.983,29.793l-8.959-86.883
    c-4.157-47.996-15.325-95.014-33.196-139.75l-8.011-20.053c-6.298-15.766-18.287-28.042-33.078-34.843
    c6.517-14.471,7.464-30.851,2.422-46.153c-0.048-0.147-0.101-0.293-0.159-0.437C97.622,21.557,67.506,0.703,33.511,0.005
    c-8.32-0.164-16.168,3.434-21.458,9.891c-5.291,6.458-7.287,14.836-5.478,22.987l75.364,328.866
    c0.904,4.059,4.925,6.62,8.99,5.716c4.06-0.904,6.619-4.928,5.716-8.99L45.112,126.961c-1.02-4.594,0.106-9.316,3.088-12.956
    c2.983-3.64,7.398-5.65,12.095-5.576l21.59,0.443c4.458,0.091,8.801,0.775,12.944,1.983c0.203,0.071,0.408,0.135,0.614,0.188
    c14.183,4.334,25.928,14.866,31.619,29.112l8.011,20.053c17.33,43.382,28.158,88.978,32.183,135.522
    c0.003,0.041,0.007,0.082,0.011,0.124l9.007,87.361l-14.305,1.877c-9.679-13.01-26.432-19.876-43.251-16.126
    c-22.793,5.086-37.21,27.769-32.136,50.564c0.01,0.041,0.02,0.083,0.029,0.126l18.445,76.641
    c2.224,9.246,10.419,15.702,19.928,15.702h289.519c21.377,0,38.792-17.25,39.078-38.56h17.587
    c19.249,0,34.908-16.815,34.908-37.482C506.078,410.128,495.458,385.997,476.941,369.752z M93.548,95.051
    c-3.697-0.734-7.491-1.16-11.352-1.239l-21.59-0.443c-8.161-0.183-15.926,2.905-21.714,8.536L21.267,29.551
    c-0.776-3.586,0.111-7.267,2.438-10.107c2.341-2.858,5.831-4.437,9.497-4.378C61.057,15.639,85.743,32.68,96.16,58.503
    C100.103,70.661,99.124,83.701,93.548,95.051z M124.985,496.935L124.985,496.935c-2.521,0-4.692-1.711-5.281-4.161
    l-18.429-76.575c-3.232-14.672,6.054-29.255,20.724-32.528c14.691-3.278,29.32,6.01,32.615,20.774l21.51,92.49H124.985z
    M471.17,458.375h-84.951c-4.16,0-7.532,3.372-7.532,7.532c0,4.16,3.372,7.532,7.532,7.532h52.299
    c-0.285,13.003-10.944,23.496-24.014,23.496H191.59l-5.464-23.496h165.045c4.16,0,7.532-3.372,7.532-7.532
    c0-4.16-3.372-7.532-7.532-7.532H182.622l-13.321-57.277c-0.129-0.579-0.277-1.149-0.429-1.717l251.289-32.983
    c16.891-2.219,33.528,2.996,46.844,14.677c15.257,13.386,24.008,33.39,24.008,54.882
    C491.013,448.319,482.112,458.375,471.17,458.375z"></path>
                                            </svg>
                                            <div class="mt-1.5 sm:mt-0">
                                                <p class="text-gray-500">Capacity</p>

                                                <p class="font-medium">{{ ucwords($item->kapasitas) }} Seats</p>
                                            </div>
                                        </div>
                                        <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2 ms-10">
                                            <span
                                                class="px-3 py-1 text-sm font-semibold text-blue-600 rounded-md bg-blue-50">
                                                {{ $item->status }} </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </blockquote>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
