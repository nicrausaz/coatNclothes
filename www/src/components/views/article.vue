<template>
  <div class="container">
    <subtitle :name="'Article ' + articleId" :text="''"></subtitle>
    <section class="section">
      <div class="tile is-ancestor">
        <div class="tile is-parent">
          <article class="tile is-child">
              <pictureCarousel :pictures="articleData.products_pictures"></pictureCarousel>
          </article>
        </div>
        <div class="tile is-parent is-vertical">
          <article class="tile is-child is-vertical">
            <p class="title">{{ articleData.products_name }}</p>
            <section>
              {{articleData.products_description}}
            </section>
            <section>
              <b-tag rounded>Category</b-tag>
              <b-tag rounded>Tag2</b-tag>
            </section>
            <section>
              <div class="buttons has-addons">
                <span class="button" v-for="color in articleData.products_colors" :key="color.name" :style="'background-color:' + color.hex" @click="setColor(color.name)">{{color.name}}</span>
              </div>
            </section>
             <b-dropdown>
              <button class="button is-primary" slot="trigger">
                  <span>{{ textSize }}</span>
                  <b-icon icon="angle-down"></b-icon>
              </button>
              <b-dropdown-item v-for="size in articleData.products_size" :key="size" @click="setSize(size)">{{ size }}</b-dropdown-item>
            </b-dropdown>
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
import subtitle from '@/components/templates/subtitle'
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
    subtitle
  }
}
</script>