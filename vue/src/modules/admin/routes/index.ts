const adminRoutes = [
  {
    path: "/",
    name: "admin-dashboard",
    component: () => import("../pages/Dashboard.vue"),
  },

  {
    path: "/attendance",
    name: "attendance",
    component: () => import("../pages/Attendance.vue"),
  },

  {
    path: "/camera-video",
    name: "camera-video",
    component: () => import("../pages/CameraVideo.vue"),
  },
];

export default adminRoutes;
