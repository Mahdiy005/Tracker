<template>
  <div class="employees p-xl">
    <BreadCrumb :isDashboard="false">
      <template #page-title> Attendance </template>
      <template #first-page> Dashboard </template>
      <template #second-page> Attendance </template>
    </BreadCrumb>

    <div class="filters flex justify-between items-center mt-2">
      <div class="flex gap-2 items-center">
        <BaseInput
          v-model="date"
          name="date_filter"
          type="date"
          :isLable="false"
        />

        <BaseInput
          v-model="status"
          name="status_filter"
          type="select"
          :isLable="false"
          :options="['absent', 'attend']"
        />

        <BaseInput
          v-model="position"
          name="position_filter"
          type="text"
          :isLable="false"
          lable="Enter position"
        />
      </div>

      <div
        class="cursor-pointer hover:bg-[#ddd] hover:dark:bg-[#dddddd18] p-[2px] rounded-lg"
      >
        <Icon
          icon="mdi-light:grid"
          width="30"
          height="30"
          class="dark:text-white"
        ></Icon>
      </div>
    </div>

    <div
      class="image text-center mt-10 mb-10"
      v-if="!isLoading && !attendance.length"
    >
      <div class="flex justify-center">
        <Icon
          icon="stash:search-results-light"
          width="200"
          height="200"
          color="#111c43"
        />
      </div>
      <span>No results for this search !</span>
    </div>

    <SkeletonLoader :loading="isLoading" />

    <div
      class="content mt-5 grid gap-5 grid-cols-1 lg:grid-cols-4 md:grid-cols-2"
      v-if="!isLoading"
    >
      <employeeCard
        v-for="user in attendance"
        :key="user.user.id"
        :user_name="user?.user?.name"
        :user_role="user?.user?.email"
        :position="user?.user?.position"
        :status="user?.status"
        :date="user?.date"
        :id="user?.user?.id"
      >
        <template #user_image>
          <img
            src="@/assets/images/user.jpg"
            width="70"
            height="70"
            class="rounded-full"
            alt=""
          />
        </template>
      </employeeCard>
    </div>

    <div class="pagination w-full items-center justify-center mt-7">
      <v-pagination
        v-model="currentPage"
        :length="lastPage"
        :total-visible="5"
        :disabled="lastPage == 1"
      ></v-pagination>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, watchEffect } from "vue";
import BreadCrumb from "@/global/BreadCrumb.vue";
import BaseInput from "@/global/BaseInput.vue";
import employeeCard from "@/global/cards/employeeCard.vue";
import SkeletonLoader from "@/global/SkeletonLoader.vue";
import { useAttendance } from "../services/attendance";

const position = ref("");
const {
  attendance,
  getAttendance,
  isLoading,
  currentPage,
  lastPage,
  date,
  status,
} = useAttendance();

watchEffect(getAttendance);

watch([status, date], () => {
  currentPage.value = 1;
});
</script>
