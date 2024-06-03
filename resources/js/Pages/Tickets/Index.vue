<script setup>
import { ref, defineProps, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Datalist from "@/Components/Datalist.vue";
import TextInput from "@/Components/TextInput.vue";
import DataInput from "@/Components/DataInput.vue";
import StatusCheckbox from "@/Components/StatusCheckbox.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    tickets: Object,
    operators: Object,
    categories: Object,
    statuses: Object,
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

const initialFilterValues = {
    code: "",
    operator_id: null,
    category_id: "",
    dateStart: "",
    dateEnd: "",
    statuses: [],
};

const filterValues = ref({
    code: "",
    operator_id: "",
    category_id: "",
    dateStart: "",
    dateEnd: "",
    statuses: [],
});

const errors = ref({});

const filter = async (page) => {
    try {
        errors.value = {}; // Resetta gli errori prima di una nuova richiesta
        if (
            filterValues.value.operator_id == 0 ||
            filterValues.value.operator_id === undefined
        ) {
            filterValues.value.operator_id = "";
        }
        const params = { ...filterValues.value, page };
        if (params.operator_id === null) {
            delete params.operator_id;
        }
        const response = await axios.get(`/api/tickets/filter`, { params });

        // Gestisci la risposta come desiderato
        ticketsArray.value = response.data.tickets;
        paginationArray.value = response.data.pagination;
        currentPage.value = response.data.pagination.current_page;
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error("Error fetching ticket data:", error);
        }
    }
};

const isFirstLoad = ref(true);
const isFiltered = ref(false);

watch(
    () => filterValues.value,
    (newFilterValues) => {
        // Verifica se tutti i parametri sono vuoti, null o undefined
        const allEmpty = Object.values(newFilterValues).every((value) => {
            if (Array.isArray(value)) {
                return value.length === 0;
            }
            return value === "" || value === null || value === undefined;
        });

        // Verifica che il campo code abbia esattamente 10 cifre
        const codeInvalid =
            newFilterValues.code &&
            newFilterValues.code.toString().length <= 10;

        // Verifica se solo la data di inizio è compilata senza la data di fine
        const dateIncomplete =
            newFilterValues.dateStart && !newFilterValues.dateEnd;

        // Controlla se è il primo caricamento della pagina
        if (isFirstLoad.value) {
            console.log("First page load, not triggering filter.");
            isFirstLoad.value = false; // Imposta su false dopo il primo caricamento
            return;
        }

        // Condizione per non attivare la funzione filter
        if (codeInvalid || dateIncomplete) {
            console.log(
                "Date range is incomplete or code is invalid, not triggering filter."
            );
            return;
        }

        if (allEmpty) {
            console.log("campi vuoti");
            navigate(1);
            isFiltered.value = false;
        } else {
            console.log("Watcher triggered with values:", newFilterValues);
            filter(1);
            isFiltered.value = true;
        }
    },
    { deep: true }
);

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
                <div class="space-y-4">
                    <div class="flex gap-2">
                        <div class="w-1/2">
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
                                v-model:modelValue="filterValues.operator_id"
                                placeholder="Seleziona un operatore"
                            />
                            <InputError
                                class="mt-2 text-red-600 dark:text-red-400"
                                :message="errors.operator_id"
                            />
                        </div>
                        <div class="w-1/2">
                            <InputLabel
                                for="code"
                                value="Code"
                                class="text-gray-900 dark:text-gray-200"
                            />

                            <TextInput
                                id="code"
                                type="number"
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                placeholder="Inserisci il codice identificativo a 10 cifre"
                                v-model:modelValue="filterValues.code"
                            />

                            <InputError
                                class="mt-2 text-red-600 dark:text-red-400"
                                :message="errors.code"
                            />
                        </div>
                    </div>

                    <div>
                        <InputLabel
                            for="category_id"
                            value="Categoria"
                            class="text-gray-900 dark:text-gray-200"
                        />
                        <Select
                            id="category_id"
                            class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                            :options="props.categories"
                            placeholder="Seleziona una categoria..."
                            v-model:modelValue="filterValues.category_id"
                        />
                        <InputError
                            class="mt-2 text-red-600 dark:text-red-400"
                            :message="errors.category_id"
                        />
                    </div>

                    <div class="flex gap-2">
                        <div class="w-1/2">
                            <InputLabel
                                for="dateStart"
                                value="Data Inizio"
                                class="text-gray-900 dark:text-gray-200"
                            />
                            <DataInput
                                id="dateStart"
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                placeholder="Seleziona uno stato..."
                                v-model:modelValue="filterValues.dateStart"
                            />
                            <InputError
                                class="mt-2 text-red-600 dark:text-red-400"
                                :message="errors.dateStart"
                            />
                        </div>

                        <div class="w-1/2">
                            <InputLabel
                                for="DateEnd"
                                value="Data Fine"
                                class="text-gray-900 dark:text-gray-200"
                            />
                            <DataInput
                                id="DateEnd"
                                :className="
                                    filterValues.dateStart !== ''
                                        ? 'mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md'
                                        : 'mt-1 block w-full bg-gray-200 dark:bg-gray-600 border-gray-300 dark:border-gray-500 text-gray-500 dark:text-gray-400 rounded-md cursor-not-allowed opacity-60'
                                "
                                placeholder="Seleziona uno stato..."
                                v-model:modelValue="filterValues.dateEnd"
                                :isDisabled="filterValues.dateStart === ''"
                                :min="filterValues.dateStart"
                            />
                            <InputError
                                class="mt-2 text-red-600 dark:text-red-400"
                                :message="errors.dateEnd"
                            />
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <StatusCheckbox
                                v-for="status in statuses"
                                :key="status.id"
                                :id="`status-${status.id}`"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                :label="status.name"
                                :valueCheckbox="status.id"
                                v-model:modelValue="filterValues.statuses"
                            />
                            <InputError
                                class="mt-2 text-red-600 dark:text-red-400"
                                :message="errors.statuses"
                            />
                        </div>
                        <div>
                            <PrimaryButton
                                class="lg:mt-6"
                                :isDisabled="!isFiltered"
                                @click="
                                    filterValues = { ...initialFilterValues }
                                "
                            >
                                Resetta
                            </PrimaryButton>
                        </div>
                    </div>
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
                                    @click="
                                        !isFiltered
                                            ? navigate(currentPage - 1)
                                            : filter(currentPage - 1)
                                    "
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
                                    @click="
                                        !isFiltered
                                            ? navigate(page)
                                            : filter(page)
                                    "
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
                                    @click="
                                        !isFiltered
                                            ? navigate(currentPage + 1)
                                            : filter(currentPage + 1)
                                    "
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
