<template>
  <div>
    <h1>D'autres articles qui pourraient vous interreser !</h1>

    <carousel :perPage="6" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5">
    <slide v-for="i in 10" :key="i">
      <figure class="image is-128x128">
        <img src="http://dl.coatandclothes.shop:8090/Imports/F/lewisskinnyjeanstaillehaute4.jpg" alt="">
      </figure>
    </slide>
  </carousel>
  </div>
</template>

<script>
export default {
  data () {
    return {
      suggestedArticles: []
    }
  }
}
</script>

<style scoped>
</style>
