<template>
    <div class="relative overflow-x-auto shadow-md rounded-lg px-5">
        <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
            <div class="flex gap-x-2 items-center justify-between w-full">
                <p class="font-semibold">showing {{ $page.props.contacts.data.length }} of {{ $page.props.contacts.total }} contacts.</p>

                <AppButton text="Add New" @click="addNewContact()">
                    <template #icon>
                        <UserPlusIcon />
                    </template>
                </AppButton>
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Phone</th>
                    <th scope="col" class="px-6 py-3">Manage</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="contact in contacts.data" :key="contact.id" class="bg-white border-b border-gray-200 hover:bg-amber-100 hover:text-amber-600 transition">
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        {{ contact.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ contact.email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ contact.phone }}
                    </td>
                    <td class="px-6 py-4 flex items-center gap-x-5">
                        <button class="font-medium text-neutral-600 hover:text-amber-500 cursor-pointer transition" @click="editContact(contact)">
                            <EditIcon />
                        </button>
                        <button class="font-medium text-neutral-600 hover:text-red-500 cursor-pointer transition" @click="deleteContact(contact.id)">
                            <TrashIcon />
                        </button>
                    </td>
                </tr>
                <tr v-if="!contacts.data.length">
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No contacts found.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <OffcanvasModal v-model="showModal" :contact="currentContact" @close="showModal = false" />
</template>

<script setup>
import { ref } from 'vue'
import { EditIcon, TrashIcon, UserPlusIcon } from 'lucide-vue-next'
import AppButton from './AppButton.vue'
import OffcanvasModal from './OffcanvasModal.vue'
import Swal from 'sweetalert2'
import axios from 'axios'

const props = defineProps({
    contacts: {
        type: Object,
        required: true
    }
})

const currentContact = ref(null)

const showModal = ref(false)

function addNewContact() {
    currentContact.value = null
    showModal.value = true
}

function editContact(contact) {
    currentContact.value = contact
    showModal.value = true
}

function deleteContact(contactId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/contacts/${contactId}`)
                .then(response => {
                    Swal.fire('Deleted!', response.data.message, 'success')
                    window.location.reload()
                })
                .catch(error => {
                    Swal.fire('Error!', error.response.data.message || 'Something went wrong.', 'error')
                })
        }
    })
}
</script>