import { ref } from "vue";
import { api } from "@/helpers/axios";

export const useUser = () => {
  const user = ref();
  const isLoading = ref(false);

  const getUser = async (id: number) => {
    try {
      isLoading.value = true;
      const response: any = await api.get(`/admin/users/${id}`);
      user.value = response.data.data;
      isLoading.value = false;
      return user.value;
    } catch (error) {
      console.log(error);
      isLoading.value = false;
    }
  };

  return {
    getUser,
    isLoading,
  };
};
