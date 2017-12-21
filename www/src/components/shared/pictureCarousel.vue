<template>
  <carousel :navigationEnabled="true">
    <slide v-for="i in 10" :key="i">
      Slide {{i}} Content
    </slide>
  </carousel>
</template>

<script>
export default {

}
</script>

<style scoped>
.VueCarousel-slide {
  position: relative;
  background: #42b983;
  color: #fff;
  font-family: Arial;
  font-size: 24px;
  text-align: center;
  min-height: 100px;
}

.label {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
