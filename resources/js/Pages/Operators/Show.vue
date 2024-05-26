<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

// import axios from "axios";
const new_note = ref('');

const props = defineProps({
  ticket: Object,
  slug: String,
  notes: Array
});

const form = useForm({
  status: props.ticket.status == 'assigned' ? 'in progress' : 'closed',
  ticket: props.ticket,
});

const formNote = useForm({
  new_note: new_note,
});

const submit = () => {
  form.put(route("dashboard.operators.update", props.slug));
};

const addNote = () => {
  console.log(formNote);   
  form.post(route("dashboard.notes.store"));
};


console.log(props.ticket.status);
console.log(props.notes);
</script>


<template>
  <Head title="Operatore" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">Dettagli Operatore</h2>
    </template>

    <div class="py-12 text-gray-300">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      
        <form @submit.prevent="submit" class="space-y-6 lg:space-y-0 lg:flex flex-wrap">
          <PrimaryButton class="lg:mt-6" >
              {{ props.ticket.status == 'assigned' ? 'In progress' : 'Closed'}}
          </PrimaryButton>
        </form>

        <div class="mt-8">
          <p v-for="(value, key) in props.ticket">{{ key }} : {{ value }}</p>
        </div>

        <!-- 
        <div class="mt-8">
          <form @submit.prevent="addNote" class="space-y-6 lg:space-y-0 lg:flex flex-wrap">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aggiungi una Nota</label>
            <input  type="text" id="content" name="content" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nota..." required />
          </form>
        </div>       
        -->

        <div class="mt-8 ">
          <p>Note</p>
          <ul class="ps-6 list-disc">
            <li v-for="note in notes">{{ note.content }}</li>
          </ul>
        </div>

      </div>
    </div> 
  </AuthenticatedLayout>

</template>



















