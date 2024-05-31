<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    available: Array,
    notAvailable: Array,
});

console.log(props);
</script>

<template>
    <Head title="Operatori" />

    <AuthenticatedLayout>
        <!-- page name -->
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-white leading-tight"
            >
                Operatori
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Available Operators -->
                    <div class="mb-8">
                        <p
                            class="text-2xl font-bold text-green-400 dark:text-green-300 mb-4"
                        >
                            Disponibili
                        </p>
                        <div class="relative overflow-x-auto sm:rounded-lg">
                            <table
                                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 sm:rounded-lg overflow-hidden shadow-sm"
                            >
                                <thead
                                    class="text-xs text-gray-900 dark:text-white uppercase bg-gray-200 dark:bg-gray-700"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nome
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Tickets
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="operator in props.available"
                                        :key="operator.slug"
                                        class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            <Link
                                                :href="
                                                    route(
                                                        'dashboard.operators.show',
                                                        operator.slug
                                                    )
                                                "
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                            >
                                                {{ operator.name }}
                                                {{ operator.surname }}
                                            </Link>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ operator.email }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            {{
                                                operator.tickets.length === 0
                                                    ? "Nessuno"
                                                    : operator.tickets.length
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Not Available Operators -->
                    <div class="mb-8">
                        <p
                            class="text-2xl font-bold text-red-400 dark:text-red-300 mb-4"
                        >
                            Non disponibili
                        </p>
                        <div class="relative overflow-x-auto sm:rounded-lg">
                            <table
                                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 sm:rounded-lg overflow-hidden shadow-sm"
                            >
                                <thead
                                    class="text-xs text-gray-900 dark:text-white uppercase bg-gray-200 dark:bg-gray-700"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nome
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Tickets
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="operator in props.notAvailable"
                                        :key="operator.slug"
                                        class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            <Link
                                                :href="
                                                    route(
                                                        'dashboard.operators.show',
                                                        operator.slug
                                                    )
                                                "
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                            >
                                                {{ operator.name }}
                                                {{ operator.surname }}
                                            </Link>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ operator.email }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            {{
                                                operator.tickets.length === 0
                                                    ? "Nessuno"
                                                    : operator.tickets.length
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
