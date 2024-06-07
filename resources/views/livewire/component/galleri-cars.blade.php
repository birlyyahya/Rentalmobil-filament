<div class="flex-shrink-0">
    <div x-data="photoGalleryApp({{ $this->galleri->pluck('image') }})" class="flex flex-col max-w-xl">
        <div class="flex items-center sm:h-80">
            <div :class="{ 'cursor-not-allowed opacity-50': !hasPrevious() }" class="hidden cursor-pointer sm:block">
                <svg version="1.0" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    stroke="currentColor" class="h-8" x-on:click="previousPhoto()">
                    <path d="m42.166 55.31-24.332-25.31 24.332-25.31v50.62z" fill-rule="evenodd" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="3.125" />
                </svg>
            </div>
            <div class="flex justify-center w-full sm:w-108">
                <img x-ref="mainImage" class="object-cover w-full sm:h-80" src="" loading="lazy" />
            </div>
            <div :class="{ 'cursor-not-allowed opacity-50': !hasNext() }" class="hidden cursor-pointer sm:block">
                <svg version="1.0" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    stroke="currentColor" class="h-8" x-on:click="nextPhoto()">
                    <path d="m17.834 55.31 24.332-25.31-24.332-25.31v50.62z" fill-rule="evenodd" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="3.125" />
                </svg>
            </div>
        </div>
        <div class="flex justify-center mt-1 space-x-1">
            @foreach ($this->galleri as $index => $galleri)
                <img src="{{ url('storage/'.$galleri->image) }}"
                    :class="{ 'ring-2 opacity-50': currentPhoto == {{ $index }} }" class="object-cover w-20 h-16" x-on:click="pickPhoto({{ $index }})">
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('photoGalleryApp', (images) => ({
            currentPhoto: 0,
            photos: images.map(image => `{{ url('storage') }}/${image}`),
            init() {
                this.changePhoto();
            },
            nextPhoto() {
                if (this.hasNext()) {
                    this.currentPhoto++;
                    this.changePhoto();
                }
            },
            previousPhoto() {
                if (this.hasPrevious()) {
                    this.currentPhoto--;
                    this.changePhoto();
                }
            },
            changePhoto() {
                this.$refs.mainImage.src = this.photos[this.currentPhoto];
            },
            pickPhoto(index) {
                this.currentPhoto = index;
                this.changePhoto();
            },
            hasPrevious() {
                return this.currentPhoto > 0;
            },
            hasNext() {
                return this.photos.length > (this.currentPhoto + 1);
            }
        }))
    })
</script>
