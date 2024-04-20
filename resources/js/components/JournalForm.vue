<template>
    <div>
        <h1 class="mb-6">Clients -> Journal -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Notes</label>
                <textarea id="name" class="form-control" rows="5" v-model="notes"/>
            </div>

            <div class="text-right">
                <a :href="`/clients/${clientId}`" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'JournalForm',

    props: ['clientId'],

    data() {
        return {
            notes: '',
        };
    },

    methods: {
        storeJournal() {
            if (!this.clientId) {
                throw new Error('Client ID not found');
            }

            axios.post(`/clients/${this.clientId}/journals`, {
                journal_content: this.notes,
            }).then(response => {
                window.location.href = response.data.url;
            });
        },
    },
}
</script>
