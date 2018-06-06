<template>
  <div class="container">
    <subtitle :name="$store.state.interface.home" :text="''"></subtitle>
    <section class="section">
      <h1 class="title">{{$store.state.interface.lastNews}}</h1>
      <carousel :perPage="5" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5">
        <slide v-for="product in newProducts" :key="product.products_id" class="slides">
          <router-link :to="/product/ + product.products_id">
            <figure class="image">
              <img :src="getPicture(product.productsPics_path)" :alt="getAltname(product.productsPics_altName)">
            </figure>
            <div class="infos">
              <ul>
                <li>{{product.products_name}}</li>
                <li class="has-text-right">
                  <small><b>{{product.products_price}} CHF</b></small>
                </li>
              </ul>
            </div>
          </router-link>
        </slide>
      </carousel>
      <h2 class="subtitle">{{$store.state.interface.subcribeRSS}}</h2>
       <a class="button is-primary" :href="'https://api.coatandclothes.shop/' + this.$store.state.language + '/feed/atom'" target="_blank">
        <b-icon icon="rss"></b-icon>
        <span>RSS</span>
      </a>
    </section>
    <section class="section">
      <h1 class="title">{{$store.state.interface.bestProducts}}</h1>
      <carousel :perPage="5" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5">
        <slide v-for="product in bestProducts" :key="product.products_id" class="slides">
          <router-link :to="/product/ + product.products_id">
            <figure class="image">
              <img :src="getPicture(product.productsPics_path)" :alt="getAltname(product.productsPics_altName)">
            </figure>
            <div class="infos">
              <ul>
                <li>{{product.products_name}}</li>
                <li class="has-text-right">
                  <small><b>{{product.products_price}} CHF</b></small>
                </li>
                <li><star-rating :star-size="15" :show-rating="false" :read-only="true" :rating="getNote(product.commentsAndOpinions_avg)" :inline="true"></star-rating></li>
              </ul>
            </div>
          </router-link>
        </slide>
      </carousel>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import StarRating from 'vue-star-rating'

export default {
  data () {
    return {
      newProducts: [],
      bestProducts: []
    }
  },
  created () { this.getHomeProducts() },
  methods: {
    getHomeProducts () {
      this.axios({
        method: 'get',
        url: '/home'
      })
      .then(response => {
        this.newProducts = response.data['5newest']
        this.bestProducts = response.data['5best']
      })
    },
    getNote (note) {
      return note / 2
    },
    getPicture (img) {
      return img || '/static/noImgAvailable.png'
    },
    getAltname (alt) {
      return alt || 'noImg'
    }
  },
  components: {
    subtitle,
    StarRating
  }
}
</script>

<style scoped>
img {
  height: 200px;
}
.slides {
  padding: 10px;
  width: 200px;
  height: 350px;
}
.infos {
  padding: 10px;
}
</style>
