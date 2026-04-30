<template>
  <div class="p-6">

    <h2 class="text-2xl font-bold mb-6">Members</h2>

    <div class="flex gap-2 mb-4">
      <input v-model="name" placeholder="Name" class="border p-2 rounded w-1/3" />
      <input v-model="policy_number" placeholder="Policy Number" class="border p-2 rounded w-1/3" />
      <input v-model="benefit_plan_id" placeholder="Plan ID" class="border p-2 rounded w-1/3" />

      <button 
        v-if="user?.role !== 'viewer'"
        @click="saveMember"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
      >
        {{ editingId ? "Update" : "Add" }}
      </button>

      <button 
        v-if="editingId && user?.role !== 'viewer'"
        @click="cancelEdit"
        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded"
      >
        Cancel
      </button>
    </div>

    <p v-if="error" class="text-red-500 mb-3">
      {{ error }}
    </p>

    <table class="w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
  <tr>
    <th class="p-2 text-left">ID</th>
    <th class="p-2 text-left">Name</th>
    <th class="p-2 text-left">Policy</th>
    <th class="p-2 text-left">Plan</th>
    <th class="p-2 text-left">Action</th>
  </tr>
</thead>

<tbody>
  <tr v-for="member in members" :key="member.id" class="border-t">
    <td class="p-2">{{ member.id }}</td>
    <td class="p-2">{{ member.name }}</td>
    <td class="p-2">{{ member.policy_number }}</td>
    <td class="p-2">{{ member.benefit_plan?.plan_name || "-" }}</td>
    <td class="p-2 space-x-2">
      <button 
        v-if="user?.role !== 'viewer'"
        @click="editMember(member)"
        class="bg-yellow-400 text-white px-2 py-1 rounded"
      >
        Edit
      </button>

     <button 
    v-if="user?.role !== 'viewer'"
    @click="deleteMember(member.id)" 
    class="bg-red-500 text-white px-2 py-1 rounded"
  >
    Delete
  </button>
    </td>
  </tr>
</tbody>
    </table>

    <div 
      v-if="showToast"
      class="fixed top-5 right-5 bg-green-500/80 text-white px-6 py-3 rounded shadow-lg transition"
    >
      ✔ Berhasil disimpan
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";


const members = ref([]);
const plans = ref([]);

const name = ref("");
const policy_number = ref("");
const benefit_plan_id = ref("");
const error = ref("");

const showToast = ref(false);

const editingId = ref(null);

const loadMembers = async () => {
  try {
    const res = await api.get("/members");
    members.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

const loadPlans = async () => {
  try {
    const res = await api.get("/benefit-plans");
    plans.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

const saveMember = async () => {
  error.value = "";

  if (!name.value || !policy_number.value || !benefit_plan_id.value) {
    error.value = "Semua field wajib diisi";
    return;
  }

  try {
    if (editingId.value) {
      
      await api.put(`/members/${editingId.value}`, {
        name: name.value,
        policy_number: policy_number.value,
        benefit_plan_id: benefit_plan_id.value,
      });
    } else {
      // CREATE
      await api.post("/members", {
        name: name.value,
        policy_number: policy_number.value,
        benefit_plan_id: benefit_plan_id.value,
      });
    }

    await loadMembers();

    cancelEdit();

    showToast.value = true;
    setTimeout(() => (showToast.value = false), 2000);

  } catch (err) {
    error.value = err.response?.data?.message || "Gagal menyimpan data";
  }
};

const editMember = (m) => {
  name.value = m.name;
  policy_number.value = m.policy_number;
  benefit_plan_id.value = m.benefit_plan_id;
  editingId.value = m.id;
};

const deleteMember = async (id) => {
  if (!confirm("Yakin ingin menghapus member ini?")) return;

  await api.delete(`/members/${id}`);
  await loadMembers();
  
};

const cancelEdit = () => {
  name.value = "";
  policy_number.value = "";
  benefit_plan_id.value = "";
  editingId.value = null;
};

onMounted(() => {
  loadMembers();
  loadPlans();
});
</script>