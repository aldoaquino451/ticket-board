<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Textarea from "@/Components/Textarea.vue";
import Select from "@/Components/Select.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    categories: Object,
});

console.log(props.categories);

const form = useForm({
    title: "",
    description: "",
    category_id: null,
});

const submit = () => {
    form.post(route("dashboard.tickets.store"));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create Ticket" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg"
                >
                    <div class="px-4 py-5 sm:px-6">
                        <h3
                            class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                        >
                            Create New Ticket
                        </h3>
                        <p
                            class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                        >
                            Fill out the form below to create a new ticket.
                        </p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <form @submit.prevent="submit" class="p-6 space-y-6">
                            <div>
                                <InputLabel
                                    for="title"
                                    value="Title"
                                    class="text-gray-900 dark:text-gray-200"
                                />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                    v-model="form.title"
                                    required
                                    autofocus
                                    autocomplete="title"
                                />

                                <InputError
                                    class="mt-2 text-red-600 dark:text-red-400"
                                    :message="form.errors.title"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="description"
                                    value="Description"
                                    class="text-gray-900 dark:text-gray-200"
                                />

                                <Textarea
                                    id="description"
                                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                    v-model:modelValue="form.description"
                                    required
                                    rows="5"
                                />

                                <InputError
                                    class="mt-2 text-red-600 dark:text-red-400"
                                    :message="form.errors.description"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="category_id"
                                    value="Category"
                                    class="text-gray-900 dark:text-gray-200"
                                />

                                <Select
                                    id="category_id"
                                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                    v-model:modelValue="form.category_id"
                                    :options="props.categories"
                                    placeholder="Select a category"
                                    required
                                />

                                <InputError
                                    class="mt-2 text-red-600 dark:text-red-400"
                                    :message="form.errors.category_id"
                                />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Create Ticket
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
