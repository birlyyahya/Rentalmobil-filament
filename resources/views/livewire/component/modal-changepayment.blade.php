 <div>
     <div
         class="flex items-center px-5 py-3 space-x-3 border-2 rounded-lg shadow-sm hover:bg-gray-50 border-blue-500/70 checked:outline-blue-500">
         <label class="flex items-center space-x-3">
             <input type="radio" name="radio-group" value="QRIS" checked
                 class="text-blue-500 translate-y-px focus:ring-blue-700 checked:ring-blue-500" />
             <span class="relative flex justify-between leading-none text-left flex-rows">
                 <span class="font-semibold">
                     @switch($this->payment)
                         @case('gopay')
                             QRIS
                         @break

                         @case('mandiri')
                             Mandiri
                         @break

                         @case('bri_va')
                             BRI VA
                         @break

                         @case('bni_va')
                             BNI VA
                         @break

                         @case('bca_va')
                             BCA VA
                         @break

                         @case('alfamart')
                             Alfamart
                         @break

                         @default
                     @endswitch
                 </span>
             </span>
         </label>
         @if ($this->status == 'paid')
             <button class="px-3 py-1 text-xs font-medium text-white rounded-lg bg-blue-500/50"
                 style="margin-left:auto;" onclick="my_modal_2.showModal()" disabled>Change</button>
         @else
             <button class="px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700"
                 style="margin-left:auto;" onclick="my_modal_2.showModal()">Change</button>
         @endif
     </div>
     <dialog id="my_modal_2" class="modal">
         <div class="modal-box">
             <h3 class="text-lg font-bold">Ganti Metode Pembayaran</h3>
             <form wire:submit.prevent='submitForm' class="space-y-3">
                 @csrf
                 @method('PUT')
                 <fieldset class="space-y-4">
                     <legend class="sr-only">Payment</legend>
                     <div>
                         <label for="gopay"
                             class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                             <div>
                                 <p class="text-gray-700">QRIS</p>

                                 <p class="mt-1 text-gray-900">Gopay</p>
                             </div>

                             <input type="radio" name="paymentmethod" wire:model='paymentMethod' value="gopay"
                                 id="gopay" class="text-blue-500 border-gray-300 size-5" />
                         </label>
                     </div>
                     <div>
                         <label for="mandiri"
                             class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                             <div>
                                 <p class="text-gray-700">Mandiri</p>

                                 <p class="mt-1 text-gray-900">Virtual Account</p>
                             </div>

                             <input type="radio" name="paymentmethod" wire:model='paymentMethod' value="mandiri"
                                 id="mandiri" class="text-blue-500 border-gray-300 size-5" />
                         </label>
                     </div>
                     <div>
                         <label for="bca_va"
                             class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                             <div>
                                 <p class="text-gray-700">BCA</p>

                                 <p class="mt-1 text-gray-900">Virtual Account</p>
                             </div>

                             <input type="radio" name="paymentmethod" wire:model='paymentMethod' value="bca_va"
                                 id="bca_va" class="text-blue-500 border-gray-300 size-5" />
                         </label>
                     </div>
                     <div>
                         <label for="bni_va"
                             class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                             <div>
                                 <p class="text-gray-700">BNI</p>

                                 <p class="mt-1 text-gray-900">Virtual Account</p>
                             </div>

                             <input type="radio" name="paymentmethod" wire:model='paymentMethod' value="bni_va"
                                 id="bni_va" class="text-blue-500 border-gray-300 size-5" />
                         </label>
                     </div>
                     <div>
                         <label for="bri_va"
                             class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                             <div>
                                 <p class="text-gray-700">BRI</p>

                                 <p class="mt-1 text-gray-900">Virtual Account</p>
                             </div>

                             <input type="radio" name="paymentmethod" wire:model='paymentMethod' value="bri_va"
                                 id="bri_va" class="text-blue-500 border-gray-300 size-5" />
                         </label>
                     </div>
                     <div>
                         <label for="alfamart"
                             class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                             <div>
                                 <p class="text-gray-700">alfamart</p>

                                 <p class="mt-1 text-gray-900">Virtual Account</p>
                             </div>

                             <input type="radio" name="paymentmethod" wire:model='paymentMethod' value="alfamart"
                                 id="alfamart" class="text-blue-500 border-gray-300 size-5" />
                         </label>
                     </div>
                 </fieldset>
                 <button type="submit" class="w-full btn btn-neutral">Pilih Pembayaran</button>
             </form>
         </div>
         <form method="dialog" class="modal-backdrop">
             <button>close</button>
         </form>
     </dialog>
 </div>
