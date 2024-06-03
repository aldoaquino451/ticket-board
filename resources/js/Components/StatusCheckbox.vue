<template>
    <div>
        <input
            :id="id"
            type="checkbox"
            :class="className"
            :checked="modelValue.includes(valueCheckbox)"
            :value="valueCheckbox"
            @change="handleChange"
        />
        <label :for="id" class="ml-2 text-gray-900 dark:text-gray-200">
            {{ label }}
        </label>
    </div>
</template>

<script setup>
const props = defineProps({
    id: String,
    modelValue: Array,
    className: String,
    valueCheckbox: [String, Number],
    label: String,
});

const emit = defineEmits(["update:modelValue"]);

const handleChange = (event) => {
    const newValue = event.target.checked
        ? [...props.modelValue, props.valueCheckbox]
        : props.modelValue.filter((value) => value !== props.valueCheckbox);

    emit("update:modelValue", newValue);
};
</script>
