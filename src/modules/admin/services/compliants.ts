import { ref } from "vue";
import { api } from "@/helpers/axios";
import { toast } from "vue3-toastify";

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
      toast.success(`Compliants has been changed to ${status}`, {
        autoClose: 3000,
      });
    } catch (error) {
      console.log(error);
      isLoading.value = false;
      toast.error("Faild to update compliats", {
        autoClose: 3000,
      });
    }
  };

  return {
    replyCompliant,
    isLoading,
  };
};
