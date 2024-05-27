<div class="flex-shrink-0">
    <div x-data="photoGalleryApp" class="flex flex-col max-w-xl">
        <div class="flex items-center sm:h-80">
            <div :class="{ 'cursor-not-allowed opacity-50': !hasPrevious() }" class="hidden cursor-pointer sm:block">
                <svg version="1.0" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    stroke="currentColor" class="h-8" x-on:click="previousPhoto()">
                    <path d="m42.166 55.31-24.332-25.31 24.332-25.31v50.62z" fill-rule="evenodd" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="3.125" />
                </svg>
            </div>
            <div class="flex justify-center w-full sm:w-108">
                <img x-ref="mainImage" class="w-full sm:w-auto sm:h-80" src="" loading="lazy" />
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
            <img src="https://inaturalist-open-data.s3.amazonaws.com/photos/58049699/square.jpg"
                :class="{ 'ring-2 opacity-50': currentPhoto == 0 }" class="w-16 h-16" x-on:click="pickPhoto(0)">
            <img src="https://inaturalist-open-data.s3.amazonaws.com/photos/100821385/square.jpg"
                :class="{ 'ring-2 opacity-50': currentPhoto == 1 }" class="w-16 h-16" x-on:click="pickPhoto(1)">
            <img src="https://inaturalist-open-data.s3.amazonaws.com/photos/75873313/square.jpg"
                :class="{ 'ring-2 opacity-50': currentPhoto == 2 }" class="w-16 h-16" x-on:click="pickPhoto(2)">
            <img src="https://inaturalist-open-data.s3.amazonaws.com/photos/65267550/square.jpg"
                :class="{ 'ring-2 opacity-50': currentPhoto == 3 }" class="w-16 h-16" x-on:click="pickPhoto(3)">
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('photoGalleryApp', () => ({
            currentPhoto: 0,
            photos: [
                "https://inaturalist-open-data.s3.amazonaws.com/photos/58049699/medium.jpg",
                "https://inaturalist-open-data.s3.amazonaws.com/photos/100821385/medium.jpg",
                "https://inaturalist-open-data.s3.amazonaws.com/photos/75873313/medium.jpg",
                "https://inaturalist-open-data.s3.amazonaws.com/photos/65267550/medium.jpg",
            ],
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
