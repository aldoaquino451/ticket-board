<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
// import { ref, defineProps } from "vue";
// import axios from "axios";

const props = defineProps({
  ticket: Object,
});

console.log(props);
</script>


<template>
  <Head title="Operatore" />

  <AuthenticatedLayout>
    <!-- page name -->
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">Dettagli Operatore</h2>
    </template>


    <div class="py-12 text-gray-300">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <p v-for="(value, key) in props.ticket">{{ key }} : {{ value }}</p>
      </div>
    </div> 
  </AuthenticatedLayout>

</template>

























<!-- 
<script setup>
import { ref, reactive } from '@vue/reactivity';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

// Definizione delle variabili reactive
const isLoading = ref(true);
const error = ref(null);
const users = ref([]);

// Fetch dei dati dall'API
async function fetchData() {
  try {
    const res = await axios.get('https://jsonplaceholder.typicode.com/users');
    users.value = res.data;
  } catch (err) {
    error.value = err.message;
  } finally {
    isLoading.value = false;
  }

  console.log(users.value);
}

// Esegui il fetch dei dati quando il componente viene montato
fetchData();
</script>
<template>
  <Head title="Advanced" />

  <div>
    <h1>Componente avanzato con Composition API</h1>
    <template v-if="isLoading">
      <div class="loading">Caricamento in corso...</div>
    </template>
    <template v-else-if="error">
      <div class="error">Si è verificato un errore: {{ errorMessage }}</div>
    </template>
    <template v-else>
      <p v-for="user in users" :key="user.id" :user="user">{{ user.name }}</p>
    </template>
  </div>
</template>
-->