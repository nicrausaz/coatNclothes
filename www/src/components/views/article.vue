<template>
  <div class="container">
    <subtitle :name="'Article ' + articleId" :text="''"></subtitle>
    <section class="section">
      <div class="tile is-ancestor">
        <div class="tile is-parent">
          <article class="tile is-child">
              <pictureCarousel></pictureCarousel>
          </article>
        </div>
        <div class="tile is-parent is-vertical">
          <article class="tile is-child is-vertical">
            <p class="title">Article descr</p>
            <section>
              <b-tag rounded>Tag1</b-tag>
              <b-tag rounded>Tag2</b-tag>
            </section>
             <b-dropdown>
              <button class="button is-primary" slot="trigger">
                  <span>{{ textSize }}</span>
                  <b-icon icon="angle-down"></b-icon>
              </button>
              <b-dropdown-item v-for="size in availableSizes" :key="size" @click="setSize(size)">{{ size }}</b-dropdown-item>
            </b-dropdown>
          </article>
        </div>
      </div>
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
      availableSizes: ['S', 'M', 'L', 'XL'],
      selectedSize: ''
    }
  },
  methods: {
    setSize (size) {
      this.selectedSize = size
    }
  },
  computed: {
    textSize () {
      return this.selectedSize === '' ? 'Choisir la taille' : this.selectedSize
    }
  },
  created () {
    // get req via id $route.params.id
  },
  components: {
    pictureCarousel,
    subtitle
  }
}
</script>