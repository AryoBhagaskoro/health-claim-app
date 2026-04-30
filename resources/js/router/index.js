import { createRouter, createWebHistory } from "vue-router";

import AppLayout from "../layouts/AppLayout.vue";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Members from "../views/Members.vue";
import Plans from "../views/Plans.vue";
import Claims from "../views/Claims.vue";
import Reports from "../views/Reports.vue";

const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login
  },

  {
    path: "/",
    redirect: "/dashboard"
  },

  {
    path: "/",
    component: AppLayout,
    children: [
      { path: "dashboard", name: "Dashboard", component: Dashboard },
      { path: "members", name: "Members", component: Members },
      { path: "plans", name: "Plans", component: Plans },
      { path: "claims", name: "Claims", component: Claims },
      { path: "reports", name: "Reports", component: Reports },
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;