<template>
  <div class="w-64 bg-gray-900 text-white p-5">
    <h2 class="text-xl font-bold mb-6">Health App</h2>

    <ul class="space-y-3">
      <li><router-link to="/dashboard">🏠 Dashboard</router-link></li>
      <li><router-link to="/members">👤 Members</router-link></li>
      <li><router-link to="/plans">📦 Plans</router-link></li>
      <li><router-link to="/claims">💸 Claims</router-link></li>
      <li><router-link to="/reports">📊 Reports</router-link></li>
    </ul>
  </div>
</template>