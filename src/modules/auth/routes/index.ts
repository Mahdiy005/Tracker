const authRoutes = [
  {
    path: "/login",
    name: "login",
    component: () => import("../pages/Login.vue"),
  },
];

export default authRoutes;
