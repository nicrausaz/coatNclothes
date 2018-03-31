<template>
  <section>
    <b-table :data="productList" :hoverable="true" :mobile-cards="true" :narrowed="true">
      <template slot-scope="props">
        <b-table-column width="20" label="">
          <a @click="deleteItem(props.row.products_id)"><b-icon icon="times" size="is-small"></b-icon></a>
        </b-table-column>
        <b-table-column width="100" label="Image">
          <img :src="getPicture(props.row.products_pictures)" :alt="getAltName(props.row.products_pictures)">
        </b-table-column>
        <b-table-column label="Nom">
          {{ props.row.products_name }}
        </b-table-column>
        <b-table-column label="Marque">
          {{ props.row.products_brand }}
        </b-table-column>
        <b-table-column label="Prix">
          {{ formatedPrice(props.row.products_price) }}
        </b-table-column>
        <b-table-column label="Actions" width="110">
          <b-tooltip label="Voir le produit" position="is-top"><router-link class="button" :to="/product/ + props.row.products_id" ><b-icon icon="info" size="is-small"></b-icon></router-link></b-tooltip>
          <b-tooltip label="Ajouter au panier" position="is-top"><a class="button is-primary" @click="addToBasket(props.row.products_id)"><b-icon icon="shopping-cart" size="is-small"></b-icon></a></b-tooltip>
        </b-table-column>
      </template>

      <template slot="empty">
        <section class="section">
          <div class="content has-text-grey has-text-centered">
            <p>
              <b-icon icon="inbox" size="is-large"></b-icon>
            </p>
            <p>La liste est vide, ajoutez-y des produits !</p>
          </div>
        </section>
      </template>
    </b-table>
  </section>
</template>

<script>
import productshelpers from '@/mixins/productsHelpers'

export default {
  props: ['id', 'products'],
  mixins: [productshelpers],
  data () {
    return {
      productList: []
    }
  },
  created () {
    this.getProducts()
  },
  methods: {
    getProducts () {
      this.products.forEach((product) => {
        let id = product.fk_products_id
        this.axios({
          method: 'get',
          url: 'product/' + id
        })
        .then((response) => {
          this.productList.push(response.data)
        })
      })
    },
    formatedPrice (price) {
      return price.toFixed(2) + ' CHF'
    },
    getPicture (pictures) {
      return pictures.length === 0 ? 'static/noImgAvailable.png' : pictures[0].path
    },
    getAltName (pictures) {
      return pictures.length === 0 ? 'noimg' : pictures[0].altName
    },
    addToBasket (id) {
      this.addProductToBasket(id)
    },
    deleteItem (productId) {
      this.axios({
        method: 'delete',
        url: '/wishlist/' + this.id + '/user/' + this.$store.state.user.users_id + '/content',
        data: {
          'product': productId
        }
      })
      .then((response) => {
        this.$toast.open(response.data.message)
        this.productList = this.productList.filter((product) => { return product.products_id !== productId })
      })
    }
  }
}
</script>
