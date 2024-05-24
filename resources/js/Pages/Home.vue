<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";


const showingNavigationDropdown = ref(false);

</script>

<template>
    <Head title="Home" />

        <div class="min-h-screen bg-gray-100">
           <!-- Header -->
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard.tickets.index')">
                                  Dashboard
                                </NavLink>
   
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="bg-white max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
              <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2> -->
              <div class="flex gap-5">
              <a :href="route('login')" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="http://127.0.0.1:8000/dashboard/tickets"> Login </a>
              <a :href="route('register')" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="http://127.0.0.1:8000/dashboard/tickets"> Sign up </a>

              </div>
            </div>

            <!-- Page Content -->
            <main>                
              <div class="py-12">
                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                          <p class="p-6 text-gray-900">Questa è la Guest Homepage del sito!</p>
                      </div>
                  </div>
              </div>
            </main>
        </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
