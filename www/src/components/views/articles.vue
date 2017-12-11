<template>
  <div class="container">
  <subtitle :name="'Articles'" :text="'Liste des articles'"></subtitle>
    <section class="section">
        <b-field>
          <b-radio-button v-model="selectedView" native-value="cardedView">
              <i class="fa fa-th-large"></i>
          </b-radio-button>
          <b-radio-button v-model="selectedView" native-value="listedView">
              <i class="fa fa-list"></i>
          </b-radio-button>
        </b-field>
        <hr> <!-- Do something better -->

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
import cardedArticle from '@/components/shared/cardedArticle'
import linedArticle from '@/components/shared/linedArticle'
export default {
  data () {
    return {
      selectedView: 'cardedView',
      products_list: [
        {
          product_id: 1,
          product_name: 'T-Shirt baleine bleu',
          product_description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus mauris, placerat ut condimentum non',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 2,
          product_name: 'Pantalon court pour aveugle',
          product_description: 'Un pantalon (très) minimaliste, pour aveugle',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 1,
          product_name: 'T-Shirt baleine bleu',
          product_description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus mauris, placerat ut condimentum non',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 2,
          product_name: 'Pantalon court pour aveugle',
          product_description: 'Un pantalon (très) minimaliste, pour aveugle',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 1,
          product_name: 'T-Shirt baleine bleu',
          product_description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus mauris, placerat ut condimentum non',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 2,
          product_name: 'Pantalon court pour aveugle',
          product_description: 'Un pantalon (très) minimaliste, pour aveugle',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 1,
          product_name: 'T-Shirt baleine bleu',
          product_description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus mauris, placerat ut condimentum non',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 2,
          product_name: 'Pantalon court pour aveugle',
          product_description: 'Un pantalon (très) minimaliste, pour aveugle',
          product_price: 56.5,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        }
      ]
    }
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
