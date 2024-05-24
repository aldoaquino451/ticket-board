<script setup>
import { ref, defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    tickets: Object,
    pagination: Object,
});

// Inizializza variabili reattive
const ticketsArray = ref([]);
const paginationArray = ref({
    current_page: 1,
    last_page: 1,
    from: 1,
    to: 1,
    total: 0,
});
const currentPage = ref(1);

// Funzione per la navigazione tra le pagine
const navigate = async (page) => {
    currentPage.value = page;
    try {
        const response = await axios.get(`/dashboard/tickets?page=${page}`);
        console.log(currentPage);
        console.log(response.data);

        ticketsArray.value = response.data.tickets;
        paginationArray.value = response.data.pagination;
        currentPage.value = response.data.pagination.current_page;

        console.log(response.data.pagination.current_page);
    } catch (error) {
        console.error("Error fetching page data:", error);
    }
};

navigate(currentPage.value); // Carica i dati iniziali

console.log(props);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-white leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <a
                        :href="route('dashboard.tickets.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition"
                    >
                        Create New Ticket
                    </a>
                </div>
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
                                Tickets List
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
                                class="text-xs text-gray-900 dark:text-white uppercase bg-gray-200 dark:bg-gray-700"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">Code</th>
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
                                    v-for="ticket in ticketsArray"
                                    class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        <a
                                            :href="
                                                route(
                                                    'dashboard.tickets.show',
                                                    ticket.code
                                                )
                                            "
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                            >{{ ticket.title }}</a
                                        >
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ ticket.code }}
                                    </td>
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
                                            :href="
                                                route(
                                                    'dashboard.tickets.edit',
                                                    ticket.code
                                                )
                                            "
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                            >Edit</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav
                            class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
                            aria-label="Table navigation"
                        >
                            <span
                                class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto"
                                >Showing
                                <span
                                    class="font-semibold text-gray-900 dark:text-white"
                                    >{{
                                        `${paginationArray.from}-${paginationArray.to}`
                                    }}</span
                                >
                                of
                                <span
                                    class="font-semibold text-gray-900 dark:text-white"
                                    >{{ paginationArray.total }}</span
                                ></span
                            >
                            <ul
                                class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8"
                            >
                                <li>
                                    <button
                                        @click="navigate(currentPage - 1)"
                                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        :class="{
                                            'opacity-50 cursor-not-allowed':
                                                currentPage === 1,
                                        }"
                                        :disabled="currentPage === 1"
                                    >
                                        Previous
                                    </button>
                                </li>
                                <li
                                    v-for="page in paginationArray.last_page"
                                    :key="page"
                                >
                                    <button
                                        @click="navigate(page)"
                                        class="flex items-center justify-center px-3 h-8 leading-tight border"
                                        :class="
                                            currentPage === page
                                                ? 'text-white bg-blue-500 border-gray-300 hover:bg-blue-600  dark:bg-blue-900 dark:text-white dark:border-gray-600 dark:hover:bg-blue-950 '
                                                : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-300'
                                        "
                                    >
                                        {{ page }}
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="navigate(currentPage + 1)"
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        :class="{
                                            'opacity-50 cursor-not-allowed':
                                                currentPage ===
                                                paginationArray.last_page,
                                        }"
                                        :disabled="
                                            currentPage ===
                                            paginationArray.last_page
                                        "
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
