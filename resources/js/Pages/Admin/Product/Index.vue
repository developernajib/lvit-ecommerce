<script setup>
import AdminLayout from '../Components/AdminLayout.vue'
import ProductList from './ProductList.vue'

defineProps({
    products: Array
})
</script>
<template>
    <AdminLayout>
        <ProductList :products="products"></ProductList>
    </AdminLayout>
</template>