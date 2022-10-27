<script setup>
import { ref } from 'vue';
import Navbar from '../Pages/Estructura/Navbar.vue'
import { RouterLink, RouterView } from 'vue-router'

defineProps({
    title: String,
});

</script>

<template>
    <div>

        <main>
            <Navbar />

            <slot />
        </main>
    </div>
</template>
