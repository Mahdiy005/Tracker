import { useAuthStore } from "@/modules/auth/services/auth";

export const authMidlleware = (to: any, from: any, next: any) => {
  const authStore = useAuthStore();
  const publicPages = ["/login"];

  if (authStore?.user?.token) {
    if (publicPages.includes(to.path)) {
      return next("/");
    }

    return next();
  }

  if (to.meta?.isAuthenticated) {
    return next("/login");
  }

  return next();
};
