<template>
    <textarea
        :id="id"
        :class="className"
        :rows="rows"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
</template>

<script setup>
defineProps({
    id: String,
    modelValue: String,
    className: String,
    rows: Number,
});
</script>
