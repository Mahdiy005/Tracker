<template>
  <div class="compliant">
    <div
      v-for="(item, index) in 4"
      :key="item"
      :class="{
        'border-[2px] border-secondry': index === 0,
        border: index !== 0,
      }"
      class="compliant-card mb-5 rounded-lg p-5 bg-[#dddddd1c] grid grid-cols-1 lg:grid-cols-3 md:grid-cols-1"
    >
      <div class="flex flex-col justify-between">
        <h1 class="text-2xl font-bold text-secondry">Basic Compliant</h1>
        <span class="text-sm text-[#676767] dark:text-white">30/12/2025</span>
      </div>

      <p class="mb-0 text-sm text-[#676767] dark:text-white">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta
        similique dolorum suscipit, fugit nam id et ipsum placeat cum,
        cupiditate repudiandae facere eveniet eaque nobis nihil minima labore
        enim temporibus?
      </p>

      <div class="actions flex gap-3 justify-end">
        <v-btn
          :ripple="false"
          type="submit"
          class="text-capitalize rounded-lg mt-5"
          variant="flat"
          size="small"
          color="primary"
        >
          Abrove
        </v-btn>

        <v-btn
          :ripple="false"
          type="submit"
          class="text-capitalize rounded-lg mt-5"
          variant="flat"
          size="small"
          color="red"
        >
          Discard
        </v-btn>
      </div>
    </div>

    <v-pagination
      :length="5"
      :total-visible="5"
      v-model="currentPage"
    ></v-pagination>
  </div>
</template>

<script setup>
import { ref } from "vue";

const currentPage = ref(1);
</script>
