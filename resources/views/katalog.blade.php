@extends('layouts.app')

@section('content')
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
                            <p class="text-xs font-bold">{{ $keyword['tanggalAmbil'] }}</p>
                        </div>
                        <div class="flex-rows">
                            <p class="text-sm">Tanggal Kembali</p>
                            <p class="text-xs font-bold">{{ $keyword['tanggalKembali'] }}</p>
                        </div>
                        <div class="flex-rows me-20">
                            <p class="text-sm">Waktu</p>
                            <p class="text-xs font-bold">{{ $keyword['waktu'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="h-32 py-12 text-center rounded-lg">
                    <button @click="open = ! open"
                        class="inline-flex items-center gap-2 px-8 py-3 text-white bg-indigo-600 border border-indigo-600 rounded hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                        href="#">

                        <svg version="1.1" id="fi_622669" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" class=" size-5" fill="currentColor" stroke="none"
                            viewBox="0 0 512.005 512.005" style="enable-background:new 0 0 512.005 512.005;"
                            xml:space="preserve">
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

    <section>
        <div class="h-auto px-8 py-24 mx-auto max-w-8xl md:px-12 lg:px-32">
            @livewire('component.filter-cars',['mobil'=>$mobil,'keyword'=>$keyword])
        </div>
    </section>

    <x-navigation.footer />
@endsection
