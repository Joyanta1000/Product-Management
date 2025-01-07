<template>
  <div>
    <div class="py-10 flex justify-between">
      <h2 class="text-3xl">Manage Products</h2>
      <div>
        <button @click="addProduct" class="w-40 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-md transition duration-300">Add Product</button>
      </div>
    </div>

    <div class="">
      <div v-if="add_product" class="transition duration-300">

        <ProductCreate
          @submit-data="handleSubmit"
          :validation-errors="validationErrors"
        />
      </div>

      <div class="py-5">
        <ProductList
          :products="products"
          @change-page="changePage"
          :pagination="pagination"
          @delete-product="confirmDeleteProduct"
          @edit-product="editProduct"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import ProductCreate from "./ProductCreate.vue";
import ProductList from "./ProductList.vue";
import productService from "@/productService";
import Swal from "sweetalert2";

export default {
  components: { ProductCreate, ProductList },

  data() {
    return {
      products: [],
      validationErrors: {},
      pagination: { currentPage: 1, perPage: 10, totalPages: 0 },
      add_product: false,
    };
  },

  methods: {

    addProduct(){
      this.add_product = !this.add_product;
    },
    async fetchProductsData() {
      try {
        const data = await productService.getProducts(
          this.pagination.currentPage,
          this.pagination.perPage
        );
        this.products = data.data;
        this.pagination.totalPages = data.last_page;
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    },

    async handleSubmit(data_form) {
      try {
        const data = new FormData();
        data.append("name", data_form.name);
        data.append("price", data_form.price);
        data_form.categories.forEach((category) =>
          data.append("categories[]", category)
        );
        data.append("image", data_form.image);

        const response = await productService.addProduct(data);

        this.validationErrors = {};

        Swal.fire({
          title: "Success!",
          text: "Product added successfully.",
          icon: "success",
          confirmButtonText: "OK",
        });
        this.fetchProductsData();
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.validationErrors = error.response.data.errors;
        } else {
          console.error("Error submitting form:", error);
        }
      }
    },

    resetForm() {
      this.validationErrors = {};
    },

    changePage(page) {
      this.pagination.currentPage = page;
      this.fetchProductsData();
    },

    async confirmDeleteProduct(productId) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, keep it",
      });

      if (result.isConfirmed) {
        this.deleteProduct(productId);
      }
    },

    async deleteProduct(productId) {
      try {
        await productService.deleteProduct(productId);
        Swal.fire({
          title: "Deleted!",
          text: "Product deleted successfully.",
          icon: "success",
          confirmButtonText: "OK",
        });
        this.fetchProductsData();
      } catch (error) {
        console.error("Error deleting product:", error);
      }
    },

    editProduct(productId) {
      this.$router.push({
        name: "ProductEdit",
        params: { productId: productId },
      });
    },
  },

  mounted() {
    this.fetchProductsData();
  },
};
</script>
