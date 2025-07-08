<template>
    <main class="p-4 font-mono">
        <header class="w-full bg-neutral-800 text-white p-4 rounded-lg inline-flex justify-between items-center">
            <div class="text-2xl text-center font-bold inline-flex items-center gap-x-1">
                <NotebookTabsIcon :size="32" />
                <span>Contact CRUD</span>
            </div>
            <li class="pr-4 flex flex-col">
                <p>Welcome to the Contact CRUD Application</p>
                <p class="text-xs">Easily manage all your contacts.</p>
            </li>
        </header>
        <section class="py-4">
            <slot />
        </section>
        <footer class="bg-neutral-800 text-white p-4 mt-4 text-center inline-flex gap-x-20 justify-center items-center w-full rounded-lg">
            <span>Made with <span class="text-red-400 animate-pulse">❤</span> by <a class="underline font-semibold" href="https://sebraxportfolio.vercel.app" target="_blank">Sulivan Braga</a></span>
            <span>All rights reserved &copy; {{ year }}</span>
        </footer>
    </main>
</template>

<script setup>

import { NotebookTabsIcon } from 'lucide-vue-next'
import { ref } from 'vue'

const year = ref(new Date().getFullYear())

</script>