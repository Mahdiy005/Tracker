import { ref } from "vue";
import { api } from "@/helpers/axios";
import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import Cookies from "js-cookie";
import { type User } from "@/types/interfaces";

export const useAuthStore = defineStore("useAuthStore", () => {
  const user = ref(
    Cookies.get("user") ? JSON.parse(Cookies.get("user")!) : null
  );

  const isLoading = ref(false);
  const router = useRouter();

  // login fuction
  const login = async (credintials: User) => {
    try {
      isLoading.value = true;
      const response = await api.post("/auth/login", credintials);
      user.value = response.data.data;

      if (user.value?.role === "admin") {
        Cookies.set("user", JSON.stringify(user.value), {
          expires: 7,
          secure: true,
        });
        isLoading.value = false;
        await router.push("/");
        toast.success("Login Successfully", { autoClose: 3000 });
      } else {
        isLoading.value = false;
        toast.error("You are not allowed to access dashboard", {
          autoClose: 3000,
        });
      }
    } catch (error) {
      isLoading.value = false;
      toast.error("Error in email or password!", { autoClose: 3000 });
    }
  };

  const logout = async () => {
    try {
      // const response = await api.get("/user/logout");

      user.value = null;
      Cookies.remove("user");
      window.location.reload();
    } catch (error) {
      console.log(error);
    }
  };

  return {
    isLoading,
    login,
    logout,
    user,
  };
});
