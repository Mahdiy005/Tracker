import dashboard from "@/layouts/dashboard.vue";
import adminRoutes from "@/modules/admin/routes";
import authRoutes from "@/modules/auth/routes";

export default [
  {
    path: "/",
    name: "dashboard-layout",
    component: dashboard,
    children: [...adminRoutes],
  },

  ...authRoutes,
];
