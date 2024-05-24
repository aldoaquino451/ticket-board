<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Datalist from "@/Components/Datalist.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    ticket: Object,
    operators: Array,
    statuses: Array,
    flash: Object,
});

const form = useForm({
    status: props.ticket.status,
    operator_id: props.ticket.operator_id,
});
const submit = () => {
    form.put(route("dashboard.tickets.update", props.ticket.code));
};

console.log(props.ticket.status);

if (props.ticket.status === "in progress") {
    form.status = null;
}

console.log(props.flash);
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit Ticket" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg"
                >
                    <div class="px-4 py-5 sm:px-6">
                        <h3
                            class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                        >
                            Edit Ticket
                        </h3>
                        <p
                            class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                        >
                            Update the form below to edit the ticket.
                        </p>
                    </div>
                    <div
                        v-if="flash"
                        class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700"
                        :class="flash.class"
                    >
                        {{ flash.message }}
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <!-- Informazioni del Ticket -->
                        <div class="px-4 py-5 sm:px-6">
                            <h4
                                class="text-md leading-5 font-medium text-gray-900 dark:text-white"
                            >
                                Ticket Information
                            </h4>
                            <p
                                class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                            >
                                <strong>Code:</strong> {{ props.ticket.code }}
                                <br />
                                <strong>Title:</strong> {{ props.ticket.title }}
                                <br />
                                <span class="capitalize"
                                    ><strong>Status:</strong>
                                    {{ props.ticket.status }}
                                </span>
                                <br />
                                <strong>Operator:</strong>
                                {{
                                    props.ticket.operator
                                        ? `${props.ticket.operator?.name} ${props.ticket.operator?.surname}`
                                        : "N/A"
                                }}
                                <br
                                    v-if="props.ticket.status === 'in progress'"
                                />
                                <span
                                    v-if="props.ticket.status === 'in progress'"
                                    class="capitalize"
                                    ><strong>Status:</strong>
                                    {{ props.ticket.status }}</span
                                >
                            </p>
                        </div>
                        <div
                            class="border-t border-gray-200 dark:border-gray-700"
                        >
                            <form
                                @submit.prevent="submit"
                                class="p-6 space-y-6 lg:space-y-0 lg:flex flex-wrap"
                            >
                                <div class="lg:w-1/2 lg:pr-2">
                                    <InputLabel
                                        for="status"
                                        value="Status"
                                        class="text-gray-900 dark:text-gray-200"
                                    />
                                    <Select
                                        id="status"
                                        class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                        v-model:modelValue="form.status"
                                        :options="props.statuses"
                                        placeholder="Select a status"
                                        required
                                    />
                                    <InputError
                                        class="mt-2 text-red-600 dark:text-red-400"
                                        :message="form.errors.status"
                                    />
                                </div>

                                <div class="lg:w-1/2 lg:pl-2">
                                    <InputLabel
                                        for="operator_id"
                                        value="Operator"
                                        class="text-gray-900 dark:text-gray-200"
                                    />
                                    <Datalist
                                        id="operator_id"
                                        :className="
                                            form.status == 'assigned'
                                                ? 'mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md'
                                                : 'mt-1 block w-full bg-gray-200 dark:bg-gray-600 border-gray-300 dark:border-gray-500 text-gray-500 dark:text-gray-400 rounded-md cursor-not-allowed opacity-60'
                                        "
                                        v-model:modelValue="form.operator_id"
                                        :operatorId="props.ticket.operator_id"
                                        :isDisabled="form.status !== 'assigned'"
                                        :options="
                                            props.operators.map((op) => ({
                                                id: op.id,
                                                name: `${op.name} ${op.surname}`,
                                            }))
                                        "
                                        placeholder="Select an operator"
                                        :operatorName="
                                            props.ticket.operator
                                                ? `${props.ticket.operator?.name} ${props.ticket.operator?.surname}`
                                                : 'N/A'
                                        "
                                        required
                                    />
                                    <InputError
                                        class="mt-2 text-red-600 dark:text-red-400"
                                        :message="form.errors.operator_id"
                                    />
                                </div>

                                <div
                                    class="flex items-center justify-end mt-4 lg:ml-auto"
                                >
                                    <PrimaryButton
                                        class="lg:mt-6"
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :isDisabled="
                                            form.processing ||
                                            form.operator_id == 0 ||
                                            form.operator_id == 'pippo' ||
                                            (form.status !== 'assigned' &&
                                                form.status ===
                                                    props.ticket.status) ||
                                            (form.status === 'assigned' &&
                                                form.status ===
                                                    props.ticket.status &&
                                                form.operator_id !== null &&
                                                form.operator_id ===
                                                    props.ticket.operator_id)
                                        "
                                    >
                                        Update Ticket
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
