<template>
    <button class="inline-flex gap-x-2 bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-700 transition cursor-pointer">
        <span v-if="$slots.icon">
            <slot name="icon" />
        </span>
        {{ text }}
    </button>
</template>

<script setup>

defineProps({
    text: {
        type: String,
        required: true
    }
})

</script>
