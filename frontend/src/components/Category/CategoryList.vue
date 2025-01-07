<template>
  <div class="py-10">
    <table class="min-w-full border-collapse border border-gray-400">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2 text-left">
            Category Name
          </th>
          <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="category in categories"
          :key="category.id"
          class="border border-gray-300"
        >
          <td class="border border-gray-300 px-4 py-2">{{ category.name }}</td>
          <td class="border border-gray-300 px-4 py-2 text-center">
            <button
              @click="$emit('edit-category', category.id)"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"
            >
              Edit
            </button>
            <button
              @click="$emit('delete-category', category.id)"
              class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="pagination.totalPages > 0" class="mt-4 flex justify-center">
      <button
        v-if="pagination.currentPage > 1"
        @click="$emit('change-page', pagination.currentPage - 1)"
        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded"
      >
        Previous
      </button>
      <span class="mx-2 text-lg"
        >{{ pagination.currentPage }} / {{ pagination.totalPages }}</span
      >
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
  categories: {
    type: Array,
    required: true,
  },
  pagination: {
    type: Object,
    required: true,
  },
});
</script>
