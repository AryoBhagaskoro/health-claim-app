<template>
  <div class="bg-white shadow px-6 py-4 flex justify-between">
    <h1 class="font-semibold">Dashboard</h1>

    <button @click="logout" class="text-red-500">
      Logout
    </button>
  </div>
</template>

<script setup>
const logout = () => {
  localStorage.removeItem("token");
  window.location.href = "/";
};
</script>