<template>
    <input
        :id="id"
        type="date"
        :class="className"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
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
