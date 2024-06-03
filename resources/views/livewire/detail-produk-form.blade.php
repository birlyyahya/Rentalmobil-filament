 <form wire:submit.prevent="submit">
     <div x-data="{ switchOn: false }" class="text-end">
         <div class="flex space-y-5">
             <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

             <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                 :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }" class="text-sm select-none" x-cloak>
                 Dengan mengklik tombol ini, Anda setuju dengan syarat & ketentuan serta kebijakan privasi
             </label>
             <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn"
                 :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                 class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10" x-cloak>
                 <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                     class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
             </button>
         </div>
         <button :disabled="!switchOn"
             class="h-12 mt-10 mb-20 font-medium duration-200 bg-gray-100 rounded-md w-80 gap-3py-3 enabled:hover:bg-blue-600 disabled:opacity-75 enabled:bg-blue-500 enabled:text-white enabled:hover:text-white focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
             aria-describedby="planDescription" aria-label="Button" type="submit" disabled>
             Lanjutkan Pesanan
         </button>
     </div>
 </form>
