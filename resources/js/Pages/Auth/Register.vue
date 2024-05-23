<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    surname: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="lg:flex lg:gap-4">
                <div class="flex-1">
                    <InputLabel
                        for="name"
                        value="Name"
                        class="text-gray-900 dark:text-gray-200"
                    />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError
                        class="mt-2 text-red-600 dark:text-red-400"
                        :message="form.errors.name"
                    />
                </div>

                <div class="flex-1 mt-4 lg:mt-0">
                    <InputLabel
                        for="surname"
                        value="Surname"
                        class="text-gray-900 dark:text-gray-200"
                    />

                    <TextInput
                        id="surname"
                        type="text"
                        class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                        v-model="form.surname"
                        required
                        autocomplete="surname"
                    />

                    <InputError
                        class="mt-2 text-red-600 dark:text-red-400"
                        :message="form.errors.surname"
                    />
                </div>
            </div>

            <div class="mt-4">
                <InputLabel
                    for="username"
                    value="Username"
                    class="text-gray-900 dark:text-gray-200"
                />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                    v-model="form.username"
                    required
                    autocomplete="username"
                />

                <InputError
                    class="mt-2 text-red-600 dark:text-red-400"
                    :message="form.errors.username"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-gray-900 dark:text-gray-200"
                />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError
                    class="mt-2 text-red-600 dark:text-red-400"
                    :message="form.errors.email"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-gray-900 dark:text-gray-200"
                />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2 text-red-600 dark:text-red-400"
                    :message="form.errors.password"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                    class="text-gray-900 dark:text-gray-200"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2 text-red-600 dark:text-red-400"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-300"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4 bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
