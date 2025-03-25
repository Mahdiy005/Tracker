<template>
  <div class="settings w-3/4">
    <Form @submit="onSubmit" v-slot="{ meta }" class="mt-5">
      <div class="flex gap-3 items-center w-fu">
        <BaseInput
          lable="First Name"
          v-model="event.first_name"
          name="first_name"
          rules="required"
          type="text"
          class="mb-3 w-full"
        />

        <BaseInput
          lable="Last Name"
          v-model="event.last_name"
          name="last_name"
          rules="required"
          type="text"
          class="mb-3 w-full"
        />
      </div>

      <BaseInput
        lable="Current Password"
        v-model="event.current_password"
        name="current_password"
        rules="required"
        type="password"
        class="mb-3 w-full"
      />

      <BaseInput
        lable="New Password"
        v-model="event.new_password"
        name="new_password"
        rules="required"
        type="password"
        class="mb-3 w-full"
      />

      <v-btn
        :ripple="false"
        :disabled="!meta.valid"
        type="submit"
        class="text-capitalize rounded-lg w-full mt-5"
        variant="flat"
        size="large"
        color="#845adf"
      >
        Sigin in
      </v-btn>
    </Form>
  </div>
</template>

<script setup>
import BaseInput from "@/global/BaseInput.vue";
import { Form } from "vee-validate";
import { ref } from "vue";

const event = {
  first_name: "",
  last_name: "",
  current_password: "",
  new_password: "",
};

const onSubmit = (values) => {
  console.log("form submitted", values);
};
</script>
