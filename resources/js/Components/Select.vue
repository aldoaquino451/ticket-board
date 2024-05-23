<template>
    <select
        :id="id"
        :class="className"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <option disabled value="">{{ placeholder }}</option>
        <option v-for="option in options" :key="option.id" :value="option.id">
            {{ option.name }}
        </option>
    </select>
</template>

<script setup>
defineProps({
    id: String,
    modelValue: [String, Number],
    className: String,
    options: Array,
    placeholder: String,
});
</script>
