<script setup>
import SidebarMenu from "./components/Includes/SidebarMenu.vue";
import NavBar from "./components/Includes/NavBar.vue";
</script>
<template>
  <div class="lg:flex w-[100vw] cus-main">
    <div >
      <div class="hidden h-full lg:block">
        <SidebarMenu />
      </div>
      <div class=" w-full lg:hidden">
        <NavBar></NavBar>
      </div>
    </div>

    <div class="h-full w-full py-[30px] px-[50px]">
      <router-view></router-view>
    </div>
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: unset;
  width: 100%;
  max-width: 100%;
  padding: unset;
}
.cus-main {
  min-height: 100vh;
}
</style>
