<template>
  <div>
    <!-- Navbar -->
    <nav class="bg-blue-500 p-4">
      <div class="flex justify-between items-center">
        <!-- Logo -->
        <div class="text-white text-2xl">
          <a href="#">Product Management</a>
        </div>

        <!-- Hamburger Menu for Mobile -->
        <button @click="toggleMenu" class="block lg:hidden text-white">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </button>

        <!-- <div class="hidden lg:flex space-x-4 text-white">
           <router-link to="/" :class="getLinkClass('/')">
          Categories
        </router-link>
        <router-link to="/products" :class="getLinkClass('/products')">
          Products
        </router-link>
          </div> -->
      </div>
    </nav>

    <div
      v-if="isMenuOpen"
      class="lg:hidden bg-blue-500 space-y-4 px-4 py-6 text-white"
    >
      <router-link to="/" :class="getLinkClass('/')"> Categories </router-link>
      <router-link to="/products" :class="getLinkClass('/products')">
        Products
      </router-link>
    </div>
  </div>
</template>

<script>
import { useRoute } from "vue-router";
export default {
  data() {
    return {
      isMenuOpen: false,
    };
  },
  computed: {
    route() {
      return useRoute();
    },
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },

    isActive(path) {
      return this.route.path === path;
    },

    getLinkClass(path) {
      return `block px-4 py-2 rounded transition-colors ${
        this.isActive(path) ? "bg-gray-700 font-bold" : "hover:bg-gray-700"
      }`;
    },
  },
};
</script>
