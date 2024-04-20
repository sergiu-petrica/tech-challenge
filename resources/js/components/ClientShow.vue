<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                        <tr>
                            <th class="text-gray-600 pr-3">Name</th>
                            <td>{{ client.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Email</th>
                            <td>{{ client.email }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Phone</th>
                            <td>{{ client.phone }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Address</th>
                            <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn"
                            :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}"
                            @click="switchTab('bookings')">Bookings
                    </button>
                    <button class="btn"
                            :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}"
                            @click="switchTab('journals')">Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>

                    <select
                        v-model="selectedBookingFilteringOption"
                        class="mt-2 mb-4 p-2 bg-gray-50 border border-gray w-full"
                        @change="filterBookings"
                    >
                        <option
                            v-for="option in bookingFilteringOptions"
                            :value="option.value"
                        >
                            {{ option.label }}
                        </option>
                    </select>

                    <template v-if="bookings && bookings.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="booking in bookings" :key="booking.id">
                                <td>{{ formatBookingPeriod(booking.start, booking.end) }}</td>
                                <td>{{ booking.notes }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals</h3>

                    <a class="btn btn-primary mb-3" :href="`/clients/${client.id}/journals/create`">Create</a>

                    <template v-if="journals && journals.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Notes</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="journal in journals" :key="journal.id">
                                <td>{{ journal.content }}</td>
                                <td>{{ formatJournalDate(journal.date) }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}/journals/${journal.id}`">View</a>
                                    <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { DateTime } from "luxon";
import { formatJournalDate } from "../helpers/DateTimeFormatHelper";

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        const bookingFilteringOptions = [
            {
                value: 0,
                label: 'All Bookings',
            },
            {
                value: 1,
                label: 'Future Bookings Only',
            },
            {
                value: 2,
                label: 'Past Bookings Only',
            },
        ];
        const selectedBookingFilteringOption = 0;

        return {
            currentTab: 'bookings',
            bookings: this.sortBookings(this.client.bookings),
            journals: this.sortJournals(this.client.journals),
            bookingFilteringOptions,
            selectedBookingFilteringOption,
        }
    },

    methods: {
        formatJournalDate,
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/clients/${this.client.id}/bookings/${booking.id}`).then((response) =>{
                this.removeDeletedBooking(booking.id);
            }).catch((error) => {
                console.log('Could not delete booking');
            });
        },

        deleteJournal(journal) {
            axios.delete(`/clients/${this.client.id}/journals/${journal.id}`).then((response) => {
                this.removeDeletedJournal(journal.id);
            }).catch((error) => {
                console.log('Could not delete journal');
            });
        },

        formatBookingPeriod(startTime, endTime) {
            if (!startTime || !endTime) {
                throw new Error('Start or end time is invalid');
            }

            const startDateTime = DateTime.fromISO(startTime);
            const endDateTime = DateTime.fromISO(endTime);

            let result = `${startDateTime.toFormat('cccc d LLLL y, HH:mm')}`;

            if (startDateTime.day === endDateTime.day && startDateTime.month === endDateTime.month && startDateTime.year === endDateTime.year) {
                result += ` to ${endDateTime.toFormat('HH:mm')}`;
            } else {
                result += ` to ${endDateTime.toFormat('cccc d LLLL y, HH:mm')}`;
            }

            return result;
        },

        sortBookings(bookings) {
            if (!bookings) {
                return;
            }

            return bookings.sort((a, b) => {
                if (a.start < b.start) {
                    return 1;
                }

                if (a.start > b.start) {
                    return -1;
                }

                return 0;
            });
        },

        sortJournals(journals) {
            if (!journals) {
                return;
            }

            return journals.sort((a, b) => {
                if (a.date < b.date) {
                    return 1;
                }

                if (a.date > b.date) {
                    return -1
                }

                return 0;
            });
        },

        filterBookings() {
            let filteredBookings;

            switch (this.selectedBookingFilteringOption) {
                case 0:
                    this.bookings = this.sortBookings(this.client.bookings);

                    break;
                case 1:
                    filteredBookings = this.client.bookings.filter((booking) => {
                        const currentDateTime = DateTime.now();
                        const bookingDateTime = DateTime.fromISO(booking.start);

                        return currentDateTime.ts < bookingDateTime.ts;
                    });
                    this.bookings = this.sortBookings(filteredBookings);

                    break;
                case 2:
                    filteredBookings = this.client.bookings.filter((booking) => {
                        const currentDateTime = DateTime.now();
                        const bookingDateTime = DateTime.fromISO(booking.start);

                        return currentDateTime.ts > bookingDateTime.ts;
                    });
                    this.bookings = this.sortBookings(filteredBookings);

                    break;
                default:
                    throw new Error('Invalid booking option');
            }
        },

        refreshJournals() {
            this.journals = this.client.journals;
        },

        removeDeletedBooking(id) {
            this.client.bookings = this.client.bookings.filter((booking) => booking.id !== id);
            this.filterBookings();
        },

        removeDeletedJournal(id) {
            this.client.journals = this.client.journals.filter((journal) => journal.id !== id);
            this.refreshJournals();
        },
    }
}
</script>
