<template>
  <div class="container">
    <section class="section">
      <div class="tile is-ancestor">
        <div class="tile is-parent">
          <article class="tile is-child">
              <pictureCarousel :pictures="articleData.products_pictures"></pictureCarousel>
          </article>
        </div>
        <div class="tile is-parent is-vertical">
          <article class="tile is-child is-vertical">
            <section class="section">
              {{articleData.products_brand}}
              <p class="title">{{ articleData.products_name }}</p>

              <p><i>{{articleData.products_description}}</i></p>
              <b-tag rounded>Category1</b-tag> <!-- get from api -->
              <b-tag rounded>Category2</b-tag>
              <b-tag rounded>Category3</b-tag>
            </section>

            <section class="section">
              <form>
                <div class="buttons has-addons">
                  <span class="button" v-for="color in articleData.products_colors" :key="color.name" :style="'background-color:' + color.hex" @click="setColor(color.name)">{{color.name}}</span>
                </div>

                <b-dropdown>
                  <button class="button is-primary" slot="trigger">
                      <span>{{ textSize }}</span>
                      <b-icon icon="angle-down"></b-icon>
                  </button>
                  <b-dropdown-item v-for="size in articleData.products_size" :key="size" @click="setSize(size)">{{ size }}</b-dropdown-item>
                </b-dropdown>
                <section class="section">
                  <a class="button is-primary is-rounded" @click="openWishlistSelector"><b-icon icon="heart"></b-icon></a>
                  <a class="button is-primary is-rounded"><b-icon icon="cart-plus"></b-icon></a>
                </section>
              </form>
            </section>
          </article>
          {{currentArticle}}
        </div>
      </div>
      <pre>
        {{articleData}}
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
      articleId: this.$route.params.id,
      articleData: [],
      currentArticle: {
        selectedSize: '',
        selectedColor: ''
      }
    }
  },
  methods: {
    setSize (size) {
      this.currentArticle.selectedSize = size
    },
    setColor (color) {
      this.currentArticle.selectedColor = color
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
      return this.currentArticle.selectedSize === '' ? 'Choisir la taille' : this.currentArticle.selectedSize
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.articleId
    })
    .then(response => {
      this.articleData = response.data
    })
  },
  components: {
    pictureCarousel,
    wishListChooseModal
  }
}
</script>
