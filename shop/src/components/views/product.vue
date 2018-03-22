<template>
  <div class="container">
    <section class="section">
      <div class="tile is-ancestor">
        <div class="tile is-parent">
          <div class="tile is-child">
            <pictureCarousel :pictures="productData.products_pictures"></pictureCarousel>
          </div>
        </div>
        <div class="tile is-parent is-vertical">
          <div class="tile is-child is-vertical">
            <section class="section">
              {{productData.products_brand}}
              <p class="title">{{ productData.products_name }}</p>

              <p>
                <i>{{productData.products_description}}</i>
              </p>
              <b-tag rounded>{{categoryName}}</b-tag>
            </section>

            <section class="section">
              <form>
                <b-dropdown v-model="currentProduct.selectedSize">
                  <button class="button is-primary" slot="trigger">
                    <span>{{ textSize }}</span>
                    <b-icon icon="angle-down"></b-icon>
                  </button>
                  <b-dropdown-item v-for="size in productData.products_size" :key="size" :value="size">{{ size }}</b-dropdown-item>
                </b-dropdown>
                <section class="section">
                  <a class="button is-primary is-rounded" @click="openWishlistSelector">
                    <b-icon icon="heart"></b-icon>
                  </a>
                  <a class="button is-primary is-rounded" @click="addToBasket">
                    <b-icon icon="cart-plus"></b-icon>
                  </a>
                </section>
              </form>
            </section>
          </div>
        </div>
      </div>
      <suggestedproducts v-if="loaded" :category="productData.fk_category_id"></suggestedproducts>
    </section>
  </div>
</template>

<script>
import pictureCarousel from '@/components/shared/pictureCarousel'
import wishListChooseModal from '@/components/shared/wishlists/wishListChooseModal'
import suggestedproducts from '@/components/shared/products/suggestedProducts'

export default {
  data () {
    return {
      productId: this.$route.params.id,
      productData: [],
      currentProduct: {
        selectedSize: ''
      },
      loaded: false,
      categoryName: ''
    }
  },
  methods: {
    setSize (size) {
      this.currentProduct.selectedSize = size
    },
    openWishlistSelector () {
      this.$modal.open({
        parent: this,
        component: wishListChooseModal,
        hasModalCard: true
      })
    },
    checkSelection () {
      return this.currentProduct.selectedSize !== ''
    },
    addToBasket () {
      if (this.checkSelection()) {
        console.log('good')
        // send to api
      }
    }
  },
  computed: {
    textSize () {
      return this.currentProduct.selectedSize === '' ? 'Choisir la taille' : this.currentProduct.selectedSize
    },
    categoryName () {
      if (this.loaded) {
        this.axios({
          method: 'get',
          url: 'category/' + this.product_data.fk_category_id
        })
        .then(response => {
          return response.data
        })
      }
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.productId
    })
    .then(response => {
      this.productData = response.data
      this.loaded = true
    })
  },
  components: {
    pictureCarousel,
    wishListChooseModal,
    suggestedproducts
  }
}
</script>
