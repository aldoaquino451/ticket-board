<template>
    <button
        :class="[
            'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150',
            {
                'bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-indigo-500 focus:ring-offset-gray-900 dark:bg-gray-200 dark:text-gray-900 dark:hover:bg-gray-300 dark:focus:bg-gray-300 dark:active:bg-gray-400 dark:focus:ring-indigo-300 dark:focus:ring-offset-gray-900':
                    !isDisabled,
                'bg-gray-400 text-gray-700 cursor-not-allowed opacity-50 dark:bg-gray-600 dark:text-gray-400 dark:opacity-50':
                    isDisabled,
            },
        ]"
        :disabled="isDisabled"
    >
        <slot />
    </button>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    isDisabled: {
        type: Boolean,
        default: false,
    },
});
</script>
