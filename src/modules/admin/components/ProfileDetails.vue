<template>
  <div class="profile-details p-xl">
    <div class="tabs flex gap-x-5 items-center cursor-pointer border-b pb-5">
      <span
        class=""
        v-for="(_, tab) in tabs"
        :key="tab"
        :class="{
          'active  text-secondry': currentTab === tab,
          'text-[#676767] dark:text-white hover:text-black hover:dark:text-[#fff]':
            currentTab !== tab,
        }"
        @click="currentTab = tab"
        >{{ tab }}</span
      >
    </div>

    <component
      :attend="attendance"
      :loader="loader"
      :is="tabs[currentTab]"
      class="mt-8"
      @update="update"
    ></component>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Compliant from "./Compliant.vue";
import Settings from "./Settings.vue";
import Attendance from "./Attendance.vue";
import Insights from "./Insights.vue";

const emit = defineEmits<{ (e: "subUpdate"): void }>();

const update = () => {
  emit("subUpdate");
};

const currentTab: any = ref("Attendance");
const tabs: any = { Attendance, Compliant, Insights, Settings };

const { attendance, loader } = defineProps<{
  attendance: any;
  loader: any;
}>();
</script>

<style scoped>
.tabs {
  .active {
    position: relative;
    &::before {
      content: "";
      width: 100%;
      height: 2px;
      position: absolute;
      bottom: -1.3rem;
      background-color: var(--color-secondry);
    }
  }

  span:not(.active) {
    &:hover {
      &::after {
        display: block;
      }
    }
    position: relative;
    &::after {
      content: "";
      width: 100%;
      height: 2px;
      position: absolute;
      bottom: -1.3rem;
      background-color: #b8b8b8;
      display: none;
    }
  }
}
</style>
