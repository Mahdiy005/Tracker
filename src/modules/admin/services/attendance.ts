import { ref } from "vue";
import { api } from "@/helpers/axios";

export const useAttendance = () => {
  const attendance = ref([]);
  const isLoading = ref(false);
  const currentPage = ref(1);
  const lastPage = ref(1);
  const date = ref("");
  const status = ref("");

  const getAttendance = async () => {
    try {
      isLoading.value = true;

      const params = {
        page: currentPage.value,
        ...(date.value ? { date: date.value } : {}),
        ...(status.value ? { status: status.value } : {}),
      };

      const response: any = await api.get("/admin/attendance", { params });

      if (response.status === 200) {
        const data = response.data.data;
        attendance.value = data.paginate_data ?? data;

        lastPage.value = data?.paginate_links?.last_page ?? 1;
      } else {
        lastPage.value = 1;
      }

      isLoading.value = false;
    } catch (error) {
      console.error("Error fetching attendance:", error);
      isLoading.value = false;
    }
  };

  return {
    getAttendance,
    isLoading,
    currentPage,
    attendance,
    lastPage,
    date,
    status,
  };
};
