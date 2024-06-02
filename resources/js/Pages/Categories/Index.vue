<script setup>
import { ref, defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted } from 'vue';


const props = defineProps({
  categories: Object,
  success: String,
});

// form per aggiungere una catergoria nuova
const formStore = useForm({ 
  name: "",
})
const storeCategory = () => {
  if (formStore.name == '') return;
  formStore.post(route("dashboard.categories.store"), {
    onSuccess: () => formStore.reset()
  });
};

const flag = ref(true);
const category_slug = ref('');
const modal = ref();

const deleteCategory = (slug) => {
  if (slug == '') return;
  useForm({ }).delete(route("dashboard.categories.destroy", slug), {
    onSuccess: () => toggleModal(slug)
  });
};

const toggleModal = (slug) => {
  modal.value.style.display = flag.value ? 'flex' : 'none';
  flag.value = !flag.value;
  category_slug.value = slug;
}

onMounted(() => {
  modal.value = document.getElementById('modal');
  modal.value.style.display = 'none';
});

</script>


<template>
  <Head title="Categorie" />

  <div id="modal" class="fixed z-10 h-screen	w-full flex justify-center items-center bg-black bg-opacity-20">
    <div class="p-6 bg-white rounded-lg flex flex-col gap-6 justify-center items-center shadow-xl">
      <p>Sei sicuro di voler eliminare questo elemento?</p>
      <div class="flex gap-3">
        <button @click.prevent="toggleModal('')" class="text-white bg-gray-500 px-6 py-2 rounded-md">
          Annulla
        </button>
        <form @submit.prevent="deleteCategory(category_slug)">
          <button type="submit" class="text-white bg-red-500 px-6 py-2 rounded-md">
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </form>
      </div>
    </div>
  </div>

  <AuthenticatedLayout>
    <!-- page name -->
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
        Categorie
      </h2>
    </template>

    <!-- page content -->
    <div class="py-12">
      <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <!-- aggiungi nuova categoria -->
        <form @submit.prevent="storeCategory">
          <div class="mb-6 relative">
            <input type="text" v-model="formStore.name" class="my-input w-full pe-40 ps-5 border-gray-300 focus:ring-blue-200">
            <button type="submit" class="px-4 py-2 h-12 bg-blue-600 rounded-3xl absolute end-1.5 top-1.5 font-semibold text-xs text-white uppercase hover:bg-blue-500 active:bg-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">Nuova Categoria</button>
          </div>
        </form>

        <!-- lista delle categorie -->
        <p v-if="!props.categories.length" class="text-center dark:text-white">Inserisci almeno una categoria per poterla visualizzare.</p>
        <ul v-else class="my-list p-4 bg-white rounded-3xl">
          <li v-for="category in categories" class="my-item flex justify-between items-center"> 
            <span class="p-4">{{ category.name }}</span>
            <button @click.prevent="toggleModal(category.slug)" class="my-icon cursor-pointer flex items-center justify-center">
              <i class="fa-solid fa-trash-can"></i>
            </button>
          </li>
        </ul>

      </div>
    </div>
  </AuthenticatedLayout>

</template>


<style lang="scss" scoped>

.my-input {
  height: 60px;
  border-radius: 30px;
}

.my-list {
  border-radius: 30px;

  .my-item {
    background-color: none;
    border-radius: 30px;
    
    &:hover {
      background-color: rgb(226 232 240);
    }
  }

  .my-icon {
    background-color: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    
    &:hover {
      background-color: rgb(241 245 249);
      border: 1px solid rgb(203 213 225);
    }
  }

}
</style>