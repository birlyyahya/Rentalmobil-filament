<form class="my-5 mt-5" wire:submit.prevent="authenticate">
    <div class="flex gap-3">
        <div class="w-full">
            <label for="email" class="block mb-3 text-sm font-medium text-black">
                Email
            </label>
            <input type="text" wire:model.lazy="email" id="email" placeholder="email"
                class="block w-full h-12 px-4 py-2 text-blue-500 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
        </div>
        <div class="w-full">
            <label for="password"  class="block mb-3 text-sm font-medium text-black">
                Password
            </label>
            <input type="password" wire:model.lazy="password" id="password" placeholder="***"
                class="block w-full h-12 px-4 py-2 text-blue-500 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
        </div>
    </div>
    <x-filament::button type="submit" form="authenticate"
        class="w-full px-4 py-2 mt-3 text-white bg-blue-500 rounded-lg hover:bg-blue-700"> Login
    </x-filament::button>
</form>
