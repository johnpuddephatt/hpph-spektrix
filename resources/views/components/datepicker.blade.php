<div class="relative z-10" x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="w-64">

        <div class="relative">
            <input type="hidden" name="date" x-ref="date">
            <input type="hidden" x-model="datepickerValue">

            <!--<div class="absolute top-0 right-0 px-3 py-2">
                    <svg class="text-gray-400 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div> -->

            <!-- <div x-text="no_of_days.length"></div>
                          <div x-text="32 - new Date(year, month, 32).getDate()"></div>
                          <div x-text="new Date(year, month).getDay()"></div> -->

            <div class="w-64 px-4" x-show.transition="showDatepicker">

                <div class="mb-2 flex items-center justify-between">
                    <div>
                        <span x-text="MONTH_NAMES[month]" class="text-gray-800 text-lg font-bold"></span>
                        <span x-text="year" class="text-gray-600 ml-1 text-lg font-normal"></span>
                    </div>
                    <div>
                        <button type="button"
                            class="hover:bg-gray-200 inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out"
                            :class="{ 'cursor-not-allowed opacity-25': month == 0 }"
                            :disabled="month == 0 ? true : false" @click="month--; getNoOfDays()">
                            <svg class="text-gray-500 inline-flex h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button"
                            class="hover:bg-gray-200 inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out"
                            :class="{ 'cursor-not-allowed opacity-25': month == 11 }"
                            :disabled="month == 11 ? true : false" @click="month++; getNoOfDays()">
                            <svg class="text-gray-500 inline-flex h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="-mx-1 mb-3 flex flex-wrap">
                    <template x-for="(day, index) in DAYS" :key="index">
                        <div style="width: 14.26%" class="px-1">
                            <div x-text="day" class="text-gray-800 text-center text-xs font-medium"></div>
                        </div>
                    </template>
                </div>

                <div class="-mx-1 flex flex-wrap">
                    <template x-for="blankday in blankdays">
                        <div style="width: 14.28%" class="border border-transparent p-1 text-center text-sm"></div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div style="width: 14.28%" class="mb-1 px-1">
                            <div @click="getDateValue(date)" x-text="date"
                                class="cursor-pointer rounded-full text-center text-sm leading-none leading-loose transition duration-100 ease-in-out"
                                :class="{
                                    'font-bold ': isToday(date) ==
                                        true,
                                    'text-gray-700 hover:bg-gray': isToday(date) == false
                                }">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December'
    ];
    const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    function app() {
        return {
            showDatepicker: true,
            datepickerValue: '',

            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

            initDate() {
                let today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
            },

            isToday(date) {
                const today = new Date();
                const d = new Date(this.year, this.month, date);

                return today.toDateString() === d.toDateString() ? true : false;
            },

            getDateValue(date) {
                let selectedDate = new Date(this.year, this.month, date);
                this.datepickerValue = selectedDate.toDateString();


                this.$refs.date.value = selectedDate.getFullYear() + "-" + ('0' + (selectedDate.getMonth() + 1)).slice(-
                        2) +
                    "-" + ('0' + selectedDate.getDate()).slice(-2);

                Livewire.emit('updateDate', this.$refs.date.value);
            },

            getNoOfDays() {
                let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                // find where to start calendar day of week
                let dayOfWeek = new Date(this.year, this.month).getDay();
                let blankdaysArray = [];
                for (var i = 1; i <= dayOfWeek; i++) {
                    blankdaysArray.push(i);
                }

                let daysArray = [];
                for (var i = 1; i <= daysInMonth; i++) {
                    daysArray.push(i);
                }

                this.blankdays = blankdaysArray;
                this.no_of_days = daysArray;
            }
        }
    }
</script>
