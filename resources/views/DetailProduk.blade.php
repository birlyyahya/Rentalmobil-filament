@extends('layouts.app')

@section('content')
    @livewire('component.navbar')

    <section x-data="{
        open: false
    }">
        <div class="h-full px-8 pt-24 pb-20 mx-auto max-w-8xl md:px-12 lg:px-32">
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

    <section class="h-full px-8 pt-10 mx-auto max-w-8xl md:px-12 lg:px-32">
        <div class="grid grid-cols-3">
            <div class="grid col-span-2">
                <a href="{{ url()->previous() }}" class="text-sm">Kembali ke pencarian</a>
                <h2 class="text-3xl font-bold">Pilihan Mobil Anda</h2>
                <p class="text-sm">Next... Proses Pemesanan </p>
                <div class="grid grid-cols-3">
                    <div class="mt-4 mr-2 overflow-hidden">
                        <div class="w-full h-2 bg-blue-500 "></div>
                    </div>
                    <div class="mt-4 mr-2 overflow-hidden bg-gray-200">
                        <div class="w-full h-2 bg-blue-500"></div>
                    </div>
                    <div class="mt-4 overflow-hidden bg-gray-200 ">
                        <div class="w-full h-2"></div>
                    </div>
                </div>
                <div class="flex p-4 mt-3 text-sm text-green-500 rounded-md bg-green-50" x-cloak x-show="showAlert"
                    x-data="{ showAlert: true }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="flex-shrink-0 w-5 h-5 mr-3">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                    <div><b>Success alert</b> Lorem ipsum dolor sit amet. Internos reprehenderit perspiciatis commodi et
                        omnis impedit.</div>
                </div>
                <div class="grid grid-cols-2 gap-5 mt-10">
                    @livewire('component.gallery-cars', ['id' => $mobil->id])
                    <div class="flex flex-col">
                        <p class="text-xl font-bold">{{ $mobil->nama_mobil }}</p>
                        <div class="flex mt-2">
                            <hr class="w-40 h-1 my-3 mr-2 border-0 rounded-lg bg-neutral-300" />
                            <hr class="w-8 h-1 mx-2 my-3 bg-yellow-300 border-0 rounded-lg" />
                            <hr class="w-5 h-1 mx-2 my-3 border-0 rounded-lg bg-neutral-300" />
                        </div>
                        <div class="mt-2 text-sm text-neutral-600">{{ $mobil->deskripsi }}</div>
                        <div class="grid grid-cols-3 gap-4 my-10">
                            <div class="p-3 text-center border rounded-md">
                                <svg class="m-auto text-center text-indigo-700 size-5" class=""
                                    xmlns="http://www.w3.org/2000/svg" id="fi_2260179"
                                    enable-background="new 0 0 512.032 512.032" height="512"
                                    viewBox="0 0 512.032 512.032" fill="currentColor" stroke="currentColor">
                                    <path
                                        d="m304,96c0-8.837-7.163-16-16-16h-160c-8.837,0-16,7.163-16,16v128c0,8.837 7.163,16 16,16h160c8.837,0 16-7.163 16-16v-128zm-32,112h-128v-96h128v96z">
                                    </path>
                                    <path
                                        d="M487.538,113.453l-63.809-32c-7.922-3.969-17.42-0.742-21.373,7.156c-3.953,7.906-0.702,17.516,7.204,21.469l24.301,12.139   c-0.65,1.74-1.491,3.58-1.491,5.549c0,20.832,15.63,38.426,31.63,45.051v194.949c0,8.82-7.18,16-16,16s-16-7.18-16-16v-128   c0-38.631-32-70.949-64-78.383V63.766C368,28.477,340.053,0,304.764,0h-192C77.475,0,48,28.477,48,63.766v358.109l-23.156,11.578   c-5.422,2.711-8.844,8.25-8.844,14.313v48C16,504.602,23.928,512,32.764,512h352C393.6,512,400,504.602,400,495.766v-48   c0-6.063-3.422-11.602-8.844-14.313L368,421.875v-227.16c16,6.625,32,24.219,32,45.051v128c0,26.469,21.531,48,48,48   c26.469,0,48-21.531,48-48v-240C496,121.703,492.96,116.164,487.538,113.453z M368,480H48v-22.344l23.156-11.578   c5.422-2.711,8.844-8.25,8.844-14.313v-368C80,46.117,95.115,32,112.764,32h192C322.412,32,336,46.117,336,63.766v368   c0,6.063,3.422,11.602,8.844,14.313L368,457.656V480z">
                                    </path>
                                </svg>
                                <label for="">{{ $mobil->jenis_bbm }}</label>
                            </div>
                            <div class="p-3 text-center border rounded-md">
                                <svg class="m-auto text-indigo-700 size-5" xmlns="http://www.w3.org/2000/svg"
                                    xml:space="preserve" style="enable-background:new 0 0 511.999 511.999"
                                    viewBox="0 0 512.032 512.032" fill="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" d="M6.575 32.883c-.015-.054.013.055 0 0z" />
                                    <path stroke-width="2"
                                        d="M476.941 369.752c-16.625-14.585-37.491-21.077-58.74-18.291l-226.983 29.793-8.959-86.883a490.531 490.531 0 0 0-33.196-139.75l-8.011-20.053a64.697 64.697 0 0 0-33.078-34.843c6.517-14.471 7.464-30.851 2.422-46.153a6.918 6.918 0 0 0-.159-.437A84.34 84.34 0 0 0 33.511.005c-8.32-.164-16.168 3.434-21.458 9.891-5.291 6.458-7.287 14.836-5.478 22.987l75.364 328.866a7.533 7.533 0 1 0 14.706-3.274L45.112 126.961a15.144 15.144 0 0 1 3.088-12.956c2.983-3.64 7.398-5.65 12.095-5.576l21.59.443c4.458.091 8.801.775 12.944 1.983.203.071.408.135.614.188a49.65 49.65 0 0 1 31.619 29.112l8.011 20.053a475.475 475.475 0 0 1 32.183 135.522l.011.124 9.007 87.361-14.305 1.877c-9.679-13.01-26.432-19.876-43.251-16.126-22.793 5.086-37.21 27.769-32.136 50.564l.029.126 18.445 76.641a20.435 20.435 0 0 0 19.928 15.702h289.519c21.377 0 38.792-17.25 39.078-38.56h17.587c19.249 0 34.908-16.815 34.908-37.482.002-25.829-10.618-49.96-29.135-66.205zM93.548 95.051a65.104 65.104 0 0 0-11.352-1.239l-21.59-.443a30.075 30.075 0 0 0-21.714 8.536L21.267 29.551a11.889 11.889 0 0 1 2.438-10.107c2.341-2.858 5.831-4.437 9.497-4.378A69.305 69.305 0 0 1 96.16 58.503a48.64 48.64 0 0 1-2.612 36.548zm31.437 401.884a5.414 5.414 0 0 1-5.281-4.161l-18.429-76.575c-3.232-14.672 6.054-29.255 20.724-32.528 14.691-3.278 29.32 6.01 32.615 20.774l21.51 92.49h-51.139zm346.185-38.56h-84.951a7.532 7.532 0 1 0 0 15.064h52.299c-.285 13.003-10.944 23.496-24.014 23.496H191.59l-5.464-23.496h165.045a7.532 7.532 0 1 0 0-15.064H182.622l-13.321-57.277a41.799 41.799 0 0 0-.429-1.717l251.289-32.983c16.891-2.219 33.528 2.996 46.844 14.677 15.257 13.386 24.008 33.39 24.008 54.882 0 12.362-8.901 22.418-19.843 22.418z" />
                                </svg>
                                <label for="">{{ $mobil->kapasitas }} Seats</label>
                            </div>
                            <div class="p-3 text-center border rounded-md">
                                <svg class="m-auto text-indigo-700 size-5" viewBox="0 0 512.032 512.032"
                                    fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m205.433 491.171c-32.402-32.037-27.352-85.769 10.589-111.037v-64.255c-7.846-5.255-14.607-12.016-19.862-19.862h-84.138v84.143c37.953 25.476 43.318 79.847 9.721 111.932-28.336 27.063-72.668 26.41-100.31-.92-32.402-32.037-27.352-85.769 10.589-111.037v-248.262c-19.719-13.236-32-35.743-32-59.857 0-40.838 33.988-73.842 75.383-71.922 36.616 1.686 66.413 31.089 68.498 67.741 1.473 25.884-10.806 50.027-31.881 64.063v84.118h84.138c5.255-7.846 12.016-14.607 19.862-19.862v-64.281c-19.719-13.236-32-35.743-32-59.857 0-40.758 33.922-73.845 75.384-71.922 36.616 1.686 66.411 31.089 68.498 67.741 1.472 25.885-10.807 50.028-31.882 64.063v64.255c7.846 5.255 14.608 12.018 19.862 19.862h68.138c8.822 0 16-7.178 16-16v-68.118c-37.902-25.242-43.026-78.965-10.589-111.037 27.644-27.331 71.974-27.982 100.311-.92 33.587 32.077 28.241 86.449-9.722 111.932v68.143c0 52.935-43.065 96-96 96h-68.138c-5.254 7.845-12.017 14.607-19.862 19.862v64.281c19.719 13.236 32 35.743 32 59.857 0 63.753-77.261 95.972-122.589 51.156zm-109.411-227.155h109.396c6.176 0 11.801 3.555 14.452 9.134 3.95 8.314 10.704 15.068 19.018 19.018 5.579 2.65 9.134 8.275 9.134 14.452v82.793c0 6.176-3.555 11.801-9.134 14.452-14.781 7.023-23.73 22.141-22.799 38.515 1.146 20.151 17.847 36.664 38.021 37.593 22.951 1.055 41.912-17.164 41.912-39.956 0-15.362-8.976-29.552-22.866-36.152-5.579-2.65-9.134-8.275-9.134-14.452v-82.793c0-6.176 3.555-11.801 9.134-14.452 8.314-3.951 15.068-10.705 19.018-19.018 2.65-5.579 8.275-9.134 14.452-9.134h77.396c35.29 0 64-28.71 64-64v-77.396c0-6.176 3.555-11.801 9.134-14.452 25.247-11.996 30.81-45.676 10.486-65.085-24.661-23.55-65.641-7.036-67.553 26.57-.932 16.374 8.018 31.492 22.799 38.515 5.579 2.65 9.134 8.275 9.134 14.452v77.396c0 26.467-21.533 48-48 48h-77.396c-6.177 0-11.802-3.555-14.452-9.134-3.949-8.313-10.703-15.067-19.018-19.018-5.579-2.65-9.134-8.275-9.134-14.452v-82.792c0-6.176 3.555-11.801 9.134-14.452 14.781-7.023 23.73-22.141 22.799-38.515-1.146-20.151-17.848-36.664-38.021-37.593-22.891-1.052-41.911 17.11-41.911 39.956 0 15.362 8.976 29.552 22.866 36.152 5.579 2.65 9.134 8.275 9.134 14.452v82.793c0 6.176-3.555 11.801-9.134 14.452-8.314 3.95-15.068 10.704-19.018 19.018-2.65 5.579-8.275 9.134-14.452 9.134h-109.397c-8.836 0-16-7.164-16-16v-109.397c0-6.176 3.555-11.801 9.134-14.452 14.781-7.023 23.73-22.141 22.799-38.515-1.146-20.151-17.847-36.664-38.021-37.593-23.104-1.06-41.912 17.321-41.912 39.956 0 15.362 8.976 29.552 22.866 36.152 5.579 2.65 9.134 8.275 9.134 14.452v266.793c0 6.176-3.555 11.801-9.134 14.452-14.781 7.023-23.73 22.141-22.799 38.515 1.146 20.151 17.847 36.664 38.021 37.593 22.999 1.053 41.912-17.201 41.912-39.956 0-15.362-8.976-29.552-22.866-36.152-5.579-2.65-9.134-8.275-9.134-14.452v-109.397c0-8.836 7.164-16 16-16z">
                                    </path>
                                </svg>
                                <label for="">{{ $mobil->transmisi }}</label>
                            </div>
                            <div class="p-3 text-center border rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="m-auto text-indigo-600 size-5"
                                    xml:space="preserve" fill="currentColor" viewBox="0 0 512.032 512.032">
                                    <path stroke-width="2"
                                        d="M240 0C107.452 0 0 107.452 0 240s107.452 240 240 240 240-107.452 240-240C479.85 107.514 372.486.15 240 0zm215.328 301.552-15.032-4.888-4.952 15.2 15.096 4.904a223.941 223.941 0 0 1-24.688 48.272l-12.8-9.28-9.408 12.944 12.704 9.232a226.173 226.173 0 0 1-38.288 38.344l-9.232-12.704-12.944 9.408 9.28 12.8A223.877 223.877 0 0 1 316.8 450.44l-4.904-15.096-15.2 4.952 4.888 15.032A222.808 222.808 0 0 1 248 463.8V448h-16v15.8a222.755 222.755 0 0 1-53.552-8.472l4.888-15.032-15.2-4.952-4.936 15.096a223.941 223.941 0 0 1-48.272-24.688l9.28-12.8-12.944-9.408-9.232 12.704a226.147 226.147 0 0 1-38.32-38.32l12.704-9.232-9.408-12.944-12.8 9.28A223.872 223.872 0 0 1 29.6 316.8l15.096-4.904-4.952-15.2-15.032 4.888A222.794 222.794 0 0 1 16.2 248H32v-16H16.2a222.755 222.755 0 0 1 8.472-53.552l15.032 4.888 4.952-15.2L29.6 163.2a223.941 223.941 0 0 1 24.688-48.272l12.8 9.28 9.408-12.944-12.776-9.224a226.147 226.147 0 0 1 38.32-38.32l9.232 12.704 12.944-9.408-9.28-12.8A223.865 223.865 0 0 1 163.2 29.6l4.904 15.096 15.2-4.952-4.888-15.032A222.794 222.794 0 0 1 232 16.2V32h16V16.2a222.755 222.755 0 0 1 53.552 8.472l-4.888 15.032 15.2 4.952L316.8 29.6a223.941 223.941 0 0 1 48.272 24.688l-9.28 12.8 12.944 9.408 9.232-12.704a226.147 226.147 0 0 1 38.32 38.32l-12.704 9.232 9.408 12.944 12.8-9.28A223.885 223.885 0 0 1 450.44 163.2l-15.096 4.904 4.952 15.2 15.032-4.888A222.808 222.808 0 0 1 463.8 232H448v16h15.8a222.755 222.755 0 0 1-8.472 53.552z" />
                                    <path stroke-width="2"
                                        d="M240 64c-97.202 0-176 78.798-176 176s78.798 176 176 176 176-78.798 176-176c-.11-97.156-78.844-175.89-176-176zm0 336c-88.366 0-160-71.634-160-160S151.634 80 240 80s160 71.634 160 160c-.101 88.323-71.676 159.899-160 160z" />
                                    <path stroke-width="2"
                                        d="M240 104c-75.111 0-136 60.889-136 136s60.889 136 136 136 136-60.889 136-136c-.084-75.076-60.924-135.916-136-136zm102.872 74.536a118.956 118.956 0 0 1 16.584 50.744l-50.104-4.048A7.999 7.999 0 0 1 304.8 211.2l38.072-32.664zm-76.16-55.432-19.328 46.4a8 8 0 0 1-14.768 0l-19.328-46.4a116.48 116.48 0 0 1 53.424 0zm-129.584 55.43L175.2 211.2a8 8 0 0 1-4.56 14.048l-50.104 4.048a118.96 118.96 0 0 1 16.592-50.762zm67.368 122.858-11.616 48.944a120.555 120.555 0 0 1-43.128-31.504h-.024l42.816-26.12a8 8 0 0 1 11.952 8.68zm82.624 48.944h-.024l-11.64-48.944a8 8 0 0 1 11.952-8.68l42.816 26.12a120.557 120.557 0 0 1-43.104 31.504zm8.64-71.288c-11.315-6.904-26.084-3.329-32.988 7.986a24.001 24.001 0 0 0-2.86 18.062l12 50.464a116.96 116.96 0 0 1-63.84 0h-.016l12-50.464c3.066-12.895-4.902-25.835-17.798-28.901a23.999 23.999 0 0 0-18.05 2.861l-44.272 27.024a119.198 119.198 0 0 1-19.664-60.728l51.664-4.176c13.21-1.083 23.041-12.671 21.958-25.881a24.003 24.003 0 0 0-8.294-16.255l-39.36-33.76a120.399 120.399 0 0 1 51.64-37.512l19.936 47.864c5.095 12.236 19.145 18.026 31.382 12.93a24 24 0 0 0 12.93-12.93l19.944-47.864a120.455 120.455 0 0 1 51.64 37.512L294.4 199.04c-10.06 8.631-11.218 23.783-2.587 33.842a24.003 24.003 0 0 0 16.275 8.294l51.664 4.176a119.198 119.198 0 0 1-19.664 60.728l-44.328-27.032z" />
                                    <path stroke-width="2"
                                        d="M240 208c-17.673 0-32 14.327-32 32s14.327 32 32 32c17.673 0 32-14.327 32-32s-14.327-32-32-32zm0 48c-8.837 0-16-7.163-16-16s7.163-16 16-16 16 7.163 16 16-7.163 16-16 16z" />
                                </svg>
                                <label for="">{{ $mobil->Kategori->kategori_mobil }}</label>
                            </div>
                        </div>
                        <p class="text-sm text-neutral-600">{{ $mobil->kategori->deskripsi_kategori }}</p>
                    </div>
                </div>
                <div class="w-full h-1 mt-20 rounded-lg bg-neutral-200"></div>

                {{-- testimoni --}}

                <div class="p-5 testimoni">
                    <link href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" rel="stylesheet" />

                    <script type="module">
                        import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

                        const keenSlider = new KeenSlider(
                            '#keen-slider', {
                                loop: true,
                                slides: {
                                    origin: 'center',
                                    perView: 1.25,
                                    spacing: 16,
                                },
                                breakpoints: {
                                    '(min-width: 1024px)': {
                                        slides: {
                                            origin: 'auto',
                                            perView: 2.5,
                                            spacing: 32,
                                        },
                                    },
                                },
                            },
                            []
                        )

                        const keenSliderPrevious = document.getElementById('keen-slider-previous')
                        const keenSliderNext = document.getElementById('keen-slider-next')

                        keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
                        keenSliderNext.addEventListener('click', () => keenSlider.next())
                    </script>

                    <div class="items-end justify-between sm:flex sm:pe-6 lg:pe-8">
                        <h2 class="max-w-xl text-2xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                            Reviews from our customers
                        </h2>

                        <div class="flex gap-4 mt-8 lg:mt-0">
                            <button aria-label="Previous slide" id="keen-slider-previous"
                                class="p-3 transition border rounded-full border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 rtl:rotate-180">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>

                            <button aria-label="Next slide" id="keen-slider-next"
                                class="p-3 transition border rounded-full border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white">
                                <svg class="size-5 rtl:rotate-180" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div id="keen-slider" class="max-w-3xl mt-10 keen-slider">
                        @forelse ($review as $test)
                            <div class="keen-slider__slide">
                                <blockquote class="p-6 rounded-lg shadow-sm bg-gray-50 sm:p-8">
                                    <div class="flex items-center gap-4">
                                        <img alt=""
                                            src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1180&q=80"
                                            class="object-cover rounded-full size-14" />
                                        <div>
                                            <div class="flex gap-0.5 text-green-500">
                                                @for ($i = 0; $i < $test->rating; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <p class="mt-0.5 text-sm font-medium text-gray-900">
                                                {{ $test->customer->nama_lengkap }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-sm text-gray-700">
                                        {{ $test->keterangan }}
                                    </p>
                                </blockquote>
                            </div>
                        @empty
                            <h2 class="text-lg font-bold text-center text-neutral-400">Belum Ada Review</h2>
                        @endforelse
                    </div>
                </div>

                {{-- Kebijakan --}}
                <div class="w-full h-1 mt-20 rounded-lg bg-neutral-200"></div>
                <section>
                    <div class="divide-y divide-gray-100">
                        <details class="group" open>
                            <summary
                                class="flex items-center justify-between py-4 text-lg font-medium list-none cursor-pointer text-secondary-900">
                                <h1 id="Syarat dan Ketentuan" class="font-bold text-md">
                                    Harga Belum Termasuk
                                </h1>
                                <div class="text-secondary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="block w-5 h-5 transition-all duration-300 group-open:rotate-180">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </summary>
                            <div class="max-w-screen-xl py-2 sm:py-8 lg:py-10">
                                <div class="grid grid-cols-1 gap-y-8 lg:grid-cols-3 lg:items-center lg:gap-x-16">
                                    <div class="grid grid-cols-2 col-span-2 gap-4 text-sm text-gray-500 sm:grid-cols-2">
                                        <p>Biaya Driver</p>
                                        <p>Biaya pengambilan dan pengantaran kendaraan di luar lokasi vendor.</p>
                                        <p>Bensin, Tol, dan Parkir</p>
                                        <p>Deposit, e-tilang, dan penggunaan overtime.</p>
                                        <p>Asuransi kerusakan kendaraan, kehilangan, dan kecelakaan.</p>
                                        <p>Biaya tambahan jika melewati jarak tempuh maksimum.</p>
                                    </div>

                                    <div class="max-w-lg mx-auto text-center lg:mx-0 ltr:lg:text-left rtl:lg:text-right">
                                        <img src="{{ url('storage/heroimage/illustrationnotinclude.png') }}"
                                            alt="" class="object-cover rounded-lg size-full" />

                                    </div>
                                </div>
                                <div class="flex p-4 mt-5 text-sm text-yellow-500 rounded-md bg-yellow-50" x-cloak
                                    x-show="showAlert" x-data="{ showAlert: true }">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="flex-shrink-0 w-5 h-5 mr-3">
                                        <path fill-rule="evenodd"
                                            d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div><b>Harap Dicatat</b> Harga belum termasuk dalam biaya supir</div>
                                </div>
                            </div>
                        </details>
                        <details class="group">
                            <summary
                                class="flex items-center justify-between py-4 text-lg font-medium list-none cursor-pointer text-secondary-900">
                                <h1 id="Syarat dan Ketentuan" class="font-bold text-md">
                                    Syarat dan Ketentuan
                                </h1>
                                <div class="text-secondary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="block w-5 h-5 transition-all duration-300 group-open:rotate-180">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </summary>
                            <div class="prose-sm prose text-gray-500">
                                <p>Syarat dan Ketentuan</p>
                                <ul> Pendaftaran dan Identitas Penyewa
                                    <li>
                                        Penyewa harus berusia minimal 18 tahun dan memiliki SIM (Surat Izin Mengemudi) yang
                                        masih berlaku.
                                    </li>
                                    <li>
                                        Penyewa wajib menyediakan salinan identitas resmi (KTP/SIM/Passport) dan SIM yang
                                        masih berlaku saat melakukan pendaftaran.
                                    </li>
                                    <li>
                                        Informasi yang disediakan oleh penyewa harus akurat dan lengkap.
                                    </li>
                                </ul>
                                <ul>Ketentuan Penyewaan
                                    <li>
                                        Penyewaan mobil dilakukan melalui website dan harus dilakukan minimal 24 jam sebelum
                                        waktu pengambilan.
                                    </li>
                                    <li>
                                        Penyewa wajib memilih jenis mobil yang tersedia sesuai dengan kebutuhan dan
                                        melakukan pembayaran sesuai dengan tarif yang ditentukan.
                                    </li>
                                </ul>
                                <ul>Pembayaran
                                    <li>
                                        Semua pembayaran yang sudah dilakukan tidak dapat dikembalikan, kecuali dalam
                                        kondisi tertentu yang diatur dalam kebijakan pengembalian dana.
                                    </li>
                                </ul>
                                <ul>Pengambilan dan Pengembalian Mobil
                                    <li>
                                        Penyewa bertanggung jawab untuk memeriksa kondisi mobil sebelum pengambilan dan
                                        melaporkan kerusakan atau cacat yang ada kepada pihak rental.
                                    </li>
                                </ul>
                                <ul> Penggunaan Mobil
                                    <li>
                                        Mobil hanya boleh digunakan untuk keperluan pribadi dan tidak boleh digunakan untuk
                                        tujuan komersial tanpa izin tertulis dari pihak rental.
                                    </li>
                                    <li>
                                        Penyewa dilarang menggunakan mobil untuk kegiatan ilegal atau yang melanggar hukum.
                                    </li>
                                    <li>
                                        Penyewa wajib mematuhi semua peraturan lalu lintas dan hukum yang berlaku selama
                                        menggunakan mobil.
                                    </li>
                                </ul>
                                <ul> Tanggung Jawab dan Asuransi
                                    <li>
                                        Penyewa bertanggung jawab penuh atas segala kerusakan atau kehilangan mobil selama
                                        masa sewa.
                                    </li>
                                    <li>
                                        Penyewa wajib melaporkan setiap kecelakaan atau kerusakan kepada pihak rental segera
                                        setelah kejadian.
                                    </li>
                                </ul>
                                <ul>Pembatalan dan Pengembalian Dana
                                    <li>
                                        Pembatalan penyewaan harus dilakukan minimal 24 jam sebelum waktu pengambilan untuk
                                        mendapatkan pengembalian dana penuh.
                                    </li>
                                    <li>
                                        Pembatalan yang dilakukan kurang dari 24 jam sebelum waktu pengambilan akan
                                        dikenakan biaya pembatalan sebesar 50% dari total biaya sewa.
                                    </li>
                                </ul>
                                <ul>Sanksi dan Denda
                                    <li>
                                        Keterlambatan pengembalian mobil akan dikenakan denda sesuai dengan tarif per jam
                                        yang berlaku.
                                    </li>
                                    <li>
                                        Segala bentuk pelanggaran terhadap syarat dan ketentuan ini dapat mengakibatkan
                                        sanksi, termasuk pelarangan untuk menyewa di masa depan
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        Pihak rental berhak untuk mengubah syarat dan ketentuan ini kapan saja dengan
                                        pemberitahuan melalui website.
                                    </li>
                                    <li>
                                        Penyewa diharapkan untuk memeriksa syarat dan ketentuan secara berkala untuk
                                        memastikan kesesuaian dengan kebijakan yang terbaru.
                                    </li>
                                </ul>
                                <p>
                                    Segala bentuk perselisihan yang timbul dari penyewaan ini akan diselesaikan secara
                                    musyawarah untuk mufakat.
                                </p>
                            </div>
                        </details>
                        <details class="group">
                            <summary
                                class="flex items-center justify-between py-4 text-lg font-medium list-none cursor-pointer text-secondary-900">
                                <h1 id="Syarat dan Ketentuan" class="font-bold text-md">
                                    Kebijakan Pembatalan
                                </h1>
                                <div class="text-secondary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="block w-5 h-5 transition-all duration-300 group-open:rotate-180">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </summary>
                            <div class="prose-sm prose text-gray-500">
                                <ul><b>Pembatalan dan Pengembalian Dana</b>
                                    <li>
                                        Pembatalan penyewaan harus dilakukan minimal 24 jam sebelum waktu pengambilan untuk
                                        mendapatkan pengembalian dana penuh.
                                    </li>
                                    <li>
                                        Pembatalan yang dilakukan kurang dari 24 jam sebelum waktu pengambilan akan
                                        dikenakan
                                        biaya pembatalan sebesar 50% dari total biaya sewa.
                                    </li>
                                </ul>
                            </div>
                        </details>
                    </div>
                </section>
                {{-- <form wire:submit.prevent="submit">
                    <div x-data="{ switchOn: false }" class="text-end">
                        <div class="flex space-y-5">
                            <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

                            <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                                :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }" class="text-sm select-none"
                                x-cloak>
                                Dengan mengklik tombol ini, Anda setuju dengan syarat & ketentuan serta kebijakan privasi
                            </label>
                            <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn"
                                :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                                class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10" x-cloak>
                                <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                                    class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                            </button>
                        </div>
                        <input type="hidden" id="tanggalAmbil" wire:model="tanggalAmbil" value="{{ $keyword['tanggalAmbil'].''.$keyword['waktu'] }}">
                        <input type="hidden" id="tanggalKembali" wire:model="tanggalKembali" value="{{ $keyword['tanggalKembali'].''.$keyword['waktu'] }}">
                        <input type="hidden" id="mobil" wire:model="mobilid" value="{{ $mobil->id }}">
                        <button :disabled="!switchOn"
                            class="h-12 mt-10 font-medium duration-200 bg-gray-100 rounded-md w-80 gap-3py-3 enabled:hover:bg-blue-600 disabled:opacity-75 enabled:bg-blue-500 enabled:text-white enabled:hover:text-white focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            aria-describedby="planDescription" aria-label="Button" type="submit">
                            Lanjutkan Pesanan
                        </button>
                    </div>
                </form> --}}
                @livewire('detail-produk-form', ['keyword' => $keyword, 'mobils' => $mobil])
            </div>
            <div class="row-span-2 mt-[5rem] p-5 sidebar">
                <div class="flex flex-row border rounded-lg shadow-sm">
                    <div class="h-full p-5">
                        <!-- Timeline -->
                        <div>
                            <!-- Heading -->
                            <div class="my-2 ps-2 first:mt-0">
                                <h3 class="text-xs font-medium text-gray-500 uppercase">
                                    {{ $keyword['tanggalAmbil'] }}
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
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
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
                                        pengambilan kendaraan dilakukan pada tanggal {{ $keyword['tanggalAmbil'] }}
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
                                        waktu pengambilan dan pengembalian pukul {{ $keyword['waktu'] }}.
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
                                    {{ $keyword['tanggalKembali'] }}
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
                                        Pengembalian kendaraan dilakukan pada tanggal {{ $keyword['tanggalKembali'] }}
                                    </p>
                                </div>
                                <!-- End Right Content -->

                            </div>
                            <!-- End Item -->
                        </div>
                        <!-- End Timeline -->
                    </div>
                </div>
                @livewire('component.rincian-harga', ['mobil' => $mobil])
            </div>
        </div>
    </section>

    <x-navigation.footer />
@endsection
