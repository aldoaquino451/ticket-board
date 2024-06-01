<script setup>
import { ref, defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Datalist from "@/Components/Datalist.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    tickets: Object,
    operators: Object,
});

console.log(props.operators);

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

console.log(props);

// Funzione per la navigazione tra le pagine
const navigate = async (page) => {
    currentPage.value = page;
    try {
        const response = await axios.get(
            `/api/tickets/pagination?page=${page}`
        );
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

const filter = async () => {
    try {
        const params = {
            status: "queued",
            operator_id: 10,
        };
        const response = await axios.get(`/api/tickets/filter`, { params });
        // Gestisci la risposta come desiderato
        console.log(response.data);
    } catch (error) {
        console.error("Error fetching ticket data:", error);
    }
};

navigate(currentPage.value); // Carica i dati iniziali

console.log(props);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- page name -->
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-white leading-tight"
            >
                Tickets
            </h2>
        </template>

        <!-- page content -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <InputLabel
                        for="operator_id"
                        value="Operatore"
                        class="text-gray-900 dark:text-gray-200"
                    />
                    <Datalist
                        id="operator_id"
                        :className="`mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md`"
                        :options="
                            props.operators.map((op) => ({
                                id: op.id,
                                name: `${op.name} ${op.surname}`,
                            }))
                        "
                        placeholder="Select an operator"
                        required
                    />
                    <InputError class="mt-2 text-red-600 dark:text-red-400" />
                </div>

                <!-- create new button -->
                <div class="flex justify-end mb-4">
                    <Link
                        :href="route('dashboard.tickets.create')"
                        class="px-4 py-2 bg-blue-600 rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-500 active:bg-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition"
                        >Nuovo Ticket</Link
                    >
                </div>

                <!-- table tickets -->
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 sm:rounded-lg overflow-hidden shadow-sm"
                    >
                        <caption
                            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800"
                        >
                            <p>Lista dei Ticket</p>
                            <p
                                class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400"
                            >
                                Questa è lo storico di tutti i ticket che sono
                                stati chiusi o sono in fase di completamento.
                            </p>
                        </caption>

                        <thead
                            class="text-xs text-gray-900 dark:text-white uppercase bg-gray-200 dark:bg-gray-700"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Titolo</th>
                                <th scope="col" class="px-6 py-3">Codice</th>
                                <th scope="col" class="px-6 py-3">Stato</th>
                                <th scope="col" class="px-6 py-3">Categoria</th>
                                <th scope="col" class="px-6 py-3">Operatore</th>
                                <th scope="col" class="px-6 py-3"></th>
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
                                    <Link
                                        :href="
                                            route(
                                                'dashboard.tickets.show',
                                                ticket.code
                                            )
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    >
                                        {{ ticket.title }}
                                    </Link>
                                </th>
                                <td class="px-6 py-4">{{ ticket.code }}</td>
                                <td class="px-6 py-4">{{ ticket.status }}</td>
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
                                    <Link
                                        :href="
                                            route(
                                                'dashboard.tickets.edit',
                                                ticket.code
                                            )
                                        "
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    >
                                        Modifica
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <nav
                        class="flex gap-x-8 items-center flex-column flex-wrap md:flex-row justify-between py-4"
                        aria-label="Table navigation"
                    >
                        <span
                            class="leading-8 text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto"
                        >
                            Risultati da
                            <span
                                class="font-semibold text-gray-900 dark:text-white"
                            >
                                {{
                                    `${paginationArray.from}-${paginationArray.to}`
                                }}
                            </span>
                            su
                            <span
                                class="font-semibold text-gray-900 dark:text-white"
                            >
                                {{ paginationArray.total }}
                            </span>
                        </span>

                        <ul
                            class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8"
                        >
                            <li>
                                <button
                                    @click="navigate(currentPage - 1)"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    :class="
                                        currentPage === 1
                                            ? 'opacity-50 cursor-not-allowed'
                                            : ''
                                    "
                                    :disabled="currentPage === 1"
                                >
                                    Precedente
                                </button>
                            </li>

                            <li
                                v-for="page in paginationArray.last_page"
                                :key="page"
                            >
                                <button
                                    @click="navigate(page)"
                                    class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300"
                                    :class="
                                        currentPage === page
                                            ? 'text-white bg-blue-500 hover:bg-blue-600  dark:bg-blue-900 dark:text-white dark:border-gray-600 dark:hover:bg-blue-950 '
                                            : 'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-300'
                                    "
                                >
                                    {{ page }}
                                </button>
                            </li>

                            <li>
                                <button
                                    @click="navigate(currentPage + 1)"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    :class="
                                        currentPage ===
                                        paginationArray.last_page
                                            ? 'opacity-50 cursor-not-allowed'
                                            : ''
                                    "
                                    :disabled="
                                        currentPage ===
                                        paginationArray.last_page
                                    "
                                >
                                    Successivo
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
