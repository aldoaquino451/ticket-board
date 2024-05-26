<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  notes: Object,
})

const name = ref('aldo');
const search = ref('');




console.log(name.value);  
console.log(props.notes);       

</script>


<template>
  <Head title="Notes" />

  <div>
    <p>{{ name }}</p>
    <ul>
      <li v-for="note in props.notes">{{ note }}</li>
    </ul>
    <input type="text" v-model="search">
    <p>{{ search }}</p> 
  </div>
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