<template>
  <div class="profile">
    <div class="image">
      <img
        src="../../../assets/images/profile-banner.webp"
        alt="profile-image"
        height="30"
        class="relative w-full h-[9rem] object-cover"
      />

      <div class="flex gap-x-3 items-end relative bottom-[3rem] left-5">
        <div class="rounded-full border-6 border-light dark:border-dark">
          <img
            src="../../../assets/images/profile-image.png"
            width="100"
            height="100"
            class="rounded-full"
            alt="profile-image"
          />
        </div>

        <v-skeleton-loader
          v-if="!userData.name"
          type="list-item-two-line"
          class="w-1/4"
        ></v-skeleton-loader>

        <div v-if="userData" class="user-email-name">
          <div>
            <h2 class="font-bold text-xl dark:text-white">
              {{ userData?.name }}
            </h2>
            <span class="font-thin dark:text-white">{{ userData?.email }}</span>
          </div>
        </div>
      </div>
    </div>

    <ProfileDetails
      :attendance="userData"
      :loader="isLoading"
      @subUpdate="fetchUserData"
    />
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import ProfileDetails from "../components/ProfileDetails.vue";
import { useUser } from "../services/profile";
import { useRoute } from "vue-router";

const route = useRoute();
const { getUser, isLoading } = useUser();
const userData = ref({});

const fetchUserData = async () => {
  userData.value = await getUser(route.params.id);
};

onMounted(() => {
  fetchUserData();
});
</script>

<style scoped>
.v-skeleton-loader {
  top: 10px;
  background-color: var(--color-light);
}
</style>
