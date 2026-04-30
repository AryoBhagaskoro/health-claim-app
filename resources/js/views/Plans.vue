<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Benefit Plans</h2>

    <div class="mb-4">
      <input v-model="plan_name" placeholder="Plan Name" class="border p-2 mr-2" />
      <input v-model="annual_limit" placeholder="Annual Limit" class="border p-2 mr-2" />

      <button 
        v-if="!isEdit"
        @click="addPlan"
        class="bg-blue-500 text-white px-3 py-1 rounded"
      >
        Add
      </button>

      <button 
        v-else
        @click="updatePlan"
        class="bg-yellow-500 text-white px-3 py-1 rounded"
      >
        Update
      </button>

      <button 
        v-if="isEdit"
        @click="cancelEdit"
        class="bg-gray-500 text-white px-3 py-1 rounded ml-2"
      >
        Cancel
      </button>
    </div>

    <table class="mt-4 w-full bg-white shadow rounded">
      <tr v-for="plan in plans" :key="plan.id" class="border-t">
        <td class="p-2">{{ plan.plan_name }}</td>
        <td class="p-2">{{ formatRupiah(plan.annual_limit) }}</td>
        <td class="p-2 space-x-2">

          <button 
            @click="editPlan(plan)"
            class="bg-yellow-400 text-white px-2 py-1 rounded"
          >
            Edit
          </button>

          <button 
            @click="deletePlan(plan.id)"
            class="bg-red-500 text-white px-2 py-1 rounded"
          >
            Delete
          </button>

        </td>
      </tr>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const plans = ref([]);
const plan_name = ref("");
const annual_limit = ref("");

const isEdit = ref(false);
const editId = ref(null);

const formatRupiah = (value) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0
  }).format(value || 0);
};

const loadPlans = async () => {
  const res = await api.get("/benefit-plans");
  plans.value = res.data;
};

const addPlan = async () => {
  await api.post("/benefit-plans", {
    plan_name: plan_name.value,
    annual_limit: annual_limit.value,
  });

  resetForm();
  loadPlans();
};

const editPlan = (plan) => {
  isEdit.value = true;
  editId.value = plan.id;
  plan_name.value = plan.plan_name;
  annual_limit.value = plan.annual_limit;
};

const updatePlan = async () => {
  await api.put(`/benefit-plans/${editId.value}`, {
    plan_name: plan_name.value,
    annual_limit: annual_limit.value,
  });

  resetForm();
  loadPlans();
};

const deletePlan = async (id) => {
  if (!confirm("Yakin ingin menghapus plan ini?")) return;

  await api.delete(`/benefit-plans/${id}`);
  loadPlans();
};

const cancelEdit = () => {
  resetForm();
};

const resetForm = () => {
  plan_name.value = "";
  annual_limit.value = "";
  isEdit.value = false;
  editId.value = null;
};

onMounted(loadPlans);
</script>