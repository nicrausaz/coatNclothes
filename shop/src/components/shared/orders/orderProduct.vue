<template>
  <article class="media column is-6">
    <figure class="media-left image is-64x64" style="padding-bottom: 5px;">
      <img :src="getPicture(product.products_pictures)" :alt="getAltName(product.products_pictures)">
    </figure>
    <div class="media-content">
    <div class="content">
      <p>
        <strong>{{product.products_name}}</strong> <small>{{product.products_price}} CHF</small>
        <br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
      </p>
    </div>
  </div>
    <!--
    <div class="media-content">
      <div class="content">
        <p>
          {{product}}
          <strong></strong>
          <small></small>
        </p>
      </div>
    </div> -->
  </article>
</template>

<script>
export default {
  props: ['data'],
  data () {
    return {
      product: [],
      loaded: false
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.data.fk_products_id
    })
    .then((response) => {
      this.product = response.data
      this.loaded = true
    })
  },
  methods: {
    getPicture (pictures) {
      if (this.loaded) {
        return pictures.length === 0 ? 'static/noImgAvailable.png' : pictures[0].path
      }
    },
    getAltName (pictures) {
      if (this.loaded) {
        return pictures.length === 0 ? 'static/noImgAvailable.png' : pictures[0].altName
      }
    }
  }
}
</script>

<style scoped>
.media {
  border: none;
  margin: 0px;
  padding-left: 20px;
  border: 2px solid black;
}
</style>
