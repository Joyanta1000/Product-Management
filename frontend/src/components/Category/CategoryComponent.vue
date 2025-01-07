<template>
  <div>
    <div class="py-10">
      <h2 class="text-3xl">Manage Categories</h2>
    </div>

    <CategoryCreate
      @submit-data="handleSubmit"
      :validation-errors="validationErrors"
    />

    <CategoryList
      :categories="categories"
      @change-page="changePage"
      :pagination="pagination"
      @delete-category="confirmDeleteCategory"
      @edit-category="editCategory"
    />
  </div>
</template>

<script>
import { ref, watch } from "vue";
import CategoryCreate from "./CategoryCreate.vue";
import CategoryList from "./CategoryList.vue";
import categoryService from "@/categoryService";
import Swal from "sweetalert2";

export default {
  components: { CategoryCreate, CategoryList },

  data() {
    return {
      categories: [],
      validationErrors: {},
      pagination: { currentPage: 1, perPage: 10, totalPages: 0 },
    };
  },

  methods: {
    async fetchCategoriesData() {
      try {
        const data = await categoryService.fetchCategories(
          this.pagination.currentPage,
          this.pagination.perPage
        );
        this.categories = data.data;
        this.pagination.totalPages = data.last_page;
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    },

    async handleSubmit(data) {
      try {
        await categoryService.addCategory(data);
        await this.fetchCategoriesData();
        this.validationErrors = {};
        Swal.fire({
          title: "Success!",
          text: "Category added successfully.",
          icon: "success",
          confirmButtonText: "OK",
        });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.validationErrors = error.response.data.errors;
        } else {
          console.error("Error storing data:", error);
        }
      }
    },

    changePage(page) {
      this.pagination.currentPage = page;
      this.fetchCategoriesData();
    },

    async confirmDeleteCategory(categoryId) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, keep it",
      });

      if (result.isConfirmed) {
        this.deleteCategory(categoryId);
      }
    },

    async deleteCategory(categoryId) {
      try {
        await categoryService.deleteCategory(categoryId);
        Swal.fire({
          title: "Deleted!",
          text: "Category deleted successfully.",
          icon: "success",
          confirmButtonText: "OK",
        });
        this.fetchCategoriesData();
      } catch (error) {
        console.error("Error deleting category:", error);
      }
    },

    editCategory(categoryId) {
      this.$router.push({
        name: "CategoryEdit",
        params: { categoryId: categoryId },
      });
    },
  },

  mounted() {
    this.fetchCategoriesData();
  },
};
</script>
