import { ref } from "vue";
import { api } from "@/helpers/axios";

export const useCompliants = () => {
  const isLoading = ref(false);

  const replyCompliant = async (
    id: number,
    reply: string,
    status: "approved" | "rejected"
  ) => {
    try {
      isLoading.value = true;
      const response: any = await api.post(`/admin/compliant-reply/${id}`, {
        reply,
        status,
      });
      isLoading.value = false;
    } catch (error) {
      console.log(error);
      isLoading.value = false;
    }
  };

  return {
    replyCompliant,
    isLoading,
  };
};
