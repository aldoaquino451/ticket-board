<template>
    <div>
        <input
            :id="id"
            :class="[
                'mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md',
                className,
            ]"
            :value="displayValue"
            @input="onInput"
            list="datalist-options"
            :placeholder="placeholder"
        />
        <datalist id="datalist-options">
            <option
                v-for="option in options"
                :key="option.id"
                :value="option.name"
                :data-id="option.id"
            >
                {{ option.name }}
            </option>
        </datalist>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    id: String,
    modelValue: [String, Number],
    className: String,
    options: Array,
    placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const displayValue = ref("");

const updateDisplayValue = (value) => {
    const option = props.options.find((option) => option.id == value);
    displayValue.value = option ? option.name : "";
};

watch(
    () => props.modelValue,
    (newValue) => {
        updateDisplayValue(newValue);
    },
    { immediate: true }
);

const onInput = (event) => {
    const value = event.target.value;
    const option = props.options.find((option) => option.name === value);
    if (option) {
        emit("update:modelValue", option.id);
    } else {
        // Cerca la prima corrispondenza parziale
        const partialMatch = props.options.find((option) =>
            option.name.toLowerCase().startsWith(value.toLowerCase())
        );
        if (partialMatch) {
            emit("update:modelValue", partialMatch.id);
        } else {
            emit("update:modelValue", null);
        }
    }
    displayValue.value = value;
};
</script>
