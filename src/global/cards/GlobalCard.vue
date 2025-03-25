<template>
  <div class="global-card rounded-lg bg-[#fff] dark:bg-custom-dark">
    <div class="card-header px-5 py-4">
      <div class="title">
        <h4 class="dark:text-white font-bold text-xl ps-4">
          <slot name="card-title"></slot>
        </h4>
      </div>
    </div>

    <hr class="text-[#00000014] dark:text-[#ffffff18]" />

    <div class="card-body px-5 py-4">
      <slot name="catr-body"></slot>
    </div>
  </div>
</template>

<style scoped>
.title {
  position: relative;
  &::before {
    content: "";
    position: absolute;
    width: 4px;
    height: 100%;
    background: linear-gradient(
      to bottom,
      #23b7e580 0%,
      #23b7e580 50%,
      #845adf80 50%,
      #845adf80 100%
    );
    border-radius: 10px;
  }
}
</style>
