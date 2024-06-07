{{-- testimoni --}}
<section class="scroll-mt-24 o" id="testimoni">
    <div class="h-full max-w-6xl px-8 pb-24 mx-auto md:px-12 lg:px-32">
        <section class="bg-white">
            <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-16">
                <h2 class="text-4xl font-bold tracking-tight text-center text-gray-900 sm:text-5xl">
                    Read trusted reviews from our customers
                </h2>

                <div class="mt-8 [column-fill:_balance] sm:columns-2 sm:gap-6 lg:columns-3 lg:gap-8">

                    @foreach ($this->testi as $testi)
                        {{-- Testimoni --}}
                        <div class="mb-8 sm:break-inside-avoid">
                            <blockquote class="p-6 rounded-lg shadow-sm bg-gray-50 sm:p-8">
                                <div class="flex items-center gap-4">
                                    <img alt=""
                                        src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
                                        class="object-cover rounded-full size-14" />
                                    <div>
                                        <div class="flex justify-center gap-0.5 text-green-500">
                                             @for ($i = 1; $i <= $testi->rating; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            @endfor
                                        </div>
                                        <p class="mt-0.5 text-lg font-medium text-gray-900">
                                            {{ $testi->customer->nama_lengkap }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 text-gray-700">
                                   {!! $testi->keterangan !!}
                                </div>
                            </blockquote>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</section>
