<template>
    <nav v-if="links.length > 3" class="flex justify-center">
        <ul class="inline-flex items-center -space-x-px">
            <li v-for="(link, i) in links" :key="i">
                <span
                    v-if="!link.url"
                    class="px-3 py-2 leading-tight text-gray-400 bg-white border border-gray-300 cursor-default"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :class="[
                        'px-3 py-2 leading-tight border',
                        link.active
                            ? 'text-white bg-green-500 border-green-500'
                            : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-100 hover:text-green-700 cursor-pointer'
                    ]"
                    :href="link.url"
                ><span v-html="link.label"></span></Link>
            </li>
        </ul>
    </nav>
</template>

<script setup>

import { Link } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        required: true
    }
});
</script>