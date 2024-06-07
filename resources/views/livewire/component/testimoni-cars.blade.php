

<div class="items-end justify-between sm:flex sm:pe-6 lg:pe-8">
    <h2 class="max-w-xl text-2xl font-bold tracking-tight text-gray-900 sm:text-2xl">
        Reviews from our customers
    </h2>

    <div class="flex gap-4 mt-8 lg:mt-0">
        <button aria-label="Previous slide" id="keen-slider-previous"
            class="p-3 transition border rounded-full border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 rtl:rotate-180">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button aria-label="Next slide" id="keen-slider-next"
            class="p-3 transition border rounded-full border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white">
            <svg class="size-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </button>
    </div>
</div>

<div id="keen-slider" class="max-w-3xl mt-10 keen-slider">
    @fodrelse ($review as $test)
        <div class="keen-slider__slide">
            <blockquote class="p-6 rounded-lg shadow-sm bg-gray-50 sm:p-8">
                <div class="flex items-center gap-4">
                    <img alt=""
                        src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
                        class="object-cover rounded-full size-14" />
                    <div>
                        <div class="flex gap-0.5 text-green-500">
                            @for ($i = 0; $i < $test->rating; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="mt-0.5 text-sm font-medium text-gray-900">
                            {{ $test->customer->nama_lengkap }}
                        </p>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-700">
                    {!! $test->keterangan !!}
                </p>
            </blockquote>
        </div>
    @empty
        <h2 class="text-lg font-bold text-center text-neutral-400">Belum Ada Review</h2>
    @endforelse
</div>
