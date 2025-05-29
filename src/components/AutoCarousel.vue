<template>
  <div class="slider">
    <div class="slide-track">
      <div class="slide" v-for="(image, index) in 18" :key="index">
        <img :src="`/src/assets/images/clients/${image}.png`" height="100" width="250" alt="" />
      </div>
    </div>
  </div>
</template>
<script setup>
</script>
<style lang="scss" scoped>
@use '../style.scss' as style;
@mixin white-gradient {
  background: linear-gradient(to right, rgba(50, 70, 126, 1) 0%, rgba(217, 217, 217, 0) 100%);
}
$animationSpeed: 100s;
// Animation
@keyframes scroll {
  0% {
    transform: translateX(100px);
  }
  50% {
    transform: translateX(calc(-250px * 14))
  }
  100% {
    transform: translateX(100px);
  }
}
// Styling
.slider {
  background: rgba($color: rgb(50, 70, 126), $alpha: .3);
  opacity: 0.8;
  box-shadow: 0 10px 20px -5px rgba(0, 0, 0, .125);
  height: 100px;
  margin: auto;
  overflow: hidden;
  position: relative;
  width: 100%;
  &::before,
  &::after {
    @include white-gradient;
    content: "";
    height: 100px;
    position: absolute;
    width: 200px;
    z-index: 2;
  }
  &::after {
    right: 0;
    top: 0;
    transform: rotateZ(180deg);
  }
  &::before {
    left: 0;
    top: 0;
  }
  .slide-track {
    animation: scroll $animationSpeed linear infinite;
    display: flex;
    width: calc(250px * 14);
  }
  .slide {
    height: 100px;
    width: 250px;
  }
}
</style>