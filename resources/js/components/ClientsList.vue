<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary">+ New Client</a>
        </h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number of Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clientList" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                        <button class="btn btn-danger btn-sm" @click="deleteClient(client)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div
            v-if="showError"
            class="error-container"
        >
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error</strong>
                <span class="block sm:inline">{{ errorText }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',

    props: ['clients'],

    data() {
        return {
            clientList: this.clients,
            showError: false,
            errorText: '',
        }
    },

    methods: {
        deleteClient(client) {
            axios.delete(`/clients/${client.id}`).then((response) => {
                this.removeDeletedClient(client.id);
            }).catch((error) => {
                this.errorText = 'Could not delete client';
                this.showError = true;

                setTimeout(() => {
                    this.showError = false;
                    this.errorText = '';
                }, 5000);
            });
        },

        removeDeletedClient(id) {
            this.clientList = this.clientList.filter((client) => client.id !== id);
        },
    }
}
</script>

<style>
.error-container {
    position: fixed;
    top: 32px;
    right: 32px;
    width: 240px;
}
</style>
