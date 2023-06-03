<div class="type-xs-mono relative z-10" x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>

    <div class="relative">
        <input type="hidden" name="date" x-ref="date">
        <input type="hidden" x-model="datepickerValue">

        <div class="border border-gray-light rounded py-4 pb-10 px-6 w-full max-w-sm mx-auto"
            x-show.transition="showDatepicker">

            <div>
                <button type="button"
                    class="right-full top-1/2 absolute inline-flex cursor-pointer rounded-full p-1 transition"
                    :class="{ 'cursor-not-allowed opacity-25': month == 0 }" :disabled="month == 0 ? true : false"
                    @click="month--; getNoOfDays()">
                    <svg class="inline-flex h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button"
                    class="hover:bg-gray-200 left-full top-1/2 absolute inline-flex cursor-pointer rounded-full p-1 transition"
                    :class="{ 'cursor-not-allowed opacity-25': month == 11 }" :disabled="month == 11 ? true : false"
                    @click="month++; getNoOfDays()">
                    <svg class="inline-flex h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="mb-6 text-center">

                <span x-text="MONTH_NAMES[month] + ' ' + year" class=""></span>

            </div>

            <div class="-mx-1 mb-3 flex flex-wrap bg-sand-dark py-0.5 rounded-full">
                <template x-for="(day, index) in DAYS" :key="index">
                    <div style="width: 14.26%" class="px-1">
                        <div x-text="day" class="text-center"></div>
                    </div>
                </template>
            </div>

            <div class="-mx-1 flex flex-wrap">
                <template x-for="blankday in blankdays">
                    <div style="width: 14.28%" class="border border-transparent p-1 text-center text-sm"></div>
                </template>
                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                    <div style="width: 14.28%" class="mb-1 px-0.5">
                        <div @click="getDateValue(date)" x-text="date"
                            class="cursor-pointer rounded-full text-center px-2 py-1 transition"
                            :class="{
                                'bg-yellow font-bold ': isToday(date) ==
                                    true,
                                'hover:bg-gray': isToday(date) == false
                            }">
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December'
    ];
    const DAYS = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];

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
