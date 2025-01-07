<template>
  <form class="w-full max-w-sm" @submit.prevent="submitForm">
    <div>
      <label
        for="category-name"
        class="block text-xl font-medium text-gray-700"
      >
        Category Name
      </label>
      <input
        type="text"
        v-model="formData.name"
        id="category-name"
        class="mt-1 block w-full border border-gray-300 rounded-md px-2 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
      />
     
      <ul v-if="validationErrors.name" class="text-red-500 text-sm mt-1">
        <li v-for="(error, index) in validationErrors.name" :key="index">
          {{ error }}
        </li>
      </ul>

      <button
        type="submit"
        class="mt-3 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-md"
      >
        Add Category
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    validationErrors: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      formData: {
        name: "",
      },
    };
  },
  methods: {
    submitForm() {
    
      this.$emit("submit-data", { ...this.formData });
   
      this.formData.name = "";
    },
  },
};
</script>
