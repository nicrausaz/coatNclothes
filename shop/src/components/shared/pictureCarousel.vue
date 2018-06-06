<template>
  <div>
    <carousel :perPage="1" :loop="true" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5" v-if="hasPictures">
      <slide v-for="pic in pictures" :key="pic.altName">
        <img :src="pic.path">
      </slide>
    </carousel>
    <img src="/static/noImgAvailable.png" v-else>
  </div>
</template>

<script>
export default {
  props: ['pictures'],
  computed: {
    hasPictures () {
      return this.pictures.length > 0
    }
  }
}
</script>

<style scoped>
.VueCarousel-slide {
  position: relative;
  color: #fff;
  font-family: Arial;
  text-align: center;
  min-height: 400px;
  max-height: 600px;
}

.label {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
