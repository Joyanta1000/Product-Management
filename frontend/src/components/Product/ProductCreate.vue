<template>
  <form
    ref="productForm"
    class="w-full max-w-lg "
    @submit.prevent="submitForm"
    enctype="multipart/form-data"
  >
    <div class="w-full space-y-6">
      <div>
        <label
          for="product-name"
          class="block text-xl font-medium text-gray-700"
        >
          Product Name
        </label>
        <input
          type="text"
          v-model="formData.name"
          id="product-name"
          class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter product name"
        />
        <ul v-if="validationErrors.name" class="text-red-500 text-sm mt-1">
          <li v-for="(error, index) in validationErrors.name" :key="index">
            {{ error }}
          </li>
        </ul>
      </div>

      <div>
        <label for="price" class="block text-xl font-medium text-gray-700">
          Price
        </label>
        <input
          type="text"
          v-model="formData.price"
          id="price"
          class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter product price"
        />
        <ul v-if="validationErrors.price" class="text-red-500 text-sm mt-1">
          <li v-for="(error, index) in validationErrors.price" :key="index">
            {{ error }}
          </li>
        </ul>
      </div>

      <div>
        <label for="categories" class="block text-xl font-medium text-gray-700">
          Categories
          <p class="text-red-500 text-sm">
            (Ctrl + Mouse's Left Key to select multiple)
          </p>
        </label>
        <select
          v-model="formData.categories"
          id="categories"
          multiple
          class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
        >
          <option
            class="p-2 text-xl"
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
        <ul
          v-if="validationErrors.categories"
          class="text-red-500 text-sm mt-1"
        >
          <li
            v-for="(error, index) in validationErrors.categories"
            :key="index"
          >
            {{ error }}
          </li>
        </ul>
      </div>

      <div>
        <label for="image" class="block text-xl font-medium text-gray-700">
          Product Image
        </label>
        <input
          type="file"
          id="image"
          @change="handleFileUpload"
          ref="fileInput"
          class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
        />
        <ul v-if="validationErrors.image" class="text-red-500 text-sm mt-1">
          <li v-for="(error, index) in validationErrors.image" :key="index">
            {{ error }}
          </li>
        </ul>
      </div>

      <button
        type="submit"
        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-md transition duration-300"
      >
        Add Product
      </button>
    </div>
  </form>
</template>

<script>
import productService from "@/productService";
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
        price: "",
        categories: [],
        image: null,
      },
      categories: [],
    };
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await productService.getCategories();
        this.categories = response;
      } catch (error) {
        console.error(error);
      }
    },
    handleFileUpload(event) {
      this.formData.image = event.target.files[0];
    },
    submitForm() {
      this.$emit("submit-data", { ...this.formData });
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>
