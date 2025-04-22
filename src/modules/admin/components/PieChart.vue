<template>
  <div>
    <apexchart
      type="pie"
      :options="chartOptions"
      :series="series"
      height="350"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";

const series = ref([44, 55, 13, 43, 22]);

const chartOptions = ref({
  labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
  responsive: [
    {
      breakpoint: 480,
      options: {
        chart: {
          width: 320,
        },
        legend: {
          position: "bottom",
        },
      },
    },
  ],
  tooltip: {
    y: {
      formatter: function (val) {
        return `$ ${val} thousands`;
      },
    },
  },
});
</script>
