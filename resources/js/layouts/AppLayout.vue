<template>
  <div class="flex h-screen bg-gray-100 overflow-hidden">
    <aside class="w-64 bg-gray-900 text-white fixed h-full">
      <div class="w-64 h-full p-5 border-r border-gray-700">
        
        <h2 class="text-2xl font-bold mb-8 tracking-wide">
          Health App
        </h2>

        <ul class="space-y-2">
          <li>
            <router-link to="/dashboard" class="menu">🏠 Dashboard</router-link>
          </li>
          <li>
            <router-link to="/members" class="menu">👤 Members</router-link>
          </li>
          <li>
            <router-link to="/plans" class="menu">📦 Plans</router-link>
          </li>
          <li>
            <router-link to="/claims" class="menu">💸 Claims</router-link>
          </li>
          <li>
            <router-link to="/reports" class="menu">📊 Reports</router-link>
          </li>
        </ul>

      </div>
    </aside>

    <div class="ml-64 flex-1 flex flex-col">
      
      <header class="bg-white px-8 py-4 flex items-center justify-between border-b border-gray-300 shadow-sm">
        
        <div>
          <h1 class="text-xl font-semibold text-gray-800">
            Health Claim System
          </h1>
          <p class="text-sm text-gray-400">
            Welcome back, Admin
          </p>
        </div>

        <div class="flex items-center gap-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
              A
            </div>
            <div>
              <p class="text-sm font-medium text-gray-700">Admin</p>
              <p class="text-xs text-gray-400">Administrator</p>
            </div>
          </div>

          <div class="h-6 w-px bg-gray-200"></div>

          <button 
            @click="logout"
            class="px-4 py-2 text-sm text-gray-600 hover:text-red-500 hover:bg-red-50 rounded-lg transition"
          >
            Logout ↪
          </button>
        </div>

      </header>

      <main class="flex-1 p-6 overflow-y-auto">
        <router-view />
      </main>

    </div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const logout = () => {
  localStorage.removeItem("token");
  router.push("/login");
};
</script>

<style>
.menu {
  display: block;
  padding: 10px 20px;
  color: #374151;
}
.menu:hover {
  background: #f3f4f6;
  color: #2F4EA2;
}
</style>