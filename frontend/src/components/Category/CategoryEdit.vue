<template>
  <form class="w-full max-w-sm" @submit.prevent="submitUpdateForm">
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
        id="name"
        class="mt-1 block w-full border border-gray-300 rounded-md px-2 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
      />

      <ul v-if="localValidationErrors.name" class="text-red-500 text-sm mt-1">
        <li v-for="(error, index) in localValidationErrors.name" :key="index">
          {{ error }}
        </li>
      </ul>

      <button
        type="submit"
        class="mt-3 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-md"
      >
        Update Category
      </button>
    </div>
  </form>
</template>

<script>
import categoryService from "@/categoryService";
import Swal from "sweetalert2";

export default {
  props: {
    validationErrors: {
      type: Object,
      default: () => ({}),
    },
    categoryData: {
      type: Object,
      default: () => ({}),
    },
    categoryId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      formData: {
        name: "",
      },
      localValidationErrors: {},
    };
  },
  watch: {
    categoryData: {
      immediate: true,
      handler(newData) {
        this.formData.name = newData.name || "";
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
    async editCategoryData() {
      try {
        const response = await categoryService.editCategory(this.categoryId);
        this.formData.name = response.name;
      } catch (error) {
        console.error("Error fetching category data:", error);
      }
    },

    async submitUpdateForm() {
      try {
        await categoryService.updateCategory({
          id: this.categoryId,
          ...this.formData,
        });

        this.localValidationErrors = {};
        Swal.fire({
          title: "Success!",
          text: "Category updated successfully.",
          icon: "success",
          confirmButtonText: "OK",
        });

        this.$router.push({ name: "CategoryInfo" });
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
    this.editCategoryData();
  },
};
</script>
