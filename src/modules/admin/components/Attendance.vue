<template>
  <div class="attendance">
    <v-data-table
      class="border rounded-lg"
      :headers="headers"
      :items-per-page="10"
      :page="1"
    >
      <!-- number of permitions -->
      <template v-slot:item.permissions="{ item }">
        <span>{{ item.permissions.length }}</span>
      </template>

      <!-- Actions -->
      <template v-slot:item.actions="{ item }">
        <div class="flex gap-x-2 items-center">
          <v-btn
            icon
            size="x-small"
            elevation="0"
            variant="tonal"
            color="secondary"
            rounded="lg"
          >
            <v-icon>mdi-eye</v-icon>
          </v-btn>

          <v-btn
            icon
            size="x-small"
            elevation="0"
            variant="tonal"
            color="green"
            rounded="lg"
          >
            <v-icon>mdi-pencil</v-icon>
          </v-btn>

          <v-btn
            icon
            size="x-small"
            elevation="0"
            variant="tonal"
            color="red"
            rounded="lg"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </div>
      </template>
    </v-data-table>
  </div>
</template>

<script setup>
import { computed } from "vue";
const headers = computed(() => [
  { key: "id", title: "ID " },
  { key: "display_name", title: "Name" },
  { key: "permissions", title: "No.Permitions" },
  { key: "actions", title: "Actions" },
]);
</script>
