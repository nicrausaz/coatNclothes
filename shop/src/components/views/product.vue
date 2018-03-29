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
              <b-tag>categoryname</b-tag>
            </section>
            <section class="section">
              <b-select placeholder="Taille" v-model="currentProduct.selectedSize">
                <option v-for="size in productData.products_size" :key="size">
                  {{ size }}
                </option>
              </b-select>
              <section class="section">
                <a class="button is-primary is-rounded" @click="openWishlistSelector">
                  <b-icon icon="heart"></b-icon>
                </a>
                <a class="button is-primary is-rounded" @click="addToBasket">
                  <b-icon icon="cart-plus"></b-icon>
                </a>
              </section>
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
import productshelpers from '@/mixins/productsHelpers'

export default {
  mixins: [productshelpers],
  data () {
    return {
      productData: [],
      currentProduct: {
        selectedSize: null
      },
      loaded: false
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
    addToBasket () {
      this.addProductToBasket(this.$route.params.id, this.currentProduct.selectedSize)
    }
  },
  watch: {
    $route () { this.getProductData() }
  },
  computed: {
    textSize () {
      return this.currentProduct.selectedSize === '' ? 'Choisir la taille' : this.currentProduct.selectedSize
    }
  },
  created () {
    this.getProductData()
  },
  components: {
    pictureCarousel,
    wishListChooseModal,
    suggestedproducts
  }
}
</script>
