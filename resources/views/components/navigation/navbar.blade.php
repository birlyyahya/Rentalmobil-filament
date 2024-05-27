<section class="fixed z-50 justify-center w-full mx-auto bg-white border-b">
    <div class="relative justify-center w-full mx-auto bg-white">
        <div x-data="{ open: false }"
            class="relative flex flex-col w-full px-8 py-4 mx-auto bg-white max-w-8xl md:px-12 md:items-center md:justify-between md:flex-row lg:px-32">
            <div class="flex flex-row items-center justify-between text-gray-900">
                <a class="inline-flex items-center gap-3 text-xl font-bold tracking-tight text-gray-900 uppercase"
                    href="/">Berlian Rent Car</a><button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline"
                    @click="open = !open">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                        </path>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{ 'flex': open, 'hidden': !open }"
                class="flex-col items-center flex-grow hidden gap-6 p-4 px-5 opacity-100 md:px-0 md:pb-0 md:flex md:justify-start md:flex-row lg:p-0 md:mt-0">
                <a class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90 md:ml-auto"
                    href="#services">Home </a>
                <a href="#testimoni" class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90"
                    href="#benefits">Testimoni </a>
                <a class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90"
                    href="#pricing">About Us</a>
                <a class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90"
                    href="#faq">faq </a>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0 ">
                    <div x-data="{
                        open: false,
                        toggle() {
                            if (this.open) {
                                return this.close()
                            }

                            this.$refs.button.focus()

                            this.open = true
                        },
                        close(focusAfter) {
                            if (!this.open) return

                            this.open = false

                            focusAfter && focusAfter.focus()
                        }
                    }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                        x-id="['dropdown-button']" class="relative inline-block">
                        <button type="button" x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                            :aria-controls="$id('dropdown-button')" type="button"
                            class="relative p-1 text-gray-800 rounded-full hover:text-black hover:ring-2 ring-black focus:outline-none ">
                            <span class="sr-only">View notifications</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                        <div x-ref="panel" x-show="open" x-transition.origin.top.left
                            x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')"
                            class="absolute left-0 z-10 w-48 mt-2 text-sm text-left bg-white border border-gray-100 rounded-lg shadow-lg">
                            <div class="p-1">
                                <a href="#"
                                    class="flex items-center w-full px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                    Dashboard </a>
                                <a href="#"
                                    class="flex items-center w-full px-3 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100">
                                    Settings </a>
                                <a href="#"
                                    class="flex items-center w-full px-3 py-2 text-sm text-left text-gray-700 rounded-md hover:bg-gray-100">
                                    Help </a>
                                <a href="#"
                                    class="flex items-center w-full px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                                    Log out </a>
                            </div>
                        </div>
                    </div>


                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{
                        open: false
                    }" @keydown.escape.prevent.stop="open=false">
                        <div>
                            <button type="button" @click="open = ! open"
                                class="relative flex text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="false">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                            </button>
                        </div>
                        <div x-show="open" x-transition @click.outside="open=false"
                            class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                            tabindex="-1">
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">Manage Booking</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-2">Sign out</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</section>
