<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Claims</h2>


<form @submit.prevent="submitClaim" class="bg-white p-4 rounded-xl shadow mb-6">
  <h3 class="font-semibold mb-3">Submit Claim</h3>

  <div class="grid grid-cols-3 gap-4 mb-4">
    
    <input
      v-model="form.member_id"
      type="number"
      placeholder="Member ID"
      class="border p-2 rounded"
    />

    <input
      v-model="form.claim_amount"
      type="number"
      placeholder="Claim Amount"
      class="border p-2 rounded"
    />

    <input
      v-model="form.claim_date"
      type="date"
      class="border p-2 rounded"
    />

  </div>
  <div class="flex justify-center">
    <button
      type="submit"
      class="bg-blue-600 text-white rounded px-8 py-2 hover:bg-blue-700"
    >
      Submit
    </button>
  </div>
</form>
    
   

  
    <table class="w-full bg-white shadow rounded-xl">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-3">Member</th>
          <th>Plan</th>
          <th>Amount</th>
          <th>Approved</th>
          <th>Excess</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="c in claims" :key="c.id" class="text-center">
          <td>{{ c.member?.name }}</td>
           <td> {{ c.member?.benefit_plan?.plan_name || '-' }}</td>
          <td>{{ formatRupiah(c.claim_amount) }}</td>
          <td class="text-green-600">
            {{ formatRupiah(c.approved_amount) }}
          </td>
          <td class="text-red-500">
            {{ formatRupiah(c.excess_amount) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const claims = ref([]);


const form = ref({
  member_id: "",
  claim_amount: "",
   claim_date: "" 
});


const formatRupiah = (value) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0
  }).format(value || 0);
};


const fetchClaims = async () => {
  try {
    const res = await api.get("/claims");
    console.log("DATA:", res.data);
    claims.value = res.data;
  } catch (err) {
    console.error(err);
  }
};


const submitClaim = async () => {
  try {
    console.log("KIRIM:", form.value);

    const res = await api.post("/claims", form.value);

    console.log("SUCCESS:", res.data);

    fetchClaims();

  } catch (err) {
  console.error("FULL ERROR:", err);
  console.error("RESPONSE:", err.response);
  console.error("DATA:", err.response?.data);
  }
};

onMounted(() => {
  fetchClaims();
});
</script>