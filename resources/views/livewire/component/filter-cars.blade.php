   <div class="h-full rounded-lg">
                    <div class="space-y-2">
                        <div x-data="{ isOpen: true }" class="overflow-hidden border border-gray-300 rounded">
                            <button x-on:click="isOpen = !isOpen" type="button"
                                class="flex items-center justify-between w-full gap-2 p-4 text-gray-900 transition bg-white cursor-pointer">
                                <span class="text-sm font-medium"> Kategori Mobil </span>

                                <span class="transition" :class="{ '-rotate-180': isOpen }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>

                            <div x-cloak x-show="isOpen" x-on:keydown.escape.window="isOpen = false"
                                class="bg-white border-t border-gray-200">
                                <div x-cloak x-show="isOpen" x-on:keydown.escape.window="isOpen = false"
                                    class="bg-white border-t border-gray-200">
                                    <header class="flex items-center justify-between p-4">
                                        <span class="text-sm text-gray-700"> 0 Selected </span>

                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4">
                                            Reset
                                        </button>
                                    </header>

                                    <ul class="p-4 space-y-1 border-t border-gray-200">
                                        <li>
                                            <label for="FilterInStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterInStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> Sedan </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterPreOrder" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterPreOrder"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> MVP </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOutOfStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> SUV </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOutOfStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> Hatchback </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOutOfStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> EV </span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div x-data="{ isOpen: true }" class="overflow-hidden border border-gray-300 rounded">
                            <button x-on:click="isOpen = !isOpen" type="button"
                                class="flex items-center justify-between w-full gap-2 p-4 text-gray-900 transition bg-white cursor-pointer">
                                <span class="text-sm font-medium"> Availability </span>

                                <span class="transition" :class="{ '-rotate-180': isOpen }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>

                            <div x-cloak x-show="isOpen" x-on:keydown.escape.window="isOpen = false"
                                class="bg-white border-t border-gray-200">
                                <header class="flex items-center justify-between p-4">
                                    <span class="text-sm text-gray-700"> 0 Selected </span>

                                    <button type="button" class="text-sm text-gray-900 underline underline-offset-4">
                                        Reset
                                    </button>
                                </header>

                                <ul class="p-4 space-y-1 border-t border-gray-200">
                                    <li>
                                        <label for="FilterInStock" class="inline-flex items-center gap-2">
                                            <input type="checkbox" id="FilterInStock"
                                                class="border-gray-300 rounded size-5" />

                                            <span class="text-sm font-medium text-gray-700"> 5 Seats </span>
                                        </label>
                                    </li>

                                    <li>
                                        <label for="FilterPreOrder" class="inline-flex items-center gap-2">
                                            <input type="checkbox" id="FilterPreOrder"
                                                class="border-gray-300 rounded size-5" />

                                            <span class="text-sm font-medium text-gray-700"> 8 Seats </span>
                                        </label>
                                    </li>

                                    <li>
                                        <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                            <input type="checkbox" id="FilterOutOfStock"
                                                class="border-gray-300 rounded size-5" />

                                            <span class="text-sm font-medium text-gray-700"> 9 Seats </span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div x-data="{ isOpen: false }" class="overflow-hidden border border-gray-300 rounded">
                            <button x-on:click="isOpen = !isOpen" type="button"
                                class="flex items-center justify-between w-full gap-2 p-4 text-gray-900 transition bg-white cursor-pointer">
                                <span class="text-sm font-medium"> Transmisi </span>

                                <span class="transition" :class="{ '-rotate-180': isOpen }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>
                            <div x-cloak x-show="isOpen" x-on:keydown.escape.window="isOpen = false"
                                class="bg-white border-t border-gray-200">
                                <header class="flex items-center p-4">
                                    <button x-data="{ isActive: false }"
                                        :class="{
                                            'bg-blue-500 text-white': isActive,
                                            'border-blue-500 text-blue-500': !
                                                isActive
                                        }"
                                        @click="isActive = !isActive"
                                        class="inline-flex items-center justify-center px-3 py-1 text-sm transition-colors duration-300 border rounded-full focus:outline-none">
                                        <span x-text="isActive ? 'Automatic' : 'Automatic'"></span>
                                    </button>
                                    <button x-data="{ isActive: false }"
                                        :class="{
                                            'bg-blue-500 text-white': isActive,
                                            'border-blue-500 text-blue-500': !
                                                isActive
                                        }"
                                        @click="isActive = !isActive"
                                        class="inline-flex items-center justify-center px-3 py-1 text-sm transition-colors duration-300 border rounded-full ms-3 focus:outline-none">
                                        <span x-text="isActive ? 'Manual' : 'Manual'"></span>
                                    </button>
                                </header>
                            </div>
                        </div>
                        <div x-data="{ isOpen: false }" class="overflow-hidden border border-gray-300 rounded">
                            <button x-on:click="isOpen = !isOpen" type="button"
                                class="flex items-center justify-between w-full gap-2 p-4 text-gray-900 transition bg-white cursor-pointer">
                                <span class="text-sm font-medium"> Bahan Bakar </span>

                                <span class="transition" :class="{ '-rotate-180': isOpen }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>

                            <div x-cloak x-show="isOpen" x-on:keydown.escape.window="isOpen = false"
                                class="bg-white border-t border-gray-200">
                                <div x-cloak x-show="isOpen" x-on:keydown.escape.window="isOpen = false"
                                    class="bg-white border-t border-gray-200">
                                    <header class="flex items-center justify-between p-4">
                                        <span class="text-sm text-gray-700"> 0 Selected </span>

                                        <button type="button" class="text-sm text-gray-900 underline underline-offset-4">
                                            Reset
                                        </button>
                                    </header>

                                    <ul class="p-4 space-y-1 border-t border-gray-200">
                                        <li>
                                            <label for="FilterInStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterInStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> Bensin </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterPreOrder" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterPreOrder"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> Solar </span>
                                            </label>
                                        </li>

                                        <li>
                                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOutOfStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> Diesel </span>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="FilterOutOfStock" class="inline-flex items-center gap-2">
                                                <input type="checkbox" id="FilterOutOfStock"
                                                    class="border-gray-300 rounded size-5" />

                                                <span class="text-sm font-medium text-gray-700"> Electric </span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
