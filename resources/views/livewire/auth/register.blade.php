@section('title', 'Create a new account')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        </a>

        <h2 class="mt-6 text-3xl font-extrabold leading-9 text-center text-gray-900">
            Buat akun member
        </h2>

        <p class="mt-2 text-sm leading-5 text-center text-gray-600 max-w">
            Or
            <a href="{{ url('members') }}"
                class="font-medium text-indigo-600 transition duration-150 ease-in-out hover:text-indigo-500 focus:outline-none focus:underline">
                Login akun member
            </a>
        </p>
    </div>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form wire:submit.prevent="register">
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium leading-5 text-gray-700">
                        Nama Lengkap
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="nama_lengkap" id="nama_lengkap" type="text" required autofocus
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('nama_lengkap') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                    </div>

                    @error('nama_lengkap')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="identitas" class="block text-sm font-medium leading-5 text-gray-700">
                        Identitas
                    </label>

                    <div class="flex mt-1 space-x-3 rounded-md shadow-sm">
                        {{-- jenis identitas --}}
                        <select wire:model.lazy="jenis_identitas" id="jenis_identitas" type="select" required autofocus
                            class="appearance-none block w-24 px-3 py-2 border border-gray-300 rounded-md  placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('jenis_identitas') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror">
                            <option value="KTP" selected>KTP</option>
                            <option value="SIM">SIM</option>
                        </select>

                        {{-- identitas --}}
                        <input wire:model.lazy="no_identitas" id="no_identitas" type="text" required autofocus
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('no_identitas') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                    </div>

                    @error('no_identitas')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="telp" class="block text-sm font-medium leading-5 text-gray-700">
                        No Telephone
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="telp" id="telp" type="telp" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('telp') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                    </div>

                    @error('telp')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                        Email address
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="email" id="email" type="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                    </div>

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between mt-6 space-x-3">
                    <div class="w-full">
                        <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                            Password
                        </label>

                        <div class="mt-1 rounded-md shadow-sm">
                            <input wire:model.lazy="password" id="password" type="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="password_confirmation" class="block text-sm font-medium leading-5 text-gray-700">
                            Confirm Password
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input wire:model.lazy="passwordConfirmation" id="password_confirmation" type="password"
                                required
                                class="block w-full px-3 py-2 placeholder-gray-400 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-blue focus:border-blue-300 sm:text-sm sm:leading-5" />
                        </div>
                    </div>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-6">
                    <div class="w-full">
                        <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                            Alamat
                        </label>

                        <div class="mt-1 rounded-md shadow-sm">
                            <textarea wire:model.lazy="alamat" id="alamat" type="text" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('alamat') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"></textarea>
                        </div>
                    </div>
                </div>
              <div class="divider"></div>
              <p class="text-xs">Sebelum menyimpan, harap periksa ejaan dari nama pengguna, email, dan kata sandi anda.</p>
              <p class="text-xs">Harap diperhatikan, bahwa identitas anda sesuai dengan identitas resmi anda.</p>
              <div class="flex py-5 space-x-3">
                  <input id="cek" type="checkbox" required wire:model.lazy='validator' class="checkbox checkbox-xs checkbox-secondary" />
                  <label for="cek" class="text-xs">Saya telah membaca dan menyetujui syarat dan ketentuan serta eConsent.</label>
              </div>
        </div>

        <div class="mt-6">
            <span class="block w-full rounded-md shadow-sm">
                <button type="submit"
                    class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700">
                    Register
                </button>
            </span>
        </div>
        </form>
    </div>
</div>
</div>
