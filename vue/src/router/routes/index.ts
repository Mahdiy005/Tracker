import dashboard from "@/layouts/dashboard.vue";
import adminRoutes from "@/modules/admin/routes";
import employeeRoutes from "@/modules/employee/routes";

export default [
  {
    path: "/",
    name: "dashboard-layout",
    component: dashboard,
    children: [...adminRoutes, ...employeeRoutes],
  },
];
