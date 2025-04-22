const adminRoutes = [
  {
    path: "/",
    name: "admin-dashboard",
    component: () => import("../pages/Dashboard.vue"),
    meta: {
      isAuthenticated: true,
      title: "Home | Tracker",
      description: "Welcome to my homepage",
    },
  },

  {
    path: "/attendance",
    name: "attendance",
    component: () => import("../pages/Attendance.vue"),
    meta: {
      isAuthenticated: true,
      title: "Attendance | Tracker",
      description: "Welcome to attendancepage",
    },
  },

  {
    path: "/camera-video",
    name: "camera-video",
    component: () => import("../pages/CameraVideo.vue"),
    meta: {
      isAuthenticated: true,
      title: "Videos | Tracker",
      description: "Welcome to my videospage",
    },
  },

  {
    path: "/attendance/profile/:id",
    name: "profile",
    component: () => import("../pages/Profile.vue"),
    meta: {
      isAuthenticated: true,
      title: "Profile | Tracker",
      description: "Welcome to my profilepage",
    },
  },

  {
    path: "/users",
    name: "users",
    component: () => import("../pages/Users.vue"),
    meta: {
      isAuthenticated: true,
      title: "Users | Tracker",
      description: "Welcome to my userspage",
    },
  },

  {
    path: "/violations",
    name: "violations",
    component: () => import("../pages/Violations.vue"),
    meta: {
      isAuthenticated: true,
      title: "Violations | Tracker",
      description: "Welcome to my violationspage",
    },
  },
];

export default adminRoutes;
