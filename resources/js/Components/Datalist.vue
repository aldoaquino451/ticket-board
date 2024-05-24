<template>
    <div>
        <input
            :id="id"
            :class="className"
            :value="displayValue"
            @input="onInput"
            list="datalist-options"
            :placeholder="placeholder"
            :disabled="isDisabled"
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
import { ref, watch, onMounted } from "vue";

const props = defineProps({
    id: String,
    modelValue: [String, Number],
    className: String,
    options: Array,
    placeholder: String,
    isDisabled: Boolean,
    operatorName: String,
    operatorId: Number,
});

const emit = defineEmits(["update:modelValue"]);

const displayValue = ref("");

watch(
    () => props.isDisabled,
    (isDisabled) => {
        if (isDisabled) {
            emit("update:modelValue", null);
            displayValue.value = props.operatorName;
        } else {
            emit("update:modelValue", props.operatorId);
        }
    },
    { immediate: true }
);

onMounted(() => {
    displayValue.value = props.operatorName;
});

// const updateDisplayValue = (value) => {
//     const option = props.options.find((option) => option.id == value);
//     displayValue.value = option ? option.name : "";
// };

// watch(
//     () => props.modelValue,
//     (newValue) => {
//         updateDisplayValue(newValue);
//     },
//     { immediate: true }
// );

const onInput = (event) => {
    const value = event.target.value;
    const option = props.options.find((option) => option.name === value);
    if (option) {
        emit("update:modelValue", option.id);
    } else {
        emit("update:modelValue", 0);
        // Cerca la prima corrispondenza parziale
        // const partialMatch = props.options.find((option) =>
        //     option.name.toLowerCase().startsWith(value.toLowerCase())
        // );
        // if (partialMatch) {
        //     emit("update:modelValue", partialMatch.id);
        // } else {
        // }
    }
    displayValue.value = value;
};
</script>
