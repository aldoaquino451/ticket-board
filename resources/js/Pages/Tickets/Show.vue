<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    ticket: Object,
    flash: Object,
});

console.log(props.flash);
</script>

<template>
    <Head title="Dettagli Ticket" />
    
    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg"
                >
                    <div class="px-4 py-5 sm:px-6">
                        <h3
                            class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                        >
                            Dettagli del Ticket
                        </h3>
                        <p
                            class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                        >
                            Mostra tutti i dettagli del ticket selezionato.
                        </p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <dl
                            class="divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <div
                                v-if="flash"
                                :class="flash.class"
                                class="font-medium text-sm px-4 py-5 sm:px-6"
                            >
                                {{ flash.message }}
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Titolo
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{ ticket.title }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Codice
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{ ticket.code }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Descrizione
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{ ticket.description }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Stato
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{ ticket.status }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Categoria
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{
                                        ticket.category
                                            ? ticket.category.name
                                            : "N/A"
                                    }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Operatore
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{
                                        ticket.operator
                                            ? `${ticket.operator.name} ${ticket.operator.surname}`
                                            : "N/A"
                                    }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Data Crezione
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{
                                        new Date(
                                            ticket.created_at
                                        ).toLocaleString()
                                    }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            >
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-200"
                                >
                                    Data Aggiornamento                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{
                                        new Date(
                                            ticket.updated_at
                                        ).toLocaleString()
                                    }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
