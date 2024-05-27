<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Textarea from "@/Components/Textarea.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, watch } from "vue";

const new_note = ref("");

const props = defineProps({
    ticket: Object,
    slug: String,
    operator_id: Number,
    notes: Array,
});

const editableNotes = ref(props.notes.map((note) => ({ ...note })));

watch(
    () => props.notes,
    (notes) => {
        editableNotes.value = notes.map((note) => ({ ...note }));
    },
    { immediate: true }
);

console.log(editableNotes.value);

const form = useForm({
    status: props.ticket
        ? props.ticket.status == "assigned"
            ? "in progress"
            : "closed"
        : "",
    ticket_id: props.ticket ? props.ticket.id : "",
});

const submit = () => {
    form.put(route("dashboard.operators.update", props.slug), {
        onSuccess: () => {
            if (form.status === "in progress") {
                router.visit(
                    route("dashboard.operators.show", { operator: props.slug })
                );
            } else {
                router.visit(route("dashboard.operators.index"));
            }
        },
    });
};

const formCreateNote = useForm({
    ticket_id: props.ticket ? props.ticket.id : "",
    operator_id: props.operator_id ?? "",
    content: "",
});

const submitCreateNote = () => {
    formCreateNote.post(route("dashboard.notes.store"), {
        onSuccess: () => {
            formCreateNote.content = ""; // Reset the content of the textarea
        },
    });
};

const formUpdateNote = useForm({
    id: "",
    operator_id: props.operator_id ?? "",
    content: "",
});

const submitUpdateNote = (id, content) => {
    formUpdateNote.id = id;
    formUpdateNote.content = content;
    formUpdateNote.put(route("dashboard.notes.update", formUpdateNote.id));
};

const formDeleteNote = useForm({
    id: "",
    operator_id: props.operator_id ?? "",
});

const submitDeleteNote = (id) => {
    formDeleteNote.id = id;
    formDeleteNote.delete(route("dashboard.notes.destroy", formDeleteNote.id));
};

// const formNote = useForm({
//     new_note: new_note,
// });

// const addNote = () => {
//     formNote.post(route("dashboard.notes.store"));
// };

const getRandomPastelColorClass = () => {
    const colors = [
        "bg-pink-100 dark:bg-pink-900",
        "bg-yellow-100 dark:bg-yellow-900",
        "bg-green-100 dark:bg-green-900",
        "bg-blue-100 dark:bg-blue-900",
        "bg-purple-100 dark:bg-purple-900",
        "bg-indigo-100 dark:bg-indigo-900",
    ];

    return colors[Math.floor(Math.random() * colors.length)];
};

console.log(props.ticket);
console.log(props.notes);
</script>

