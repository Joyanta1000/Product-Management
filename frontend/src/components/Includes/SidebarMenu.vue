<template>
  <aside class="w-64 h-full bg-blue-500 text-white p-4">
    <h2 class="text-lg font-semibold mb-6">Product Management</h2>
    <ul class="space-y-4">
      <li>
        <router-link to="/" :class="getLinkClass('/')">
          Categories
        </router-link>
      </li>
      <li>
        <router-link to="/products" :class="getLinkClass('/products')">
          Products
        </router-link>
      </li>
    </ul>
  </aside>
</template>

<script setup>
import { useRoute } from "vue-router";

const route = useRoute();

const isActive = (path) => {
  return route.path === path;
};

const getLinkClass = (path) => {
  return `block px-4 py-2 rounded transition-colors ${
    isActive(path) ? "bg-gray-700 font-bold" : "hover:bg-gray-700"
  }`;
};
</script>