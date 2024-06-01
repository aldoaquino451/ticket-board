<template>
    <div>
        <input
            :id="id"
            type="checkbox"
            :class="className"
            v-model="modelValue"
        />
        <label :for="id" class="ml-2">{{ label }}</label>
    </div>
</template>

<script setup>
defineProps({
    id: String,
    modelValue: Boolean,
    className: String,
    label: String,
});
</script>
