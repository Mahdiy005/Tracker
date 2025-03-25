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

        <div class="user-email-name">
          <h2 class="font-bold text-xl dark:text-white">Omradel Bakry</h2>
          <span class="font-thin dark:text-white"
            >omradelbakry375@gmail.com</span
          >
        </div>
      </div>
    </div>

    <ProfileDetails />
  </div>
</template>

<script setup>
import ProfileDetails from "../components/ProfileDetails.vue";
</script>

<style scoped></style>