<template>
    <Head title="Operatore" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-white leading-tight"
            >
                Dettagli Operatore
            </h2>
        </template>

        <div class="py-12 text-gray-300">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form
                    v-if="props.ticket"
                    @submit.prevent="submit"
                    class="space-y-6 lg:space-y-0 lg:flex flex-wrap"
                >
                    <PrimaryButton class="lg:mt-6">
                        {{
                            props.ticket.status == "assigned"
                                ? "In progress"
                                : "Closed"
                        }}
                    </PrimaryButton>
                </form>

                <div
                    v-if="props.ticket"
                    class="mt-8 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg"
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
                            Mostra tutti i dettagli del ticket assegnato
                            all'operatore.
                        </p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700">
                        <dl
                            class="divide-y divide-gray-200 dark:divide-gray-700"
                        >
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
                                    {{ props.ticket.title }}
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
                                    {{ props.ticket.code }}
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
                                    {{ props.ticket.description }}
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
                                    {{ props.ticket.status }}
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
                                        props.ticket.category
                                            ? props.ticket.category.name
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
                                        props.ticket.operator
                                            ? `${props.ticket.operator.name} ${props.ticket.operator.surname}`
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
                                    Data Creazione
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{
                                        new Date(
                                            props.ticket.created_at
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
                                    Data Aggiornamento
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2"
                                >
                                    {{
                                        new Date(
                                            props.ticket.updated_at
                                        ).toLocaleString()
                                    }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div
                    v-else
                    class="mt-8 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg"
                >
                    <div class="px-4 py-5 sm:px-6">
                        <h3
                            class="text-lg leading-6 font-medium text-gray-900 dark:text-white"
                        >
                            Nessun Ticket Assegnato
                        </h3>
                        <p
                            class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                        >
                            Non ci sono ticket assegnati a questo operatore al
                            momento.
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    <p
                        class="text-lg font-semibold text-gray-800 dark:text-white"
                    >
                        Note
                    </p>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4"
                    >
                        <div
                            v-for="note in editableNotes"
                            :key="note.id"
                            :class="`${getRandomPastelColorClass()} text-gray-900 dark:text-gray-800 rounded-lg shadow-md relative`"
                        >
                            <div class="p-4 pt-3 pb-12">
                                <div class="note-box">
                                    <div class="text-gray-800 dark:text-white">
                                        <form
                                            @submit.prevent="
                                                submitDeleteNote(note.id)
                                            "
                                        >
                                            <PrimaryButton
                                                class="bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 p-2 rounded-full text-white hover:text-white dark:bg-red-800 dark:hover:bg-red-700 dark:hover:text-gray-100 focus:outline-none"
                                                :disabled="
                                                    formCreateNote.processing
                                                "
                                            >
                                                <i class="fas fa-times"></i>
                                            </PrimaryButton>
                                        </form>
                                        <form
                                            @submit.prevent="
                                                submitDeleteNote(note.id)
                                            "
                                            class="pt-5 space-y-6"
                                        >
                                            <div>
                                                <InputLabel
                                                    for="note_content"
                                                    value=""
                                                    class="text-gray-900 dark:text-gray-200"
                                                />

                                                <Textarea
                                                    id="note_content"
                                                    class="mt-1 block w-full bg-transparent border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md p-0"
                                                    :value="note.content"
                                                    v-model="note.content"
                                                    required
                                                    rows="5"
                                                />

                                                <InputError
                                                    class="mt-2 text-red-600 dark:text-red-400"
                                                    :message="
                                                        formCreateNote.errors
                                                            .note_content
                                                    "
                                                />
                                            </div>
                                            <div
                                                class="absolute bottom-2 left-3 flex items-center justify-end mt-4"
                                            >
                                                <PrimaryButton
                                                    :class="{
                                                        'opacity-25':
                                                            formCreateNote.processing,
                                                    }"
                                                    :disabled="
                                                        formCreateNote.processing
                                                    "
                                                >
                                                    Modifica
                                                </PrimaryButton>
                                            </div>
                                        </form>
                                    </div>
                                    <span
                                        class="absolute bottom-2 right-3 text-xs text-gray-500 dark:text-gray-300"
                                        :title="
                                            new Date(
                                                note.created_at
                                            ).toLocaleString()
                                        "
                                    >
                                        ({{
                                            new Date(
                                                note.created_at
                                            ).toLocaleString()
                                        }})
                                    </span>
                                </div>
                            </div>
                            <span
                                v-if="props.notes.length === 0"
                                class="text-gray-900 dark:text-white"
                            >
                                Nessuna nota disponibile.
                            </span>
                        </div>
                    </div>
                    <div
                        v-if="props.notes.length !== 0"
                        :class="`${getRandomPastelColorClass()} mt-5 p-4 text-gray-900 dark:text-gray-800 rounded-lg shadow-md relative`"
                    >
                        <div class="relative note-box">
                            <div class="text-gray-800 dark:text-white">
                                <form
                                    @submit.prevent="submitCreateNote"
                                    class="p-6 space-y-6"
                                >
                                    <div>
                                        <InputLabel
                                            for="note_content"
                                            value="Nuova nota:"
                                            class="text-gray-900 dark:text-gray-200"
                                        />

                                        <Textarea
                                            id="note_content"
                                            class="mt-1 block w-full bg-transparent border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-300 rounded-md"
                                            v-model="formCreateNote.content"
                                            required
                                            rows="5"
                                        />

                                        <InputError
                                            class="mt-2 text-red-600 dark:text-red-400"
                                            :message="
                                                formCreateNote.errors
                                                    .note_content
                                            "
                                        />
                                    </div>
                                    <div
                                        class="flex items-center justify-end mt-4"
                                    >
                                        <PrimaryButton
                                            :class="{
                                                'opacity-25':
                                                    formCreateNote.processing,
                                            }"
                                            :disabled="
                                                formCreateNote.processing
                                            "
                                        >
                                            Crea
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
.note-date {
    opacity: 0%;
    user-select: none;
}

.note-box:hover {
    cursor: pointer;
    .note-date {
        opacity: 100%;
    }
}
</style>
