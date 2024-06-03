<div class="flex flex-col gap-3 pb-10">
    <form wire:submit.prevent='save' class="flex flex-col gap-4 p-10 rounded-lg bg-gray-50">
        <!-- Profile and Rating -->
        <div class="flex justify-between justify">
            <div class="flex gap-2">
                <div class="text-center rounded-full bg-accent w-7 h-7"><img
                        src="{{ url('storage/' . $customer->avatar) }}" alt="" srcset=""></div>
                <span class="font-medium">{{ $customer->nama_lengkap }}</span>
            </div>
            <div class="flex mb-4">
                <div class="flex">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star cursor-pointer {{ $i <= $rating ? 'text-yellow-500' : 'text-gray-400' }}"
                            wire:click="setRating({{ $i }})"></i>
                    @endfor
                </div>
                @error('rating')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <textarea type="text" placeholder="Masukan review anda" class="w-full outline-blue-500 focus:outline-blue-600 input"
                wire:model='review'></textarea>
            @error('review')
                <span class="p-2 text-white badge badge-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-between">
            <span>{{ $cekDataTestimoni }}</span>
            <button type="submit" class="btn btn-secondary">Submit Review</button>
        </div>
    </form>
    <div role="alert" class="alert alert-success" x-data="{ show: @entangle('message') }" x-show="show" x-init="setTimeout(() => show = false, 2000)">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Berhasil ditambahkan!</span>
    </div>

    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</div>
