<template>
  <div class="attendance">
    <div class="overflow-x-auto p-0">
      <table
        class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden"
      >
        <thead
          class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white"
        >
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Phone</th>
          </tr>
        </thead>
        <tbody
          class="text-gray-600 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700"
        >
          <tr v-if="loader">
            <td colspan="100%">
              <div class="loader p-4 flex justify-center items-center">
                <Icon
                  icon="svg-spinners:eclipse-half"
                  width="60"
                  heigth="60"
                ></Icon>
              </div>
            </td>
          </tr>

          <tr
            v-else
            class="hover:bg-gray-50 dark:hover:bg-gray-600 transition cursor-pointer"
            v-for="(employee, index) in attend?.attendances"
            :key="index"
          >
            <td class="px-6 py-4">{{ index + 1 }}</td>
            <td class="px-6 py-4">{{ employee?.user?.name }}</td>
            <td class="px-6 py-4">{{ employee?.user?.email }}</td>
            <td class="px-6 py-4">
              <span
                class="px-2 py-1 text-xs font-medium rounded-full"
                :class="{
                  'bg-red-100 text-red-800': employee?.status === 'absent',
                  'bg-green-100 text-green-800': employee?.status === 'attend',
                }"
                >{{ employee?.status }}</span
              >
            </td>
            <td class="px-6 py-4 space-x-2">{{ employee?.date }}</td>
            <td class="px-6 py-4 space-x-2 hover:underline">
              <a :href="`tel:${employee?.user?.phone}`">{{
                employee?.user?.phone
              }}</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
  attend: any;
  loader: any;
}>();

const headers = computed(() => [
  { key: "id", title: "ID " },
  { key: "display_name", title: "Name" },
  { key: "permissions", title: "No.Permitions" },
  { key: "actions", title: "Actions" },
]);
</script>
