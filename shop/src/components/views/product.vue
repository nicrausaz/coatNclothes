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
              <star-rating :star-size="20" :show-rating="false" :read-only="true" v-model="noteToInt" :inline="true"></star-rating> ({{productNote.number}})
              <br>
              <b-select placeholder="Taille" v-model="currentProduct.selectedSize">
                <option v-for="size in productData.products_size" :key="size">
                  {{ size }}
                </option>
              </b-select>
              <br>
              <a class="button is-medium" @click="openWishlistSelector">
                <span class="icon">
                  <b-icon icon="heart"></b-icon>
                </span>
                <span>Ajouter dans une liste de souhait</span>
              </a>
              <br>
              <a class="button is-medium is-primary" @click="addToBasket">
                <span class="icon">
                  <b-icon icon="cart-plus"></b-icon>
                </span>
                <span>Ajouter dans le panier</span>
              </a>
            </section>
          </div>
        </div>
      </div>
      <div class="columns">
        <reviews class="column" @new="getProductNote"></reviews>
        <suggestedproducts v-if="loaded" :category="productData.fk_category_id" class="column"></suggestedproducts>
      </div>
    </section>
    <b-modal :active.sync="wishlistselect">
      <wishListChooseModal :productId="productData.products_id"></wishListChooseModal>
    </b-modal>
  </div>
</template>

<script>
import pictureCarousel from '@/components/shared/pictureCarousel'
import wishListChooseModal from '@/components/shared/wishlists/wishListChooseModal'
import suggestedproducts from '@/components/shared/products/suggestedProducts'
import reviews from '@/components/shared/products/productReviews'
import productshelpers from '@/mixins/productsHelpers'
import StarRating from 'vue-star-rating'

export default {
  mixins: [productshelpers],
  data () {
    return {
      productData: [],
      productNote: {},
      currentProduct: {
        selectedSize: null
      },
      loaded: false,
      wishlistselect: false
    }
  },
  methods: {
    getProductData () {
      this.axios({
        method: 'get',
        url: 'product/' + this.$route.params.id
      })
      .then(response => {
        this.productData = response.data
        this.loaded = true
      })
      .catch(() => { this.$router.push('/error') })
    },
    getProductNote () {
      this.axios({
        method: 'get',
        url: 'product/' + this.$route.params.id + '/notes'
      })
      .then(response => {
        this.productNote = response.data
      })
    },
    setSize (size) {
      this.currentProduct.selectedSize = size
    },
    openWishlistSelector () {
      this.wishlistselect = true
    },
    addToBasket () {
      this.addProductToBasket(this.$route.params.id, this.currentProduct.selectedSize)
    }
  },
  watch: {
    $route () {
      this.getProductData()
      this.getProductNote()
    }
  },
  computed: {
    textSize () {
      return this.currentProduct.selectedSize === '' ? 'Choisir la taille' : this.currentProduct.selectedSize
    },
    noteToInt () {
      return parseFloat(this.productNote.average / 2)
    }
  },
  created () {
    this.getProductData()
    this.getProductNote()
  },
  components: {
    pictureCarousel,
    wishListChooseModal,
    suggestedproducts,
    reviews,
    StarRating
  }
}
</script>
