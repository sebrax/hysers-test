<template>
    <AppLayout>
        <div class="container mx-auto">
            <ContactsTable :contacts="$page.props.contacts" />
            
            <div class="mt-4">
                <Pagination :links="$page.props.contacts.links" @paginate="url => paginateTo(url)" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import ContactsTable from '../Components/ContactsTable.vue'
import Pagination from '../Components/Pagination.vue'
import AppLayout from '../Layouts/AppLayout.vue'

const paginateTo = (url) => {
    window.location.href = url
}
</script>