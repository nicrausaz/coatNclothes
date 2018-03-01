<template>
<div class="column is-one-third">
  <div class="card">
    <div class="card-image" @click="isImageModalActive = true">
      <figure class="image is-square">
        <!-- <img :src="getImage(infos.product_picture)" alt="alt" draggable="false"> -->
        <img src="static/noImgAvailable.png" draggable="false">
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-content">
          <p class="title is-4">test</p>
        </div>
      </div>
    </div>
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