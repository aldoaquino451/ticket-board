<template>
    <input
        :id="id"
        type="date"
        :class="className"
        v-model="modelValue"
        :placeholder="placeholder"
        :disabled="isDisabled"
    />
</template>

<script setup>
defineProps({
    id: String,
    modelValue: [String, Number],
    className: String,
    placeholder: String,
    isDisabled: Boolean,
});
</script>
