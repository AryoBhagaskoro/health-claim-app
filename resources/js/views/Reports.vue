<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold">Reports</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="bg-white p-6 rounded-xl shadow flex flex-col items-center">
        <h3 class="font-semibold mb-4">Member by Plan</h3>

      <div class="w-[300px] h-[300px]">
        <Pie v-if="pieData" :data="pieData" :options="pieOptions" />
      </div>
    </div>

      <div class="bg-white p-6 rounded-xl shadow flex flex-col items-center">
        <h3 class="font-semibold mb-4">Total Claim per Member</h3>
       <Bar v-if="barData" :data="barData" :options="barOptions" />
      </div>

    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Name</th>
            <th>Total Claim</th>
            <th>Approved</th>
            <th>Excess</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="r in reports" :key="r.policy_number" class="border-t text-center">
            <td>{{ r.member_id }}</td>
            <td class="p-3 text-left">{{ r.name }}</td>
            <td>{{ formatRupiah(r.total_claim) }}</td>
            <td class="text-green-600">{{ formatRupiah(r.total_approved) }}</td>
            <td class="text-red-500">{{ formatRupiah(r.total_excess) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

import { Pie, Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  BarElement
} from "chart.js";

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  BarElement
);

const reports = ref([]);
const pieData = ref(null);
const barData = ref(null);

const barOptions = {
  plugins: {
    legend: {
      display: false
    }
  }
};

const formatRupiah = (value) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0
  }).format(value || 0);
};

const loadReports = async () => {
  try {
    const reportRes = await api.get("/reports/claims");
    reports.value = reportRes.data;

    const memberRes = await api.get("/members");

    const memberCount = {};

    memberRes.data.forEach(m => {
      const plan = m.benefit_plan?.plan_name || "No Plan";
      memberCount[plan] = (memberCount[plan] || 0) + 1;
    });

    pieData.value = {
      labels: Object.keys(memberCount),
      datasets: [
        {
          data: Object.values(memberCount),
          backgroundColor: [
            "#3b82f6",
            "#22c55e",
            "#ef4444"
          ]
        }
      ]
    };

    const claimsRes = await api.get("/claims");

    const claimPerPlan = {};

    claimsRes.data.forEach(c => {
      const plan = c.member?.benefit_plan?.plan_name || "No Plan";

      claimPerPlan[plan] =
        (claimPerPlan[plan] || 0) + Number(c.claim_amount || 0);
    });

    barData.value = {
      labels: Object.keys(claimPerPlan),
      datasets: [
        {
          data: Object.values(claimPerPlan),
          backgroundColor: [
            "#3b82f6",
            "#22c55e",
            "#ef4444"
          ]
        }
      ]
    };

  } catch (err) {
    console.error("REPORT ERROR:", err);
  }
};

onMounted(() => {
  loadReports();
});
</script>