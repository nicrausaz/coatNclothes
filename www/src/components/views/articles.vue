<template>
  <div class="container">
  <subtitle :name="'Articles'" :text="'Liste des articles'"></subtitle>
    <section class="section">
      <div id="filters">
        <b-field>
          <b-radio-button v-model="selectedView" native-value="cardedView">
              <i class="fa fa-th-large"></i>
          </b-radio-button>
          <b-radio-button v-model="selectedView" native-value="listedView">
              <i class="fa fa-list"></i>
          </b-radio-button>
        </b-field>
        <hr>
      </div>
        <div id="cardedArticles" class="columns is-multiline" v-if="isCardedView">
          <cardedArticle v-for="article in products_list" :key="article.product_id" :infos="article"></cardedArticle>
        </div>
        <div id="linedArticles" v-else>
          <lined-article v-for="article in products_list" :key="article.product_id" :infos="article"></lined-article>
        </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import cardedArticle from '@/components/shared/articles/cardedArticle'
import linedArticle from '@/components/shared/articles/linedArticle'
export default {
  data () {
    return {
      selectedView: 'cardedView',
      products_list: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/products'
    })
    .then((response) => {
      this.products_list = response.data
    })
  },
  computed: {
    isCardedView () {
      return this.selectedView === 'cardedView'
    }
  },
  components: {
    subtitle,
    cardedArticle,
    linedArticle
  }
}
</script>
