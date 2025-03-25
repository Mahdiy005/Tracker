<template>
  <RouterView />
</template>

<script setup>
import { watch } from "vue";
import { RouterView, useRoute } from "vue-router";

const route = useRoute();

watch(
  () => route.meta,
  (meta) => {
    if (meta?.title) document.title = meta.title;

    if (meta?.description) {
      let descriptionTag = document.querySelector("meta[name='description']");
      if (descriptionTag) {
        descriptionTag.setAttribute("content", meta.description);
      } else {
        descriptionTag = document.createElement("meta");
        descriptionTag.name = "description";
        descriptionTag.content = meta.description;
        document.head.appendChild(descriptionTag);
      }
    }
  },
  { immediate: true }
);
</script>
