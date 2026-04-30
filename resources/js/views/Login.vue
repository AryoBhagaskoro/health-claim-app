<template>
  <div class="h-screen w-full flex flex-col font-sans overflow-hidden">
    <div class="h-20 flex items-center justify-between px-10 bg-[#003d8d]/70 backdrop-blur-md text-white shadow-lg z-20">
      <div class="flex items-center">
        <img :src="logo" class="h-12 object-contain" />
      </div>
      <div 
        @click="showLogin = true"
        class="flex items-center gap-2 cursor-pointer hover:text-gray-300 transition group"
      >
        <svg width="18" height="18" fill="none" stroke="currentColor">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" x2="3" y1="12" y2="12"/>
        </svg>
        <span class="text-sm font-medium">Login</span>
      </div>
    </div>
    <div 
      class="flex-1 bg-cover bg-center relative"
      :style="{ backgroundImage: `url(${bg})` }"
    >
      <div class="absolute inset-0 bg-blue-900/30"></div>
    </div>
    <div 
      v-if="showLogin"
      class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-30"
    >
      <div class="bg-white rounded-xl shadow-2xl w-[450px] p-10 relative animate-scale">
        <button 
          @click="showLogin = false"
          class="absolute top-3 right-4 text-gray-400 hover:text-black"
        >
          ✕
        </button>
        <div class="mb-8 flex justify-center">
          <img :src="logo" class="h-24 object-contain" />
        </div>
        <div class="space-y-4">
          <input 
            v-model="email"
            type="email"
            placeholder="Email"
            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600"
          />
          <input 
            v-model="password"
            type="password"
            placeholder="Password"
            class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-600"
          />
          <button 
            @click="login"
            class="w-full bg-[#1e56a0] hover:bg-[#16427d] text-white py-3 rounded-lg font-semibold"
          >
            Login
          </button>
        </div>
        <p v-if="error" class="text-red-500 mt-4 text-sm">
          {{ error }}
        </p>
      </div>
    </div>
    <div class="h-16 flex items-center px-10 bg-[#003d8d]/70 backdrop-blur-md text-white text-sm z-20">
      <span>Contact Person : 085960236680</span>
    </div>
  </div>
</template>

<script setup>
    import logo from "../assets/logo.jpg";
    import bg from "../assets/bg.jpg";
    import { ref } from "vue";
    import { useRouter } from "vue-router";
    import api from "../services/api";

    const email = ref("");
    const password = ref("");
    const error = ref("");
    const showLogin = ref(false); 

    const router = useRouter();

    const login = async () => {
      error.value = "";

      try {
        const res = await api.post("/login", {
          email: email.value,
          password: password.value,
        });

        const token = res.data.access_token || res.data.token;
       localStorage.setItem("user", JSON.stringify(res.data.user));

       localStorage.setItem("token", token);

       router.push("/dashboard");

      } catch (err) {
        error.value = "Login gagal, periksa email & password";
      }
    };
</script>