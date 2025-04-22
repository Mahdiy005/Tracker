<template>
  <div
    class="employee__insights grid grid-cols-1 lg:grid-cols-2 md:grid-cols-1 gap-3"
  >
    <GlobalCard>
      <template #card-title>Bar chart</template>
      <template #catr-body><BarChart /></template>
    </GlobalCard>

    <GlobalCard>
      <template #card-title>Pie chart</template>
      <template #catr-body><PieChart /></template>
    </GlobalCard>

    <GlobalCard>
      <template #card-title>Line Chart</template>
      <template #catr-body><LineChart /></template>
    </GlobalCard>

    <GlobalCard>
      <template #card-title>Area Chart</template>
      <template #catr-body><AreaChart /></template>
    </GlobalCard>
  </div>
</template>

<script setup lang="ts">
import BarChart from "./BarChart.vue";
import PieChart from "./PieChart.vue";
import LineChart from "./LineChart.vue";
import AreaChart from "./AreaChart.vue";
import GlobalCard from "@/global/cards/GlobalCard.vue";
</script>
