<template>
  <form
    class="w-full max-w-lg"
    @submit.prevent="submitUpdateForm"
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
        <ul v-if="localValidationErrors.name" class="text-red-500 text-sm mt-1">
          <li v-for="(error, index) in localValidationErrors.name" :key="index">
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
        <ul
          v-if="localValidationErrors.price"
          class="text-red-500 text-sm mt-1"
        >
          <li
            v-for="(error, index) in localValidationErrors.price"
            :key="index"
          >
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
            :selected="formData.categories.includes(category.id)"
          >
            {{ category.name }}
          </option>
        </select>
        <ul
          v-if="localValidationErrors.categories"
          class="text-red-500 text-sm mt-1"
        >
          <li
            v-for="(error, index) in localValidationErrors.categories"
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
        <div v-if="formData.imagePreview" class="mt-2">
          <img
            :src="formData.imagePreview"
            alt="Selected Product Image"
            class="h-32 object-cover rounded-md"
          />
        </div>
        <ul
          v-if="localValidationErrors.image"
          class="text-red-500 text-sm mt-1"
        >
          <li
            v-for="(error, index) in localValidationErrors.image"
            :key="index"
          >
            {{ error }}
          </li>
        </ul>
      </div>

      <button
        type="submit"
        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-md transition duration-300"
      >
        Update Product
      </button>
    </div>
  </form>
</template>

<script>
import productService from "@/productService";
import Swal from "sweetalert2";
import axios from "axios";
import { apiBaseUrl } from "@/apiService";

export default {
  props: {
    validationErrors: {
      type: Object,
      default: () => ({}),
    },
    productData: {
      type: Object,
      default: () => ({}),
    },
    productId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      formData: {
        name: "",
        price: "",
        categories: [],
        image: null,
        imagePreview: null,
      },
      categories: [],
      localValidationErrors: {},
    };
  },
  watch: {
    productData: {
      immediate: true,
      handler(newData) {
        this.formData.name = newData.name || "";
        this.formData.price = newData.price || "";
        this.formData.categories = newData.categories || [];
        this.formData.imagePreview = newData.image || null;
      },
    },
    validationErrors: {
      immediate: true,
      deep: true,
      handler(newErrors) {
        this.localValidationErrors = { ...newErrors };
      },
    },
  },
  methods: {
    async editProductData() {
      try {
        const response = await productService.editProduct(this.productId);
        this.formData.name = response.name;
        this.formData.price = response.price;
        this.formData.categories = response.categories.map((cat) => cat.id);
        this.formData.imagePreview =
          "http://127.0.0.1:8000/storage/product_images/" + response.image;
      } catch (error) {
        console.error("Error fetching product data:", error);
      }
    },
    async fetchCategories() {
      try {
        const response = await productService.getCategories();
        this.categories = response;
      } catch (error) {
        console.error(error);
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.formData.image = file;
        this.formData.imagePreview = URL.createObjectURL(file);
      }
    },
    async submitUpdateForm() {
      try {
        const data = new FormData();
        data.append("name", this.formData.name);
        data.append("price", this.formData.price);
        this.formData.categories.forEach((category) =>
          data.append("categories[]", category)
        );
        if (this.formData.image) {
          data.append("image", this.formData.image);
        }

        await productService.updateProduct(this.productId, data);

        this.localValidationErrors = {};
        Swal.fire({
          title: "Success!",
          text: "Product updated successfully.",
          icon: "success",
          confirmButtonText: "OK",
        });

        this.$router.push({ name: "ProductInfo" });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.localValidationErrors = error.response.data.errors;
        } else {
          console.error("Error updating data:", error);
        }
      }
    },
  },
  mounted() {
    this.editProductData();
    this.fetchCategories();
  },
};
</script>
