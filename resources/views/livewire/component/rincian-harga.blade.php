  <div class="flex flex-col p-5 mt-5 border rounded-lg shadow-sm">
      <p class="pb-5 font-bold text-md">Rincian Harga Mobil</p>
      <div class="flex justify-between pb-3">
          <p class="text-sm">{{ $mobil->nama_mobil }}</p>
          <p class="text-sm">{{ Number::currency($mobil->harga_sewa, 'IDR') }}</p>
      </div>
      <div class="flex justify-between pb-3">
          <p class="text-sm">Pajak 10%</p>
          <p class="text-sm">{{ Number::currency($pajak, 'IDR') }}</p>
      </div>
      @if ($driver['driver'] == true)
          <div class="flex justify-between pb-3">
              <p class="text-sm">Driver for {{ $driver['hari'] }} Day</p>
              <p class="text-sm">{{ Number::currency($driver['harga'] * $driver['hari'], 'IDR') }}</p>
          </div>
      @endif
      <hr class="w-[8rem] rounded-md ml-auto my-4 bg-neutral-800">
      </hr>
      <p class="text-lg font-bold text-end">{{ Number::currency($totalPajak, 'IDR') }}
      </p>
      @if ($CurrentURL == 'reservasi')
          <div x-data="{ isLoading: false, isChecked: false }" class="space-y-3">
              <button
                  @click="if(isChecked) { isLoading = true; $dispatch('submitForm'); setTimeout(() => { isLoading = false; }, 5000); }"
                  :disabled="!isChecked" x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
                  x-transition:leave-end="opacity-0 scale-95"
                  class="w-full p-3 mt-10 text-white bg-blue-500 rounded-md disabled:bg-blue-300">
                  <span x-show="!isLoading">Checkout</span>
                  <span x-show="isLoading" x-transition:leave="transition opacity-500 duration-500">Loading...</span>
              </button>

              <label for="agreeTerms" class="flex items-center space-x-2 cursor-pointer">
                  <input type="checkbox" id="agreeTerms" x-model="isChecked"
                      class="text-blue-500 rounded focus:ring-blue-400 focus:outline-none">
                  <span class="text-sm text-gray-700">Saya setuju dengan syarat dan ketentuan</span>
              </label>
          </div>
      @endif

  </div>
