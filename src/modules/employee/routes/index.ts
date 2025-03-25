const employeeRoutes = [
  {
    path: "/employee",
    name: "employee-dashboard",
    component: () => import("../pages/Dashboard.vue"),
  },
];

export default employeeRoutes;
