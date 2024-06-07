@section('content')
    <div>
        @livewire('component.navbar')

        <section x-data="{
            open: false
        }">
            <div class="h-full px-8 pt-24 mx-auto max-w-8xl md:px-12 lg:px-32">
                <div class="grid grid-cols-1 gap-4 rounded-lg shadow-md bg-neutral-100 lg:grid-cols-3 lg:gap-8 ">
                    <div class="h-32 p-5 bg-white rounded-r-full shadow-md lg:col-span-2">
                        <h2 class="font-bold tracking-normal text-1xl">Pilih kendaraan anda sekarang!</h2>
                        <div class="flex justify-between mt-3">
                            <div class="flex-rows">
                                <p class="text-sm">Tanggal Mulai Sewa</p>
                                <p class="text-xs font-bold">{{ $keyword['keyword']['tanggalAmbil'] }}</p>
                            </div>
                            <div class="flex-rows">
                                <p class="text-sm">Tanggal Kembali</p>
                                <p class="text-xs font-bold">{{ $keyword['keyword']['tanggalKembali'] }}</p>
                            </div>
                            <div class="flex-rows me-20">
                                <p class="text-sm">Waktu</p>
                                <p class="text-xs font-bold">{{ $keyword['keyword']['waktu'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-32 py-12 text-center rounded-lg">
                        <button @click="open = ! open"
                            class="inline-flex items-center gap-2 px-8 py-3 text-white bg-indigo-600 border border-indigo-600 rounded hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                            href="#">

                            <svg version="1.1" id="fi_622669" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" class=" size-5" fill="currentColor"
                                stroke="none" viewBox="0 0 512.005 512.005"
                                style="enable-background:new 0 0 512.005 512.005;" xml:space="preserve">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M505.749,475.587l-145.6-145.6c28.203-34.837,45.184-79.104,45.184-127.317c0-111.744-90.923-202.667-202.667-202.667
                                                                                                                                                                                           S0,90.925,0,202.669s90.923,202.667,202.667,202.667c48.213,0,92.48-16.981,127.317-45.184l145.6,145.6
                                                                                                                                                                                           c4.16,4.16,9.621,6.251,15.083,6.251s10.923-2.091,15.083-6.251C514.091,497.411,514.091,483.928,505.749,475.587z
                                                                                                                                                                                           M202.667,362.669c-88.235,0-160-71.765-160-160s71.765-160,160-160s160,71.765,160,160S290.901,362.669,202.667,362.669z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium"> Ubah Pencarian </span>
                        </button>
                    </div>
                </div>
                <form x-show="open" x-transition.duration.500ms class="flex gap-5 mt-4" action="{{ route('search') }}"
                    method="GET">
                    <div class="flex px-4 pt-4 my-3 bg-white border rounded-lg shadow-md">
                        {{-- tanggal ambil --}}
                        <div x-data="{
                            datePickerOpen: false,
                            datePickerValue: '',
                            datePickerFormat: 'M d, Y',
                            datePickerMonth: '',
                            datePickerYear: '',
                            datePickerDay: '',
                            datePickerDaysInMonth: [],
                            datePickerBlankDaysInMonth: [],
                            datePickerMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            datePickerDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            datePickerDayClicked(day) {
                                let selectedDate = new Date(this.datePickerYear, this.datePickerMonth, day);
                                this.datePickerDay = day;
                                this.datePickerValue = this.datePickerFormatDate(selectedDate);
                                this.datePickerIsSelectedDate(day);
                                this.datePickerOpen = false;
                            },
                            datePickerPreviousMonth() {
                                if (this.datePickerMonth == 0) {
                                    this.datePickerYear--;
                                    this.datePickerMonth = 12;
                                }
                                this.datePickerMonth--;
                                this.datePickerCalculateDays();
                            },
                            datePickerNextMonth() {
                                if (this.datePickerMonth == 11) {
                                    this.datePickerMonth = 0;
                                    this.datePickerYear++;
                                } else {
                                    this.datePickerMonth++;
                                }
                                this.datePickerCalculateDays();
                            },
                            datePickerIsSelectedDate(day) {
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return this.datePickerValue === this.datePickerFormatDate(d) ? true : false;
                            },
                            datePickerIsToday(day) {
                                const today = new Date();
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return today.toDateString() === d.toDateString() ? true : false;
                            },
                            datePickerCalculateDays() {
                                let daysInMonth = new Date(this.datePickerYear, this.datePickerMonth + 1, 0).getDate();
                                // find where to start calendar day of week
                                let dayOfWeek = new Date(this.datePickerYear, this.datePickerMonth).getDay();
                                let blankdaysArray = [];
                                for (var i = 1; i <= dayOfWeek; i++) {
                                    blankdaysArray.push(i);
                                }
                                let daysArray = [];
                                for (var i = 1; i <= daysInMonth; i++) {
                                    daysArray.push(i);
                                }
                                this.datePickerBlankDaysInMonth = blankdaysArray;
                                this.datePickerDaysInMonth = daysArray;
                            },
                            datePickerFormatDate(date) {
                                let formattedDay = this.datePickerDays[date.getDay()];
                                let formattedDate = ('0' + date.getDate()).slice(-2); // appends 0 (zero) in single digit date
                                let formattedMonth = this.datePickerMonthNames[date.getMonth()];
                                let formattedMonthShortName = this.datePickerMonthNames[date.getMonth()].substring(0, 3);
                                let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
                                let formattedYear = date.getFullYear();

                                if (this.datePickerFormat === 'M d, Y') {
                                    return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'MM-DD-YYYY') {
                                    return `${formattedMonthInNumber}-${formattedDate}-${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'DD-MM-YYYY') {
                                    return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'YYYY-MM-DD') {
                                    return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
                                }
                                if (this.datePickerFormat === 'D d M, Y') {
                                    return `${formattedDay} ${formattedDate} ${formattedMonthShortName} ${formattedYear}`;
                                }

                                return `${formattedMonth} ${formattedDate}, ${formattedYear}`;
                            },
                        }" x-init="currentDate = new Date();
                        if (datePickerValue) {
                            currentDate = new Date(Date.parse(datePickerValue));
                        }
                        datePickerMonth = currentDate.getMonth();
                        datePickerYear = currentDate.getFullYear();
                        datePickerDay = currentDate.getDay();
                        datePickerValue = datePickerFormatDate(currentDate);
                        datePickerCalculateDays();" x-cloak>
                            <div class="container px-4 py-2 mx-auto md:py-1">
                                <div class="w-full mb-5">
                                    <label for="datepicker"
                                        class="block mb-1 text-sm font-medium ps-12 text-neutral-500">Tanggal
                                        Ambil</label>
                                    <div class="relative w-[22rem]">
                                        <input x-ref="datePickerInput" type="text" name="tanggalAmbil"
                                            @click="datePickerOpen=!datePickerOpen" x-model="datePickerValue"
                                            x-on:keydown.escape="datePickerOpen=false"
                                            class="flex w-full h-10 py-2 bg-white border-0 rounded-md text-md ps-12 text-neutral-600 placeholder:text-neutral-400 focus:ring-white ring-0 disabled:cursor-not-allowed disabled:opacity-50"
                                            placeholder="Select date" readonly />
                                        <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                                            class="absolute top-0 left-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                                            class="absolute top-0 right-0 px-3 py-2 text-blue-400 cursor-pointer hover:text-blue-500">
                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" id="fi_2722987">
                                                <g id="_16" data-name="16">
                                                    <path stroke-width="2"
                                                        d="m12 16a1 1 0 0 1 -.71-.29l-6-6a1 1 0 0 1 1.42-1.42l5.29 5.3 5.29-5.29a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1 -.7.29z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div x-show="datePickerOpen" x-transition @click.away="datePickerOpen = false"
                                            class="absolute top-0 left-0 max-w-lg p-4 mt-12 antialiased z-50 bg-white border rounded-lg shadow w-[20rem] border-neutral-200/70">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <span x-text="datePickerMonthNames[datePickerMonth]"
                                                        class="text-lg font-bold text-gray-800"></span>
                                                    <span x-text="datePickerYear"
                                                        class="ml-1 text-lg font-normal text-gray-600"></span>
                                                </div>
                                                <div>
                                                    <button @click="datePickerPreviousMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 19l-7-7 7-7" />
                                                        </svg>
                                                    </button>
                                                    <button @click="datePickerNextMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-7 mb-3">
                                                <template x-for="(day, index) in datePickerDays" :key="index">
                                                    <div class="px-0.5">
                                                        <div x-text="day"
                                                            class="text-xs font-medium text-center text-gray-800">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="grid grid-cols-7">
                                                <template x-for="blankDay in datePickerBlankDaysInMonth">
                                                    <div class="p-1 text-sm text-center border border-transparent">
                                                    </div>
                                                </template>
                                                <template x-for="(day, dayIndex) in datePickerDaysInMonth"
                                                    :key="dayIndex">
                                                    <div class="px-0.5 mb-1 aspect-square">
                                                        <div x-text="day" @click="datePickerDayClicked(day)"
                                                            :class="{
                                                                'bg-neutral-200': datePickerIsToday(day) ==
                                                                    true,
                                                                'text-gray-600 hover:bg-neutral-200': datePickerIsToday(
                                                                        day) == false &&
                                                                    datePickerIsSelectedDate(
                                                                        day) == false,
                                                                'bg-neutral-800 text-white hover:bg-opacity-75': datePickerIsSelectedDate(
                                                                    day) == true
                                                            }"
                                                            class="flex items-center justify-center text-sm leading-none text-center rounded-full cursor-pointer h-7 w-7">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-6 mx-3 text-neutral-400" style="align-content: center">
                            <x-heroicon-o-arrows-right-left />
                        </div>
                        {{-- tanggal kembali --}}
                        <div x-data="{
                            datePickerOpen: false,
                            datePickerValue: '',
                            datePickerFormat: 'M d, Y',
                            datePickerMonth: '',
                            datePickerYear: '',
                            datePickerDay: '',
                            datePickerDaysInMonth: [],
                            datePickerBlankDaysInMonth: [],
                            datePickerMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            datePickerDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            datePickerDayClicked(day) {
                                let selectedDate = new Date(this.datePickerYear, this.datePickerMonth, day);
                                this.datePickerDay = day;
                                this.datePickerValue = this.datePickerFormatDate(selectedDate);
                                this.datePickerIsSelectedDate(day);
                                this.datePickerOpen = false;
                            },
                            datePickerPreviousMonth() {
                                if (this.datePickerMonth == 0) {
                                    this.datePickerYear--;
                                    this.datePickerMonth = 12;
                                }
                                this.datePickerMonth--;
                                this.datePickerCalculateDays();
                            },
                            datePickerNextMonth() {
                                if (this.datePickerMonth == 11) {
                                    this.datePickerMonth = 0;
                                    this.datePickerYear++;
                                } else {
                                    this.datePickerMonth++;
                                }
                                this.datePickerCalculateDays();
                            },
                            datePickerIsSelectedDate(day) {
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return this.datePickerValue === this.datePickerFormatDate(d) ? true : false;
                            },
                            datePickerIsToday(day) {
                                const today = new Date();
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return today.toDateString() === d.toDateString() ? true : false;
                            },
                            datePickerCalculateDays() {
                                let daysInMonth = new Date(this.datePickerYear, this.datePickerMonth + 1, 0).getDate();
                                // find where to start calendar day of week
                                let dayOfWeek = new Date(this.datePickerYear, this.datePickerMonth).getDay();
                                let blankdaysArray = [];
                                for (var i = 1; i <= dayOfWeek; i++) {
                                    blankdaysArray.push(i);
                                }
                                let daysArray = [];
                                for (var i = 1; i <= daysInMonth; i++) {
                                    daysArray.push(i);
                                }
                                this.datePickerBlankDaysInMonth = blankdaysArray;
                                this.datePickerDaysInMonth = daysArray;
                            },
                            datePickerFormatDate(date) {
                                let formattedDay = this.datePickerDays[date.getDay()];
                                let formattedDate = ('0' + date.getDate()).slice(-2); // appends 0 (zero) in single digit date
                                let formattedMonth = this.datePickerMonthNames[date.getMonth()];
                                let formattedMonthShortName = this.datePickerMonthNames[date.getMonth()].substring(0, 3);
                                let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
                                let formattedYear = date.getFullYear();

                                if (this.datePickerFormat === 'M d, Y') {
                                    return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'MM-DD-YYYY') {
                                    return `${formattedMonthInNumber}-${formattedDate}-${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'DD-MM-YYYY') {
                                    return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'YYYY-MM-DD') {
                                    return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
                                }
                                if (this.datePickerFormat === 'D d M, Y') {
                                    return `${formattedDay} ${formattedDate} ${formattedMonthShortName} ${formattedYear}`;
                                }

                                return `${formattedMonth} ${formattedDate}, ${formattedYear}`;
                            },
                        }" x-init="currentDate = new Date();
                        if (datePickerValue) {
                            currentDate = new Date(Date.parse(datePickerValue));
                        }
                        datePickerMonth = currentDate.getMonth();
                        datePickerYear = currentDate.getFullYear();
                        datePickerDay = currentDate.getDay();
                        datePickerValue = datePickerFormatDate(currentDate);
                        datePickerCalculateDays();" x-cloak>
                            <div class="container px-4 py-2 mx-auto md:py-1">
                                <div class="w-full mb-5">
                                    <label for="datepicker"
                                        class="block mb-1 text-sm font-medium ps-12 text-neutral-500">Tanggal
                                        Kembali</label>
                                    <div class="relative w-[20rem]">
                                        <input x-ref="datePickerInput" type="text" name="tanggalKembali"
                                            @click="datePickerOpen=!datePickerOpen" x-model="datePickerValue"
                                            x-on:keydown.escape="datePickerOpen=false"
                                            class="flex w-full h-10 py-2 bg-white border-0 rounded-md text-md ps-12 text-neutral-600 placeholder:text-neutral-400 focus:ring-white ring-0 disabled:cursor-not-allowed disabled:opacity-50"
                                            placeholder="Select date" readonly />
                                        <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                                            class="absolute top-0 left-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                                            class="absolute top-0 right-0 px-3 py-2 text-blue-400 cursor-pointer hover:text-blue-500">
                                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" id="fi_2722987">
                                                <g id="_16" data-name="16">
                                                    <path stroke-width="2"
                                                        d="m12 16a1 1 0 0 1 -.71-.29l-6-6a1 1 0 0 1 1.42-1.42l5.29 5.3 5.29-5.29a1 1 0 0 1 1.41 1.41l-6 6a1 1 0 0 1 -.7.29z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div x-show="datePickerOpen" x-transition @click.away="datePickerOpen = false"
                                            class="absolute z-50 top-0 left-0 max-w-lg p-4 mt-12 antialiased bg-white border rounded-lg shadow w-[17rem] border-neutral-200/70">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <span x-text="datePickerMonthNames[datePickerMonth]"
                                                        class="text-lg font-bold text-gray-800"></span>
                                                    <span x-text="datePickerYear"
                                                        class="ml-1 text-lg font-normal text-gray-600"></span>
                                                </div>
                                                <div>
                                                    <button @click="datePickerPreviousMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 19l-7-7 7-7" />
                                                        </svg>
                                                    </button>
                                                    <button @click="datePickerNextMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-7 mb-3">
                                                <template x-for="(day, index) in datePickerDays" :key="index">
                                                    <div class="px-0.5">
                                                        <div x-text="day"
                                                            class="text-xs font-medium text-center text-gray-800">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="grid grid-cols-7">
                                                <template x-for="blankDay in datePickerBlankDaysInMonth">
                                                    <div class="p-1 text-sm text-center border border-transparent">
                                                    </div>
                                                </template>
                                                <template x-for="(day, dayIndex) in datePickerDaysInMonth"
                                                    :key="dayIndex">
                                                    <div class="px-0.5 mb-1 aspect-square">
                                                        <div x-text="day" @click="datePickerDayClicked(day)"
                                                            :class="{
                                                                'bg-neutral-200': datePickerIsToday(day) ==
                                                                    true,
                                                                'text-gray-600 hover:bg-neutral-200': datePickerIsToday(
                                                                        day) == false &&
                                                                    datePickerIsSelectedDate(
                                                                        day) == false,
                                                                'bg-neutral-800 text-white hover:bg-opacity-75': datePickerIsSelectedDate(
                                                                    day) == true
                                                            }"
                                                            class="flex items-center justify-center text-sm leading-none text-center rounded-full cursor-pointer h-7 w-7">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative p-2 my-3 bg-white border rounded-lg shadow-m">
                        <label for="durasi"
                            class="block px-1 py-2 pt-4 overflow-hidden border-gray-200 rounded-md shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
                            <span class="block mb-1 text-sm font-medium text-neutral-500">Waktu</span>
                        </label>
                        <input type="time" id="durasi" name="durasi" value="10:00"
                            class="w-full pt-0 border-none text-md focus:border-transparent focus:outline-none focus:ring-0 sm:text-md" />
                    </div>
                    <button
                        class="flex items-center justify-between gap-4 px-5 py-2 my-3 text-center transition-colors bg-indigo-600 border border-indigo-600 rounded-lg w-50 ms-auto group focus:outline-none focus:ring hover:bg-indigo-700">
                        <span class="font-medium text-white transition-colors group-active:text-indigo-500">
                            Cari Kendaraan
                        </span>

                        <span
                            class="p-1 text-indigo-600 bg-white border border-current rounded-full shrink-0 group-active:text-indigo-500">
                            <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </section>
        <section class="h-full px-8 pt-10 mx-auto max-w-8xl md:px-12 lg:px-32">
            <div class="grid grid-cols-3">
                <div class="grid col-span-2">
                    <a href="{{ url()->previous() }}" class="text-sm text-blue-500">Kembali ke detail kendaraan</a>
                    <h2 class="text-3xl font-bold">Checkout</h2>
                    <p class="text-sm">Next... Konfirmasi pembayaran </p>
                    <div class="grid grid-cols-3">
                        <div class="mt-4 mr-2 overflow-hidden">
                            <div class="w-full h-2 bg-blue-500 "></div>
                        </div>
                        <div class="mt-4 mr-2 overflow-hidden bg-gray-200">
                            <div class="w-full h-2 bg-blue-500"></div>
                        </div>
                        <div class="mt-4 overflow-hidden bg-gray-200 ">
                            <div class="w-full h-2 bg-blue-500"></div>
                        </div>
                    </div>
                    <div class="p-10 my-5 border border-2 rounded-lg" x-data="{ selectedOption: 'login' }">
                        <div class="w-full max-w-2xl">
                            <div class="mb-4 space-y-4">
                                @if ($isLoggedIn)
                                    <div class="py-2 border-b-2 ">
                                        <label for="login"
                                            class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                            <div>
                                                <p class="text-gray-700">{{ $isLoggedIn->nama_lengkap }}</p>
                                                <p class="mt-1 text-sm text-neutral-400">
                                                    {{ $isLoggedIn->jenis_identitas . '-' . $isLoggedIn->no_identitas }}</p>
                                            </div>
                                            <input type="radio" name="bookingOption" wire:model='form.status'
                                                value="login" required x-model="selectedOption" id="login" checked
                                                class="text-blue-500 border-gray-300 size-5" />
                                        </label>
                                    </div>
                                @else
                                    <div class="py-2 border-b-2">
                                        <label for="login"
                                            class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                            <div>
                                                <p class="text-gray-700">Login Akun Member</p>

                                                <p class="mt-1 text-sm text-neutral-400">Isi identitas dengan identitas
                                                    akun
                                                    member anda</p>
                                            </div>

                                            <input type="radio" name="bookingOption" value="login"
                                                wire:model='form.status' x-model="selectedOption" id="login"
                                                class="text-blue-500 border-gray-300 size-5" />
                                        </label>
                                        <div x-show="selectedOption === 'login'" class="p-2 space-y-5"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform scale-90"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-300"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-90">
                                            <div class="mt-5 space-y-5">
                                                @livewire('auth.login')
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="">
                                    <label for="guest"
                                        class="flex cursor-pointer justify-between gap-4 rounded-lg border border-gray-100 bg-white p-4 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                        <div>
                                            <p class="text-gray-700">Pesan Sebagai Guest</p>

                                            <p class="mt-1 text-sm text-neutral-400">Isi form sesuai dengan identitas
                                                KTP/SIM</p>
                                        </div>

                                        <input type="radio" name="bookingOption" value="guest"
                                            wire:model='form.status' x-model="selectedOption" id="guest"
                                            class="text-blue-500 border-gray-300 size-5" required />
                                    </label>
                                    <div x-show="selectedOption === 'guest'" class="p-2"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-90">
                                        <div class="my-5">
                                            <div class="flex-col space-y-4">
                                                <div class="w-full">
                                                    <label for="name"
                                                        class="block mb-3 text-sm font-medium text-black">
                                                        Nama Lengkap
                                                    </label>
                                                    <input type="text" id="name" placeholder="Your name"
                                                        wire:model='form.nama_lengkap'
                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                </div>
                                                <div class="w-full">
                                                    <label for="telp"
                                                        class="block mb-3 text-sm font-medium text-black">
                                                        Nomor Telephone
                                                    </label>
                                                    <input type="telp" id="telp" placeholder="+62"
                                                        wire:model='form.telp'
                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                </div>
                                                <div class="">
                                                    <label for="jenisIdentitas"
                                                        class="block mb-3 text-sm font-medium text-black">
                                                        Jenis Identitas
                                                    </label>
                                                    <div class="flex">
                                                        <div class="w-[8rem] me-3">
                                                            <select id="jenisIdentitas" wire:model='form.jenis_identitas'
                                                                class="block w-full h-12 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                                <option disabled>Pilih Identitas</option>
                                                                <option value="KTP">KTP</option>
                                                                <option value="SIM">SIM</option>
                                                            </select>
                                                        </div>
                                                        <div class="w-full">
                                                            <input type="text" id="no_identitas"
                                                                wire:model='form.no_identitas' placeholder=""
                                                                class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <label for="email"
                                                        class="block mb-3 text-sm font-medium text-black">
                                                        Email
                                                    </label>
                                                    <input type="email" id="email" wire:model='form.emailGuest'
                                                        placeholder="example@example.com"
                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                    <div>
                                                        @error('emailGuest')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <label for="alamat"
                                                        class="block mb-3 text-sm font-medium text-black">
                                                        alamat
                                                    </label>
                                                    <textarea type="alamat" id="alamat" wire:model='form.alamat' placeholder="Jl. Example"
                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                        </textarea>
                                                    <div>
                                                        @error('alamat')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div x-data="{ isChecked: false }" class="mt-10">
                                                    <div class="flex space-x-3">
                                                        <p class="text-sm text-neutral-500">Saya memesan untuk orang lain
                                                        </p>
                                                        <label for="AcceptConditions"
                                                            class="relative h-6 w-12 cursor-pointer rounded-full bg-gray-300 transition [-webkit-tap-highlight-color:_transparent] has-[:checked]:bg-blue-500">
                                                            <input type="checkbox" id="AcceptConditions"
                                                                wire:model='form.anotherPersonRent' class="sr-only peer"
                                                                x-model="isChecked">
                                                            <span
                                                                class="absolute inset-y-0 m-1 transition-all bg-white rounded-full start-0 size-4 peer-checked:start-6"></span>
                                                        </label>
                                                    </div>

                                                    <!-- Conditionally displayed form based on checkbox -->
                                                    <div x-show="isChecked" class="mt-5 font-medium text-md"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 transform scale-90"
                                                        x-transition:enter-end="opacity-100 transform scale-100"
                                                        x-transition:leave="transition ease-in duration-300"
                                                        x-transition:leave-start="opacity-100 transform scale-100"
                                                        x-transition:leave-end="opacity-0 transform scale-90">
                                                        Detail Pemesan
                                                        <div class="my-5">
                                                            <div class="flex-col space-y-4">
                                                                <div class="w-full">
                                                                    <label for="nama_lengkap"
                                                                        class="block mb-3 text-sm font-medium text-black">
                                                                        Nama Lengkap
                                                                    </label>
                                                                    <input type="nama_lengkap" id="nama_lengkap"
                                                                        placeholder="" wire:model='form.anon_nama_lengkap'
                                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                                </div>
                                                                <div class="w-full">
                                                                    <label for="telp"
                                                                        class="block mb-3 text-sm font-medium text-black">
                                                                        Nomor Telephone
                                                                    </label>
                                                                    <input type="telp" id="telp"
                                                                        placeholder="+62" wire:model='form.anon_telp'
                                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                                </div>
                                                                <div class="w-full">
                                                                    <label for="email"
                                                                        class="block mb-3 text-sm font-medium text-black">
                                                                        Email
                                                                    </label>
                                                                    <input type="email" id="email"
                                                                        wire:model='form.anon_email'
                                                                        placeholder="example@example.com"
                                                                        class="block w-full h-12 px-4 py-2 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="my-5 text-2xl font-medium">Informasi Tambahan</h1>
                    <div class="p-10 my-5 border border-2 rounded-lg shadow-sm" x-data="{ selectedOption: '' }">
                        <div class="w-full max-w-2xl">
                            <div class="mb-4 space-y-4">
                                <div class="w-full">
                                    <label for="tujuan" class="block mb-3 text-sm font-medium text-black">
                                        Tujuan
                                    </label>
                                    <input type="text" id="tujuan" placeholder="Your tujuan"
                                        wire:model='form.tujuan'
                                        class="block w-full h-12 px-4 py-2 text-blue-500 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                </div>
                                <div class="w-full">
                                    <label for="waktu_pengambilan" class="block mb-3 text-sm font-medium text-black">
                                        Waktu
                                    </label>
                                    <input type="time" id="waktu" wire:model='form.waktu' value="10:00"
                                        class="block w-full h-12 px-4 py-2 text-blue-500 duration-200 border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="my-5 text-2xl font-medium">Addons</h1>
                    <div class="grid grid-cols-1 mb-4 space-x-4">
                        <div class="p-5 border border-2 rounded-lg shadow-sm">
                            <div class="flex justify-between">
                                <p class="pb-4 text-xl font-bold">Driver Car</p>
                                <div class="relative" wire:loading wire:loading.attr='disabled' wire:target='addcart'>
                                    <x-navigation.loader-animation />
                                </div>
                            </div>

                            <p>Tambahkan kenyamanan pada perjalanan anda! nikmati layanan mobil dengan driver handal kami
                            </p>
                            <div class="flex justify-between pt-5">
                                @if ($driver['driver'] == false)
                                    <button wire:click="addcart"
                                        class="px-4 py-2 text-white bg-blue-500 border rounded-lg ring-blue-500 focus:ring-1 hover:bg-blue-700 hover:text-white">
                                        add to cart
                                    </button>
                                @else
                                    <button wire:click="addcart"
                                        class="px-4 py-2 text-white border rounded-lg bg-neutral-500 ring-neutral-500 focus:ring-1 hover:bg-neutral-700 hover:text-white">
                                        Hapus
                                    </button>
                                @endif
                                <h2 class="text-lg font-bold">IDR 200.000 <span class="text-sm text-neutral-400">/ Per
                                        Day</span></h2>
                            </div>
                        </div>
                    </div>
                    <h1 class="my-5 text-2xl font-medium">Payment Method</h1>
                    <div class="p-5 my-5 border border-2 rounded-lg shadow-sm" x-data="{ selectedOption: '' }">
                        <div class="w-full">
                            <div class="mb-4 space-y-4">
                                <div class="flex items-center p-2 space-x-2 border-b-2 rounded hover:bg-gray-100">
                                    <input type="radio" id="qris" name="qris" wire:model='form.payment'
                                        value="qris"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="qris" class="flex w-full space-x-3 font-bold text-md"> QRIS </label>
                                </div>
                                <div class="flex items-center p-2 space-x-2 border-b-2 rounded disable:hidden hover:bg-gray-100">
                                    <input type="radio" disabled id="creditcards" name="creditCard" wire:model='form.payment'
                                        value="creditcards"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm disabled:bg-gray-300 disabled:hover:none text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="creditcards" class="flex w-full space-x-3 font-bold text-md"> Credit Cards (Not Availaible right now)
                                    </label>
                                </div>
                                <div class="flex items-center p-2 space-x-2 border-b-2 rounded hover:bg-gray-100">
                                    <input type="radio" id="mandiriva" name="payment" wire:model='form.payment'
                                        value="mandiri"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="mandiriva" class="flex w-full space-x-3 font-bold text-md"> Mandiri
                                        Virtual Account </label>
                                </div>
                                <div class="flex items-center p-2 space-x-2 border-b-2 rounded hover:bg-gray-100">
                                    <input type="radio" id="bcava" name="payment" wire:model='form.payment'
                                        value="bca_va"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="bcava" class="flex w-full space-x-3 font-bold text-md"> BCA Virtual
                                        Account</label>
                                </div>
                                <div class="flex items-center p-2 space-x-2 border-b-2 rounded hover:bg-gray-100">
                                    <input type="radio" id="briva" name="payment" wire:model='form.payment'
                                        value="bri_va"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="briva" class="flex w-full space-x-3 font-bold text-md"> BRI Virtual
                                        Account</label>
                                </div>
                                <div class="flex items-center p-2 space-x-2 border-b-2 rounded hover:bg-gray-100">
                                    <input type="radio" id="bniva" name="payment" wire:model='form.payment'
                                        value="bni_va"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="bniva" class="flex w-full space-x-3 font-bold text-md"> BNI Virtual
                                        Account</label>
                                </div>
                                <div class="flex items-center p-2 space-x-2 rounded hover:bg-gray-100">
                                    <input type="radio" id="alfamart" name="payment" wire:model='form.payment'
                                        value="alfamart"
                                        class="w-4 h-4 border-gray-300 rounded-full shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 focus:ring-offset-0 disabled:cursor-not-allowed disabled:text-gray-400" />
                                    <label for="alfamart" class="flex w-full space-x-3 font-bold text-md">
                                        Alfamart</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-span-2 mt-[5rem] p-5 sidebar">
                    <div class="flex flex-row border rounded-lg shadow-sm">
                        <div class="h-full p-5">
                            <!-- Timeline -->
                            <div>
                                <!-- Heading -->
                                <div class="my-2 ps-2 first:mt-0">
                                    <h3 class="text-xs font-medium text-gray-500 uppercase">
                                        {{ $keyword['keyword']['tanggalAmbil'] }}
                                    </h3>
                                </div>
                                <!-- End Heading -->

                                <!-- Item -->
                                <div class="relative flex rounded-lg gap-x-3 group hover:bg-gray-100">
                                    <a class="absolute inset-0 z-[1]' href="#"></a>

                                    <!-- Icon -->
                                    <div
                                        class="relative last:after:hidden after:absolute after:top-0 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200">
                                        <div class="relative z-10 flex items-center justify-center size-7">
                                            <div
                                                class="bg-white border-2 border-gray-300 rounded-full size-2 group-hover:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Icon -->

                                    <!-- Right Content -->
                                    <div class="p-2 pb-8 grow">
                                        <h3 class="flex gap-x-1.5 font-semibold text-gray-800">
                                            <svg class="flex-shrink-0 mt-1 size-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
                                                </path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" x2="8" y1="13" y2="13">
                                                </line>
                                                <line x1="16" x2="8" y1="17" y2="17">
                                                </line>
                                                <line x1="10" x2="8" y1="9" y2="9">
                                                </line>
                                            </svg>
                                            Hari pengambilan kendaraan
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            pengambilan kendaraan dilakukan pada tanggal
                                            {{ $keyword['keyword']['tanggalAmbil'] }}
                                        </p>
                                        <button type="button"
                                            class="relative z-10 inline-flex items-center p-1 mt-1 text-xs text-gray-500 border border-transparent rounded-lg -ms-1 gap-x-2 hover:bg-white hover:shadow-sm disabled:opacity-50 disabled:pointer-events-none">
                                            <img class="flex-shrink-0 rounded-full size-4"
                                                src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8auto=format&fit=facearea&facepad=3&w=320&h=320&q=80"
                                                alt="Image Description">
                                            Birlyyahya
                                        </button>
                                    </div>
                                    <!-- End Right Content -->
                                </div>
                                <!-- End Item -->
                                <!-- Item -->
                                <div class="relative flex rounded-lg gap-x-3 group hover:bg-gray-100">
                                    <a class="absolute inset-0 z-[1]' href="#"></a>

                                    <!-- Icon -->
                                    <div
                                        class="relative last:after:hidden after:absolute after:top-0 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200">
                                        <div class="relative z-10 flex items-center justify-center size-7">
                                            <div
                                                class="bg-white border-2 border-gray-300 rounded-full size-2 group-hover:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Icon -->

                                    <!-- Right Content -->
                                    <div class="p-2 pb-8 grow">
                                        <h3 class="flex gap-x-1.5 font-semibold text-gray-800">
                                            Waktu Pengambilan
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            waktu pengambilan dan pengembalian pukul {{ $keyword['keyword']['waktu'] }}.
                                        </p>
                                        <button type="button"
                                            class="relative z-10 inline-flex items-center p-1 mt-1 text-xs text-gray-500 border border-transparent rounded-lg -ms-1 gap-x-2 hover:bg-white hover:shadow-sm disabled:opacity-50 disabled:pointer-events-none">
                                            <img class="flex-shrink-0 rounded-full size-4"
                                                src="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80"
                                                alt="Image Description">
                                            Birlyyahya
                                        </button>
                                    </div>
                                    <!-- End Right Content -->
                                </div>
                                <!-- End Item -->

                                <!-- Heading -->
                                <div class="my-2 ps-2 first:mt-0">
                                    <h3 class="text-xs font-medium text-gray-500 uppercase">
                                        {{ $keyword['keyword']['tanggalKembali'] }}
                                    </h3>
                                </div>
                                <!-- End Heading -->

                                <!-- Item -->
                                <div class="relative flex rounded-lg gap-x-3 group hover:bg-gray-100">
                                    <a class="absolute inset-0 z-[1]' href="#"></a>

                                    <!-- Icon -->
                                    <div
                                        class="relative last:after:hidden after:absolute after:top-0 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200">
                                        <div class="relative z-10 flex items-center justify-center size-7">
                                            <div
                                                class="bg-white border-2 border-gray-300 rounded-full size-2 group-hover:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Icon -->

                                    <!-- Right Content -->
                                    <div class="p-2 pb-8 grow">
                                        <h3 class="flex gap-x-1.5 font-semibold text-gray-800">
                                            Hari pengembalian kendaraan
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Pengembalian kendaraan dilakukan pada tanggal
                                            {{ $keyword['keyword']['tanggalKembali'] }}
                                        </p>
                                    </div>
                                    <!-- End Right Content -->

                                </div>
                                <!-- End Item -->
                            </div>
                            <!-- End Timeline -->
                        </div>
                    </div>
                    <div>
                        @livewire('component.rincian-harga', ['mobil' => $mobil, 'driver' => $driver])
                    </div>
                </div>
            </div>
        </section>
        <br>
        <br>
        <br>
        <x-navigation.footer />
    </div>
