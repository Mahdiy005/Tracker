<template>
  <div
    class="employee_card bg-[#fff] dark:bg-custom-dark rounded-lg p-lg relative"
  >
    <div class="image flex justify-center">
      <slot name="user_image"></slot>
    </div>

    <div class="text-center">
      <h3 class="font-bold text-lg pt-3 dark:text-white">{{ user_name }}</h3>
      <span class="text-sm text-gray-400 dark:text-white">{{ user_role }}</span>
      <span
        class="text-sm block text-gray-400 dark:text-white font-bold mt-2"
        >{{ date }}</span
      >
    </div>

    <div class="show_profile_btn">
      <v-btn
        :ripple="false"
        class="text-capitalize rounded-lg w-full mt-5"
        variant="flat"
        size="default"
        color="primary"
        @click="$router.push(`/profile`)"
      >
        Show Profile
      </v-btn>
    </div>

    <div
      class="flex justify-between items-center w-full pr-4 left-2 absolute top-2"
    >
      <v-chip color="secondary" size="small">
        {{ position.slice(0, 10) }}...
      </v-chip>

      <v-chip :color="status === 'attend' ? 'primary' : 'red'" size="small">
        {{ status }}
      </v-chip>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  user_name: {
    type: String,
    reqired: true,
  },

  user_role: {
    type: String,
    reqired: true,
  },

  position: {
    type: String,
    reqired: true,
  },

  status: {
    type: String,
    reqired: true,
  },

  date: {
    type: String,
    reqired: true,
  },
});
</script>
