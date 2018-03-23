<template>
  <carousel :perPage="1" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5">
    <slide v-for="pic in pictures" :key="pic.altName">
      <img :src="pic.path">
    </slide>
  </carousel>
</template>

<script>
export default {
  props: ['pictures']
}
</script>

<style scoped>
.VueCarousel-slide {
  position: relative;
  color: #fff;
  font-family: Arial;
  font-size: 24px;
  text-align: center;
  min-height: 400px;
}

.label {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
