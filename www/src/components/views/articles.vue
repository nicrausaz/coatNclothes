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
          product_price: 56,
          product_brand: 'Nike',
          product_picture: '',
          product_category_name: 'Blouses',
          product_category_id: 64
        },
        {
          product_id: 3,
          product_name: 'Chaussettes sandales',
          product_description: 'Paire de chaussettes-sandales, idéales pour les dimanches pétanque',
          product_price: 20,
          product_brand: 'Adidas',
          product_picture: '/static/articles/chausettessandales.jpg',
          product_category_name: 'Chaussettes',
          product_category_id: 23
        },
        {
          product_id: 4,
          product_name: 'Bonnet barbe',
          product_description: 'Un bonnet permettant (enfin) à tout le monde d\'avoir une barbe',
          product_price: 34,
          product_brand: '',
          product_picture: '/static/articles/bonnetbarbe.jpg',
          product_category_name: 'Bonnets',
          product_category_id: 12
        },
        {
          product_id: 5,
          product_name: 'Pull tricoté serpent',
          product_description: 'Augmenter vos chance de ne pas conclure ce soir !',
          product_price: 45,
          product_brand: '',
          product_picture: '/static/articles/pullserpent.jpg',
          product_category_name: 'Pulls',
          product_category_id: 2
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
