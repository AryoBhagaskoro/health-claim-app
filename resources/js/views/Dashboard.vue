<template>
  <div>
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <div class="bg-white p-6 rounded-xl shadow-md border border-gray-400">
        <p class="text-gray-500">Total Members</p>
        <h3 class="text-3xl font-bold text-blue-600 mt-2">
          {{ stats.members }}
        </h3>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-md border border-gray-400">
        <p class="text-gray-500">Total Claims</p>
        <h3 class="text-3xl font-bold text-yellow-600 mt-2">
          {{ formatRupiah(stats.claims) }}
        </h3>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-md border border-gray-400">
        <p class="text-gray-500">Total Approved</p>
        <h3 class="text-3xl font-bold text-green-600 mt-2">
           {{ formatRupiah(stats.approved) }}
        </h3>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const stats = ref({
  members: 0,
  claims: 0,
  approved: 0
});

const loadDashboard = async () => {
  try {
    const membersRes = await api.get("/members");
    const claimsRes = await api.get("/reports/claims");

    stats.value = {
      members: membersRes.data.data
        ? membersRes.data.data.length
        : membersRes.data.length,

      claims: claimsRes.data.reduce((a, b) => {
        return a + Number(b.total_claim || 0);
      }, 0),

      approved: claimsRes.data.reduce((a, b) => {
        return a + Number(b.total_approved || 0);
      }, 0),
    };

  } catch (err) {
    console.error("Dashboard error:", err);
  }
};

onMounted(() => {
  loadDashboard();
});


const formatRupiah = (value) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(value || 0);
};
</script>