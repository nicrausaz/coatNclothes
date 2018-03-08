<template>
<div class="column is-one-third">
  <div class="card" @mouseover="hover = true" @mouseout="hover = false">
    <button class="delete" @click="removeProductFromShopBag" style="margin: 5px;"></button>
    <div class="card-image" @click="$router.push('/product/' + infos.products_id)">
      <figure class="image is-square">
        <!-- <img :src="getImage(infos.product_picture)" alt="alt" draggable="false"> -->
        <img src="static/noImgAvailable.png" draggable="false">
      </figure>
    </div>
    <transition name="fade">
      <div class="card-content notification" v-if="hover">
        <div class="media">
          <div class="media-content">
            <ul>
              <li>{{infos.products_name}}</li>
              <li class="has-text-right">{{ formatedprice(20) }}</li>
            </ul>
          </div>
        </div>
      </div>
    </transition>
  </div>
</div>
</template>

<script>
export default {
  props: ['infos'],
  data () {
    return {
      hover: false
    }
  },
  methods: {
    getImage (picture) {
      return picture === '' ? 'static/noImgAvailable.png' : picture
    },
    formatedprice (price) {
      return price + ' CHF'
    },
    removeProductFromShopBag () {
      // remove from api / toast
    }
  }
}
</script>

<style scoped>
.card {
  height: 320px;
  width: 200px;
}
.card-image {
  cursor: pointer;
}
.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>