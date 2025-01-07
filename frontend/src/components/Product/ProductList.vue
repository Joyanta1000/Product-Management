<template>
  <div>
    <div class=" w-full py-10">
      <div class=" grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4  gap-4 ">
      <div v-for="product in products" :key="product.id" class="mb-6 ">
      <div class="max-w-lg h-[400px] bg-white rounded-lg shadow-md overflow-hidden">
        <div class=" h-[60%] flex justify-center items-center">

          <img
            class=" h-[220px] "
            :src="'http://127.0.0.1:8000/storage/product_images/' + product.image"
            alt="Product Image"
          />
        </div>
        <div class="p-5 h-[40%]">
          <h2 class="text-xl font-bold text-gray-900">{{ product.name }}</h2>
          <p class="text-gray-600 mt-2 text-3xl">{{ product.price }} BDT</p>
          <div class="mt-4 flex">
            <button
              @click="$emit('edit-product', product.id)"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
              Edit
            </button>
            <button
              @click="$emit('delete-product', product.id)"
              class="bg-red-500 ml-4 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    
    
    <div v-if="pagination.totalPages > 0" class="mt-4 flex justify-center">
      <button
        v-if="pagination.currentPage > 1"
        @click="$emit('change-page', pagination.currentPage - 1)"
        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded"
      >
        Previous
      </button>
      <span class="mx-2 text-lg">{{ pagination.currentPage }} / {{ pagination.totalPages }}</span>
      <button
        v-if="pagination.currentPage < pagination.totalPages"
        @click="$emit('change-page', pagination.currentPage + 1)"
        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  products: {
    type: Array,
    required: true,
  },
  pagination: {
    type: Object,
    required: true,
  },
});
</script>
