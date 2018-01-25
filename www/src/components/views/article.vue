<template>
  <div class="container">
    <section class="section">
      <div class="tile is-ancestor">
        <div class="tile is-parent">
          <article class="tile is-child">
              <pictureCarousel :pictures="productData.products_pictures"></pictureCarousel>
          </article>
        </div>
        <div class="tile is-parent is-vertical">
          <article class="tile is-child is-vertical">
            <section class="section">
              {{productData.products_brand}}
              <p class="title">{{ productData.products_name }}</p>

              <p><i>{{productData.products_description}}</i></p>
              <b-tag rounded>Category1</b-tag> <!-- get from api -->
              <b-tag rounded>Category2</b-tag>
              <b-tag rounded>Category3</b-tag>
            </section>

            <section class="section">
              <form>
                <div class="buttons has-addons">
                  <span class="button" v-for="color in productData.products_colors" :key="color.name" :style="'background-color:' + color.hex" @click="setColor(color.name)">{{color.name}}</span>
                </div>

                <b-dropdown>
                  <button class="button is-primary" slot="trigger">
                      <span>{{ textSize }}</span>
                      <b-icon icon="angle-down"></b-icon>
                  </button>
                  <b-dropdown-item v-for="size in productData.products_size" :key="size" @click="setSize(size)">{{ size }}</b-dropdown-item>
                </b-dropdown>
                <section class="section">
                  <a class="button is-primary is-rounded" @click="openWishlistSelector"><b-icon icon="heart"></b-icon></a>
                  <a class="button is-primary is-rounded"><b-icon icon="cart-plus"></b-icon></a>
                </section>
              </form>
            </section>
          </article>
          {{currentProduct}}
        </div>
      </div>
      <pre>
        {{productData}}
      </pre>
    </section>
  </div>
</template>

<script>
import pictureCarousel from '@/components/shared/pictureCarousel'
import wishListChooseModal from '@/components/shared/wishlists/wishListChooseModal'

export default {
  data () {
    return {
      productId: this.$route.params.id,
      productData: [],
      currentProduct: {
        selectedSize: '',
        selectedColor: ''
      }
    }
  },
  methods: {
    setSize (size) {
      this.currentProduct.selectedSize = size
    },
    setColor (color) {
      this.currentProduct.selectedColor = color
    },
    openWishlistSelector () {
      this.$modal.open({
        parent: this,
        component: wishListChooseModal,
        hasModalCard: true
      })
    }
  },
  computed: {
    textSize () {
      return this.currentProduct.selectedSize === '' ? 'Choisir la taille' : this.currentProduct.selectedSize
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.productId
    })
    .then(response => {
      this.productData = response.data
    })
  },
  components: {
    pictureCarousel,
    wishListChooseModal
  }
}
</script>
