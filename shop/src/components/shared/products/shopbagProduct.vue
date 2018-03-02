<template>
<div class="column is-one-third">
  <div class="card" @mouseover="hover = true" @mouseout="hover = false">
    <div class="card-image" @click="isImageModalActive = true">
      <figure class="image is-square">
        <!-- <img :src="getImage(infos.product_picture)" alt="alt" draggable="false"> -->
        <img src="static/noImgAvailable.png" draggable="false">
      </figure>
    </div>
    <transition name="fade">
      <div class="card-content notification" v-if="hover">
        <div class="media">
          <div class="media-content">
            test
          </div>
        </div>
      </div>
    </transition>
  </div>
  <b-modal :active.sync="isImageModalActive">
    <p class="image is-4by4">
      <!-- <img :src="getImage(infos.product_picture)"> -->
    </p>
  </b-modal>
</div>
</template>

<script>
export default {
  props: ['infos'],
  data () {
    return {
      hover: false,
      isImageModalActive: false
    }
  },
  methods: {
    getImage (picture) {
      return picture === '' ? 'static/noImgAvailable.png' : picture
    }
  }
}
</script>

<style scoped>
.card {
  height: 300px;
  width: 200px;
}
.card-image {
  cursor: pointer;
}
.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>