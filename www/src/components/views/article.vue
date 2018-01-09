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
      articleId: this.$route.params.id
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