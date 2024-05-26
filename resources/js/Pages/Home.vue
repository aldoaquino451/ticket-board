<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";
</script>


<template>
  <Head title="Home" />

  <div class="min-h-screen bg-gray-100">

    <!-- header with logo -->
    <nav class="bg-white border-b border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="shrink-0 flex items-center">
              <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- buttons login and register -->
    <div class="bg-white">
      <div class="bg-white max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex gap-5">
          <NavLink :href="route('login')">Login</NavLink>
          <NavLink :href="route('register')">Register</NavLink>
        </div>
      </div>
    </div>

    <!-- main page Content -->
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


<style lang="scss" scoped>
</style>
