<script setup>
import { defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    tickets: Object,
    pagination: Object,
});

function navigate(page) {
    Inertia.get(route("dashboard.tickets.index"), { page });
}

console.log(props);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <caption
                                class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                            >
                                Our products
                                <p
                                    class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Browse a list of Flowbite products designed
                                    to help you work and play, stay organized,
                                    get answers, keep in touch, grow your
                                    business, and more.
                                </p>
                            </caption>
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Operator
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="ticket in tickets"
                                    class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ ticket.title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ ticket.status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ ticket.category.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            ticket.operator
                                                ? `${ticket.operator.name} ${ticket.operator.surname}`
                                                : "Nessuno"
                                        }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                            >Edit</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav
                            class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                            aria-label="Table navigation"
                        >
                            <span
                                class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto"
                                >Showing
                                <span
                                    class="font-semibold text-gray-900 dark:text-white"
                                    >{{
                                        `${pagination.from}-${pagination.to}`
                                    }}</span
                                >
                                of
                                <span
                                    class="font-semibold text-gray-900 dark:text-white"
                                    >{{ pagination.total }}</span
                                ></span
                            >
                            <ul
                                class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8"
                            >
                                <li>
                                    <button
                                        @click="
                                            navigate(
                                                pagination.current_page - 1
                                            )
                                        "
                                        :disabled="
                                            pagination.current_page === 1
                                        "
                                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Previous
                                    </button>
                                </li>
                                <li
                                    v-for="page in pagination.last_page"
                                    :key="page"
                                >
                                    <button
                                        @click="navigate(page)"
                                        :class="[
                                            'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white',
                                            {
                                                'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white':
                                                    page ===
                                                    pagination.current_page,
                                            },
                                        ]"
                                    >
                                        {{ page }}
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="
                                            navigate(
                                                pagination.current_page + 1
                                            )
                                        "
                                        :disabled="
                                            pagination.current_page ===
                                            pagination.last_page
                                        "
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Next
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
