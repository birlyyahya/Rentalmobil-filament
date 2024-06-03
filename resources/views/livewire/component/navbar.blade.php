<section class="fixed z-50 justify-center w-full mx-auto bg-white border-b">
    <div class="relative justify-center w-full mx-auto bg-white">
        <div x-data="{ open: false }"
            class="relative flex flex-col w-full px-8 py-4 mx-auto bg-white max-w-8xl md:px-12 md:items-center md:justify-between md:flex-row lg:px-32">
            <div class="flex flex-row items-center justify-between text-gray-900">
                <a class="inline-flex items-center gap-3 text-xl font-bold tracking-tight text-gray-900 uppercase"
                    href="/">
                    <img src="{{ url('storage/logo/logonavbar2.png') }}" alt="" srcset=""
                        class="object-cover w-1/3 ">
                </a><button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
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
                class="flex-col items-center flex-grow hidden gap-6 p-4 px-5 opacity-100 md:px-0 md:pb-0 md:flex md:justify-start md:flex-row lg:p-0 md:mt-0"
                style="flex-shrink: 0;">
                <a class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90 md:ml-auto"
                    href="{{ request()->routeIs('home') ? '#home' : route('home') . '#home' }}" x-data
                    @click="scrollToSection($event)">Home </a>
                <a href="#testimoni"
                    class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90"
                    href="{{ request()->routeIs('home') ? '#testimoni' : route('home') . '#testimoni' }}" x-data
                    @click="scrollToSection($event)">Testimoni </a>
                <a class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90"
                    href="{{ request()->routeIs('home') ? '#aboutus' : route('home') . '#aboutus' }}" x-data
                    @click="scrollToSection($event)">About Us</a>
                <a class="py-2 text-xs font-semibold text-gray-900 uppercase hover:text-gray-400 focus:outline-none focus:shadow-none focus:text-gray-900/90"
                    href="{{ request()->routeIs('home') ? '#faq' : route('home') . '#faq' }}" x-data
                    @click="scrollToSection($event)">faq </a>
                <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 space-x-3 sm:static sm:inset-auto sm:ml-6 sm:pr-0 ">
                    <a href="{{ route('managebooking') }}"
                        class="px-4 py-2 text-xs text-white bg-blue-500 rounded-md focus:ring-1 hover:bg-blue-700">Manage
                        Booking</a>
                    @if ($isLoggedIn)
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
                                    <img class="w-8 h-8 rounded-full" src="{{ url('storage/' . $isLoggedIn->avatar) }}"
                                        alt="">
                                </button>
                            </div>
                            <div x-show="open" x-transition @click.outside="open=false"
                                class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="/members" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Manage Booking</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                        id="user-menu-item-2">Sign out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/members/login"
                            class="px-4 py-2 text-xs text-white bg-blue-500 rounded-md hover:bg-blue-700 ">Login</a>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</section>
