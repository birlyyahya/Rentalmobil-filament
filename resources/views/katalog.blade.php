@extends('layouts.app')

@section('content')
    <x-navigation.navbar />

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
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 lg:gap-8">
                <div class="hidden lg:block">
                    @livewire('component.filter-cars')
                </div>
                {{-- Cars --}}
                <div class="flex flex-col gap-6 rounded-lg lg:col-span-3">
                    @foreach ($mobil as $mobs)
                        <article class="bg-white border-2 border-gray-100 shadow-md rounded-xl">
                            <div class="relative flex flex-col items-start gap-4 lg:flex-row">
                                <a href="{{ route('katalog.show', ['id' => $mobs->id, 'tanggalAmbil' => $keyword['tanggalAmbil'],'tanggalKembali' => $keyword['tanggalKembali'],'waktu' => $keyword['waktu'] ]) }}"
                                    class="block shrink-0 max-w-30 lg:max-w-80">
                                    <img alt=""
                                        src="https://images.unsplash.com/photo-1542362567-b07e54358753?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="object-cover w-full rounded-md lg:h-60" />
                                </a>

                                <div class="pt-3" style="width: -webkit-fill-available">
                                    <h3 class="font-medium sm:text-lg">
                                        <a href="#" class="hover:underline"> {{ $mobs->nama_mobil }} </a>
                                    </h3>

                                    <p class="text-sm text-gray-700 line-clamp-2">
                                        {{ $mobs->deskripsi }}
                                    </p>
                                    <div>
                                        <div class="grid grid-flow-col grid-rows-2 gap-4 pt-6 pb-5">
                                            <div>
                                                <div class="text-xs sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                                    <svg class="text-indigo-700 size-5" class=""
                                                        xmlns="http://www.w3.org/2000/svg" id="fi_2260179"
                                                        enable-background="new 0 0 512.032 512.032" height="512"
                                                        viewBox="0 0 512.032 512.032" fill="currentColor"
                                                        stroke="currentColor">
                                                        <path
                                                            d="m304,96c0-8.837-7.163-16-16-16h-160c-8.837,0-16,7.163-16,16v128c0,8.837 7.163,16 16,16h160c8.837,0 16-7.163 16-16v-128zm-32,112h-128v-96h128v96z">
                                                        </path>
                                                        <path
                                                            d="M487.538,113.453l-63.809-32c-7.922-3.969-17.42-0.742-21.373,7.156c-3.953,7.906-0.702,17.516,7.204,21.469l24.301,12.139   c-0.65,1.74-1.491,3.58-1.491,5.549c0,20.832,15.63,38.426,31.63,45.051v194.949c0,8.82-7.18,16-16,16s-16-7.18-16-16v-128   c0-38.631-32-70.949-64-78.383V63.766C368,28.477,340.053,0,304.764,0h-192C77.475,0,48,28.477,48,63.766v358.109l-23.156,11.578   c-5.422,2.711-8.844,8.25-8.844,14.313v48C16,504.602,23.928,512,32.764,512h352C393.6,512,400,504.602,400,495.766v-48   c0-6.063-3.422-11.602-8.844-14.313L368,421.875v-227.16c16,6.625,32,24.219,32,45.051v128c0,26.469,21.531,48,48,48   c26.469,0,48-21.531,48-48v-240C496,121.703,492.96,116.164,487.538,113.453z M368,480H48v-22.344l23.156-11.578   c5.422-2.711,8.844-8.25,8.844-14.313v-368C80,46.117,95.115,32,112.764,32h192C322.412,32,336,46.117,336,63.766v368   c0,6.063,3.422,11.602,8.844,14.313L368,457.656V480z">
                                                        </path>
                                                    </svg>
                                                    <div class="mt-1.5 sm:mt-0">
                                                        <p class="text-gray-500">Fuel</p>

                                                        <p class="font-medium">{{ $mobs->jenis_bbm }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                                    <svg class="text-indigo-700 size-5" xmlns="http://www.w3.org/2000/svg"
                                                        xml:space="preserve"
                                                        style="enable-background:new 0 0 511.999 511.999"
                                                        viewBox="0 0 512.032 512.032" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-width="2" d="M6.575 32.883c-.015-.054.013.055 0 0z" />
                                                        <path stroke-width="2"
                                                            d="M476.941 369.752c-16.625-14.585-37.491-21.077-58.74-18.291l-226.983 29.793-8.959-86.883a490.531 490.531 0 0 0-33.196-139.75l-8.011-20.053a64.697 64.697 0 0 0-33.078-34.843c6.517-14.471 7.464-30.851 2.422-46.153a6.918 6.918 0 0 0-.159-.437A84.34 84.34 0 0 0 33.511.005c-8.32-.164-16.168 3.434-21.458 9.891-5.291 6.458-7.287 14.836-5.478 22.987l75.364 328.866a7.533 7.533 0 1 0 14.706-3.274L45.112 126.961a15.144 15.144 0 0 1 3.088-12.956c2.983-3.64 7.398-5.65 12.095-5.576l21.59.443c4.458.091 8.801.775 12.944 1.983.203.071.408.135.614.188a49.65 49.65 0 0 1 31.619 29.112l8.011 20.053a475.475 475.475 0 0 1 32.183 135.522l.011.124 9.007 87.361-14.305 1.877c-9.679-13.01-26.432-19.876-43.251-16.126-22.793 5.086-37.21 27.769-32.136 50.564l.029.126 18.445 76.641a20.435 20.435 0 0 0 19.928 15.702h289.519c21.377 0 38.792-17.25 39.078-38.56h17.587c19.249 0 34.908-16.815 34.908-37.482.002-25.829-10.618-49.96-29.135-66.205zM93.548 95.051a65.104 65.104 0 0 0-11.352-1.239l-21.59-.443a30.075 30.075 0 0 0-21.714 8.536L21.267 29.551a11.889 11.889 0 0 1 2.438-10.107c2.341-2.858 5.831-4.437 9.497-4.378A69.305 69.305 0 0 1 96.16 58.503a48.64 48.64 0 0 1-2.612 36.548zm31.437 401.884a5.414 5.414 0 0 1-5.281-4.161l-18.429-76.575c-3.232-14.672 6.054-29.255 20.724-32.528 14.691-3.278 29.32 6.01 32.615 20.774l21.51 92.49h-51.139zm346.185-38.56h-84.951a7.532 7.532 0 1 0 0 15.064h52.299c-.285 13.003-10.944 23.496-24.014 23.496H191.59l-5.464-23.496h165.045a7.532 7.532 0 1 0 0-15.064H182.622l-13.321-57.277a41.799 41.799 0 0 0-.429-1.717l251.289-32.983c16.891-2.219 33.528 2.996 46.844 14.677 15.257 13.386 24.008 33.39 24.008 54.882 0 12.362-8.901 22.418-19.843 22.418z" />
                                                    </svg>
                                                    <div class="mt-1.5 sm:mt-0">
                                                        <p class="text-gray-500">Capacity</p>

                                                        <p class="font-medium"> {{ $mobs->kapasitas }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                                    <svg class="text-indigo-700 size-5" viewBox="0 0 512.032 512.032"
                                                        fill="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m205.433 491.171c-32.402-32.037-27.352-85.769 10.589-111.037v-64.255c-7.846-5.255-14.607-12.016-19.862-19.862h-84.138v84.143c37.953 25.476 43.318 79.847 9.721 111.932-28.336 27.063-72.668 26.41-100.31-.92-32.402-32.037-27.352-85.769 10.589-111.037v-248.262c-19.719-13.236-32-35.743-32-59.857 0-40.838 33.988-73.842 75.383-71.922 36.616 1.686 66.413 31.089 68.498 67.741 1.473 25.884-10.806 50.027-31.881 64.063v84.118h84.138c5.255-7.846 12.016-14.607 19.862-19.862v-64.281c-19.719-13.236-32-35.743-32-59.857 0-40.758 33.922-73.845 75.384-71.922 36.616 1.686 66.411 31.089 68.498 67.741 1.472 25.885-10.807 50.028-31.882 64.063v64.255c7.846 5.255 14.608 12.018 19.862 19.862h68.138c8.822 0 16-7.178 16-16v-68.118c-37.902-25.242-43.026-78.965-10.589-111.037 27.644-27.331 71.974-27.982 100.311-.92 33.587 32.077 28.241 86.449-9.722 111.932v68.143c0 52.935-43.065 96-96 96h-68.138c-5.254 7.845-12.017 14.607-19.862 19.862v64.281c19.719 13.236 32 35.743 32 59.857 0 63.753-77.261 95.972-122.589 51.156zm-109.411-227.155h109.396c6.176 0 11.801 3.555 14.452 9.134 3.95 8.314 10.704 15.068 19.018 19.018 5.579 2.65 9.134 8.275 9.134 14.452v82.793c0 6.176-3.555 11.801-9.134 14.452-14.781 7.023-23.73 22.141-22.799 38.515 1.146 20.151 17.847 36.664 38.021 37.593 22.951 1.055 41.912-17.164 41.912-39.956 0-15.362-8.976-29.552-22.866-36.152-5.579-2.65-9.134-8.275-9.134-14.452v-82.793c0-6.176 3.555-11.801 9.134-14.452 8.314-3.951 15.068-10.705 19.018-19.018 2.65-5.579 8.275-9.134 14.452-9.134h77.396c35.29 0 64-28.71 64-64v-77.396c0-6.176 3.555-11.801 9.134-14.452 25.247-11.996 30.81-45.676 10.486-65.085-24.661-23.55-65.641-7.036-67.553 26.57-.932 16.374 8.018 31.492 22.799 38.515 5.579 2.65 9.134 8.275 9.134 14.452v77.396c0 26.467-21.533 48-48 48h-77.396c-6.177 0-11.802-3.555-14.452-9.134-3.949-8.313-10.703-15.067-19.018-19.018-5.579-2.65-9.134-8.275-9.134-14.452v-82.792c0-6.176 3.555-11.801 9.134-14.452 14.781-7.023 23.73-22.141 22.799-38.515-1.146-20.151-17.848-36.664-38.021-37.593-22.891-1.052-41.911 17.11-41.911 39.956 0 15.362 8.976 29.552 22.866 36.152 5.579 2.65 9.134 8.275 9.134 14.452v82.793c0 6.176-3.555 11.801-9.134 14.452-8.314 3.95-15.068 10.704-19.018 19.018-2.65 5.579-8.275 9.134-14.452 9.134h-109.397c-8.836 0-16-7.164-16-16v-109.397c0-6.176 3.555-11.801 9.134-14.452 14.781-7.023 23.73-22.141 22.799-38.515-1.146-20.151-17.847-36.664-38.021-37.593-23.104-1.06-41.912 17.321-41.912 39.956 0 15.362 8.976 29.552 22.866 36.152 5.579 2.65 9.134 8.275 9.134 14.452v266.793c0 6.176-3.555 11.801-9.134 14.452-14.781 7.023-23.73 22.141-22.799 38.515 1.146 20.151 17.847 36.664 38.021 37.593 22.999 1.053 41.912-17.201 41.912-39.956 0-15.362-8.976-29.552-22.866-36.152-5.579-2.65-9.134-8.275-9.134-14.452v-109.397c0-8.836 7.164-16 16-16z">
                                                        </path>
                                                    </svg>
                                                    <div class="mt-1.5 sm:mt-0">
                                                        <p class="text-gray-500">Transmission</p>

                                                        <p class="font-medium"> {{ $mobs->transmisi }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-indigo-600 size-5"
                                                        xml:space="preserve" fill="currentColor"
                                                        viewBox="0 0 512.032 512.032">
                                                        <path stroke-width="2"
                                                            d="M240 0C107.452 0 0 107.452 0 240s107.452 240 240 240 240-107.452 240-240C479.85 107.514 372.486.15 240 0zm215.328 301.552-15.032-4.888-4.952 15.2 15.096 4.904a223.941 223.941 0 0 1-24.688 48.272l-12.8-9.28-9.408 12.944 12.704 9.232a226.173 226.173 0 0 1-38.288 38.344l-9.232-12.704-12.944 9.408 9.28 12.8A223.877 223.877 0 0 1 316.8 450.44l-4.904-15.096-15.2 4.952 4.888 15.032A222.808 222.808 0 0 1 248 463.8V448h-16v15.8a222.755 222.755 0 0 1-53.552-8.472l4.888-15.032-15.2-4.952-4.936 15.096a223.941 223.941 0 0 1-48.272-24.688l9.28-12.8-12.944-9.408-9.232 12.704a226.147 226.147 0 0 1-38.32-38.32l12.704-9.232-9.408-12.944-12.8 9.28A223.872 223.872 0 0 1 29.6 316.8l15.096-4.904-4.952-15.2-15.032 4.888A222.794 222.794 0 0 1 16.2 248H32v-16H16.2a222.755 222.755 0 0 1 8.472-53.552l15.032 4.888 4.952-15.2L29.6 163.2a223.941 223.941 0 0 1 24.688-48.272l12.8 9.28 9.408-12.944-12.776-9.224a226.147 226.147 0 0 1 38.32-38.32l9.232 12.704 12.944-9.408-9.28-12.8A223.865 223.865 0 0 1 163.2 29.6l4.904 15.096 15.2-4.952-4.888-15.032A222.794 222.794 0 0 1 232 16.2V32h16V16.2a222.755 222.755 0 0 1 53.552 8.472l-4.888 15.032 15.2 4.952L316.8 29.6a223.941 223.941 0 0 1 48.272 24.688l-9.28 12.8 12.944 9.408 9.232-12.704a226.147 226.147 0 0 1 38.32 38.32l-12.704 9.232 9.408 12.944 12.8-9.28A223.885 223.885 0 0 1 450.44 163.2l-15.096 4.904 4.952 15.2 15.032-4.888A222.808 222.808 0 0 1 463.8 232H448v16h15.8a222.755 222.755 0 0 1-8.472 53.552z" />
                                                        <path stroke-width="2"
                                                            d="M240 64c-97.202 0-176 78.798-176 176s78.798 176 176 176 176-78.798 176-176c-.11-97.156-78.844-175.89-176-176zm0 336c-88.366 0-160-71.634-160-160S151.634 80 240 80s160 71.634 160 160c-.101 88.323-71.676 159.899-160 160z" />
                                                        <path stroke-width="2"
                                                            d="M240 104c-75.111 0-136 60.889-136 136s60.889 136 136 136 136-60.889 136-136c-.084-75.076-60.924-135.916-136-136zm102.872 74.536a118.956 118.956 0 0 1 16.584 50.744l-50.104-4.048A7.999 7.999 0 0 1 304.8 211.2l38.072-32.664zm-76.16-55.432-19.328 46.4a8 8 0 0 1-14.768 0l-19.328-46.4a116.48 116.48 0 0 1 53.424 0zm-129.584 55.43L175.2 211.2a8 8 0 0 1-4.56 14.048l-50.104 4.048a118.96 118.96 0 0 1 16.592-50.762zm67.368 122.858-11.616 48.944a120.555 120.555 0 0 1-43.128-31.504h-.024l42.816-26.12a8 8 0 0 1 11.952 8.68zm82.624 48.944h-.024l-11.64-48.944a8 8 0 0 1 11.952-8.68l42.816 26.12a120.557 120.557 0 0 1-43.104 31.504zm8.64-71.288c-11.315-6.904-26.084-3.329-32.988 7.986a24.001 24.001 0 0 0-2.86 18.062l12 50.464a116.96 116.96 0 0 1-63.84 0h-.016l12-50.464c3.066-12.895-4.902-25.835-17.798-28.901a23.999 23.999 0 0 0-18.05 2.861l-44.272 27.024a119.198 119.198 0 0 1-19.664-60.728l51.664-4.176c13.21-1.083 23.041-12.671 21.958-25.881a24.003 24.003 0 0 0-8.294-16.255l-39.36-33.76a120.399 120.399 0 0 1 51.64-37.512l19.936 47.864c5.095 12.236 19.145 18.026 31.382 12.93a24 24 0 0 0 12.93-12.93l19.944-47.864a120.455 120.455 0 0 1 51.64 37.512L294.4 199.04c-10.06 8.631-11.218 23.783-2.587 33.842a24.003 24.003 0 0 0 16.275 8.294l51.664 4.176a119.198 119.198 0 0 1-19.664 60.728l-44.328-27.032z" />
                                                        <path stroke-width="2"
                                                            d="M240 208c-17.673 0-32 14.327-32 32s14.327 32 32 32c17.673 0 32-14.327 32-32s-14.327-32-32-32zm0 48c-8.837 0-16-7.163-16-16s7.163-16 16-16 16 7.163 16 16-7.163 16-16 16z" />
                                                    </svg>
                                                    <div class="mt-1.5 sm:mt-0">
                                                        <p class="text-gray-500">Type Cars</p>

                                                        <p class="font-medium">{{ $mobs->kategori->kategori_mobil }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="justify-between sm:flex sm:items-center sm:gap-2">
                                        <div class="flex items-center gap-1 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve"
                                                fill="currentColor" stroke="currentColor" class="w-4 h-4"
                                                style="enable-background:new 0 0 512 512" viewBox="0 0 512 512">
                                                <path
                                                    d="M123.856 71.638H105.66c2.737-20.263 13.941-21.281 19.097-21.75a10 10 0 0 0 9.094-9.959V10.004c0-2.749-1.132-5.378-3.13-7.267S126.033-.131 123.29.02C91.68 1.798 54 17.758 54 83.696v52.04c0 8.687 7.067 15.754 15.754 15.754h54.103c8.687 0 15.754-7.068 15.753-15.755V87.392c0-8.687-7.067-15.754-15.754-15.754zm-4.245 59.851H74V83.696c0-46.01 20.461-58.86 39.851-62.487v10.514c-13.391 4.076-28.803 16.114-28.803 49.915 0 5.523 4.477 10 10 10h24.563v39.851zM226.091 71.638h-18.197c2.737-20.263 13.941-21.281 19.097-21.75a10 10 0 0 0 9.094-9.959V10.004c0-2.749-1.132-5.378-3.13-7.267s-4.69-2.868-7.431-2.717c-31.61 1.778-69.29 17.738-69.29 83.676v52.04c0 8.687 7.067 15.754 15.754 15.754h54.103c8.687 0 15.755-7.068 15.754-15.756V87.392c0-8.687-7.067-15.754-15.754-15.754zm-4.246 59.852h-45.611V83.696c0-46.01 20.461-58.86 39.851-62.487v10.514c-13.391 4.076-28.803 16.114-28.803 49.915 0 5.523 4.477 10 10 10h24.563v39.852zM285.07 80.795c-1.86-1.86-4.44-2.93-7.07-2.93s-5.21 1.07-7.07 2.93-2.93 4.44-2.93 7.07 1.07 5.21 2.93 7.07c1.86 1.86 4.44 2.93 7.07 2.93s5.21-1.07 7.07-2.93 2.93-4.44 2.93-7.07-1.07-5.21-2.93-7.07z" />
                                                <path
                                                    d="M334.267 77.864h-12.601c-5.523 0-10 4.477-10 10s4.477 10 10 10h12.601C421.241 97.864 492 168.623 492 255.597c0 74.232-52.648 139.152-125.187 154.365a10 10 0 0 0-7.947 9.787v58.104l-61.594-61.594a10.001 10.001 0 0 0-7.071-2.929H177.733C90.759 413.33 20 342.571 20 255.597c0-26.805 6.843-53.274 19.79-76.548 2.686-4.826.949-10.915-3.877-13.6-4.827-2.686-10.916-.949-13.6 3.877C7.715 195.565 0 225.397 0 255.597 0 353.6 79.73 433.33 177.733 433.33h108.326l75.736 75.736a9.997 9.997 0 0 0 10.898 2.167 9.999 9.999 0 0 0 6.173-9.238v-74.321c36.183-9.376 68.9-30.239 92.807-59.343C497.678 336.674 512 296.638 512 255.597c0-98.002-79.73-177.732-177.733-177.733z" />
                                                <path
                                                    d="M379.064 177.492H132.937c-5.523 0-10 4.477-10 10s4.477 10 10 10h246.126c5.523 0 10.001-4.477 10.001-10s-4.477-10-10-10zM379.064 230.825H132.937c-5.523 0-10 4.477-10 10s4.477 10 10 10h246.126c5.523 0 10.001-4.477 10.001-10s-4.477-10-10-10zM379.064 284.158H132.937c-5.523 0-10 4.478-10 10s4.477 10 10 10h246.126c5.523 0 10.001-4.478 10.001-10s-4.477-10-10-10zM379.063 337.492H247.871c-5.523 0-10 4.478-10 10s4.477 10 10 10h131.192c5.523 0 10-4.478 10-10s-4.477-10-10-10zM191.607 337.491h-.161c-5.523 0-10 4.478-10 10s4.477 10 10 10h.161c5.523 0 10-4.478 10-10s-4.477-10-10-10z" />
                                            </svg>

                                            <p class="text-xs">{{ $mobs->countReviews }} Reviews</p>
                                        </div>
                                        <div class="shrink-0">
                                            <p class="text-lg font-bold text-blue-600">
                                                {{ Number::currency($mobs->harga_sewa, 'IDR') }}<span
                                                    class="font-medium text-neutral-400"> /day</span></p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('katalog.show', ['id' => $mobs->id, 'tanggalAmbil' => $keyword['tanggalAmbil'],'tanggalKembali' => $keyword['tanggalKembali'],'waktu' => $keyword['waktu'] ]) }}"
                                    class="self-end p-2 font-medium text-white text-md bg-neutral-400 rounded-ee-lg rounded-ss-lg ring-blue-500 hover:text-white hover:bg-blue-600 shrink-0 ms-auto">Booked
                                    Now</a>
                                <strong
                                    class=" absolute -mb-[2px] -me-[2px] inline-flex items-center gap-1 rounded-tl-md top-0 left-0 rounded-br-xl bg-green-600 px-3 py-1.5 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>

                                    <span class="text-[10px] font-medium sm:text-xs">Verified!</span>
                                </strong>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="lg:hidden">
                    @livewire('component.filter-cars')
                </div>

            </div>
        </div>
    </section>

    <x-navigation.footer />
@endsection
