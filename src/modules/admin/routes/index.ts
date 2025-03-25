const adminRoutes = [
  {
    path: "/",
    name: "admin-dashboard",
    component: () => import("../pages/Dashboard.vue"),
    meta: {
      isAuthenticated: true,
    },
  },

  {
    path: "/attendance",
    name: "attendance",
    component: () => import("../pages/Attendance.vue"),
    meta: {
      isAuthenticated: true,
    },
  },

  {
    path: "/camera-video",
    name: "camera-video",
    component: () => import("../pages/CameraVideo.vue"),
    meta: {
      isAuthenticated: true,
    },
  },
];

export default adminRoutes;
