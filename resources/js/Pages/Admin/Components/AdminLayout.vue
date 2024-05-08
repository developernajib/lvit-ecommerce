<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navbar />
        <Sidebar />
        <main class="p-4 md:ml-64 h-auto pt-20">
            <div style="min-height:84.5vh;">
                <slot  />   
            </div>
            <Footer />
        </main>
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'
import Footer from './Footer.vue'

onMounted(() => {
    initFlowbite();
})
</script>