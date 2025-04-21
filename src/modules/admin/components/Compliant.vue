<template>
  <div class="compliant">
    <div
      class="image text-center mt-10 mb-10"
      v-if="!loader && !attend?.complaints.length"
    >
      <div class="flex justify-center">
        <Icon
          icon="stash:search-results-light"
          width="200"
          height="200"
          color="#111c43"
        />
      </div>
      <span>No Compliants</span>
    </div>

    <div
      v-for="(item, index) in localAttend?.complaints"
      :key="item"
      :class="{
        'border-[2px] border-secondry': index === 0,
        border: index !== 0,
      }"
      class="compliant-card mb-5 rounded-lg p-5 bg-[#dddddd1c] grid grid-cols-1 lg:grid-cols-3 md:grid-cols-1"
    >
      <div class="flex flex-col justify-between">
        <h1 class="text-2xl font-bold text-secondry">{{ item?.subject }}</h1>
        <div class="flex items-center gap-x-2">
          <span class="text-sm text-[#676767] dark:text-white">30/12/2025</span>
          <span
            class="dark:text-white px-2 py-1 text-xs font-medium rounded-full"
            :class="{
              'bg-blue-100 text-blue-800': item?.status === 'pending',
              'bg-red-100 text-red-800': item?.status === 'rejected',
              'bg-green-100 text-green-800': item?.status === 'approved',
            }"
            >{{ item?.status }}</span
          >
        </div>
      </div>

      <p class="mb-0 text-sm text-[#676767] dark:text-white">
        {{ item?.message }}
      </p>

      <div class="actions flex gap-3 justify-end">
        <v-btn
          :ripple="false"
          :disabled="item?.status === 'approved' || item?.status === 'rejected'"
          type="submit"
          class="text-capitalize rounded-lg mt-5"
          variant="flat"
          size="default"
          color="primary"
          @click="openDialog(index)"
        >
          Reply
        </v-btn>

        <dialog
          class="dialog p-4 m-auto w-1/2 rounded-[10px]"
          :ref="(el) => (dialog[index] = el)"
        >
          <div class="content">
            <div class="flex justify-between items-center">
              <h1 class="font-bold text-xl">
                Compliant Reply ({{ item?.subject }})
              </h1>
              <div
                class="close-icon flex justify-end cursor-pointer"
                @click="closeDialog(index)"
              >
                <Icon
                  icon="line-md:close-small"
                  class="w-8 h-8 hover:bg-[#ddd] rounded-full p-1"
                ></Icon>
              </div>
            </div>

            <Form
              @submit="
                submitReply(item?.id, event?.message, event?.status, index)
              "
              v-slot="{ meta }"
              class="mt-4"
            >
              <!-- reply message -->
              <BaseInput
                lable="Message"
                v-model="event.reply"
                name="copiliant_message"
                rules="required"
                type="text"
                class="mb-3"
              />

              <!-- status -->
              <BaseInput
                lable="Status"
                v-model="event.status"
                name="compliant_status"
                rules="required"
                type="select"
                :options="['rejected', 'approved']"
              />

              <v-btn
                :ripple="false"
                :disabled="!meta.valid"
                :loading="isLoading"
                type="submit"
                class="text-capitalize rounded-lg w-full mt-5"
                variant="flat"
                size="large"
                color="#845adf"
              >
                Confirm
              </v-btn>
            </Form>
          </div>
        </dialog>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useCompliants } from "../services/compliants";
import { useUser } from "../services/profile";
import { Form } from "vee-validate";
import BaseInput from "@/global/BaseInput.vue";
import { useRoute } from "vue-router";

const emit = defineEmits(["update"]);
const props = defineProps({
  attend: {
    type: Object,
    required: true,
  },
  loader: {
    type: Boolean,
    required: true,
  },
});

const localAttend = ref(props.attend);
const dialog = ref([]);
const route = useRoute();
const { replyCompliant, isLoading } = useCompliants();
const { getUser } = useUser();
const event = ref({
  reply: "",
  status: "",
});

const openDialog = (index) => {
  dialog.value[index]?.showModal();
};

const closeDialog = (index) => {
  dialog.value[index]?.close();
};

const submitReply = async (item, reply, messaeg, index) => {
  await replyCompliant(item, reply, messaeg);
  localAttend.value = await getUser(route.params.id);
  closeDialog(index);
};
</script>

<style scoped>
.dialog {
  &::backdrop {
    background-color: #0a0a0a67;
    backdrop-filter: blur(2px);
  }
}
</style>
