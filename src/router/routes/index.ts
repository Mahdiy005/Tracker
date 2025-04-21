import dashboard from "@/layouts/dashboard.vue";
import adminRoutes from "@/modules/admin/routes";
import authRoutes from "@/modules/auth/routes";
import { h } from "vue";

export default [
  {
    path: "/",
    name: "dashboard-layout",
    component: dashboard,
    children: [...adminRoutes],
  },

  ...authRoutes,

  {
    path: "/:pathMatch(.*)*",
    name: "not found",
    component: h(
      "p",
      { style: "color: red; font-size:30px" },
      "404 Not founded page"
    ),
  },
];
