<template>
    <div>
        <h1 class="mb-6">Clients -> {{ journal.client.name }} -> Journal from {{ formatJournalDate(journal.date) }}</h1>

        <div class="flex">
            <div class="w-100 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Journal Info</h2>
                    <table>
                        <tbody>
                        <tr>
                            <th class="text-gray-600 pr-3">Date</th>
                            <td>{{ formatJournalDate(journal.date) }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Notes</th>
                        </tr>
                        </tbody>
                    </table>

                    <pre>{{ journal.content }}</pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatJournalDate } from "../helpers/DateTimeFormatHelper";

export default {
    name: 'JournalShow',

    props: ['journal'],

    methods: {
        formatJournalDate,
    },
}
</script>
