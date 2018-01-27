<template>
  <section>
    <b-table :data="products" :hoverable="true" :mobile-cards="true" :narrowed="true">
        <template slot-scope="props">
            <b-table-column width="20">
                <a @click="deleteItem(props.row.id)"><b-icon icon="times" size="is-small"></b-icon></a>
            </b-table-column>
            <b-table-column width="100" label="Image">
                <img :src="props.row.img">
            </b-table-column>
            <b-table-column label="Nom">
                {{ props.row.name }}
            </b-table-column>
            <b-table-column label="Description"> <!-- not necessary -->
                {{ props.row.description }}
            </b-table-column>
            <b-table-column label="Prix">
                {{ formatedPrice(props.row.price) }}
            </b-table-column>
            <b-table-column label="Actions" width="110">       
                <b-tooltip label="Voir l'article" position="is-top"><router-link class="button" to="/article/1"><b-icon icon="info" size="is-small"></b-icon></router-link></b-tooltip>
                <b-tooltip label="Ajouter au panier" position="is-top"><a class="button is-primary" @click="addToBasket(props.row.id)"><b-icon icon="shopping-cart" size="is-small"></b-icon></a></b-tooltip>
            </b-table-column>
        </template>

        <template slot="empty">
            <section class="section">
                <div class="content has-text-grey has-text-centered">
                    <p>
                      <b-icon icon="frown-o" size="is-large"></b-icon>
                    </p>
                    <p>La liste est vide, ajoutez-y des articles !</p>
                </div>
            </section>
        </template>
    </b-table>
  </section>
</template>

<script>
  export default {
    props: ['products'],
    data () {
      return {
      }
    },
    methods: {
      formatedPrice (price) {
        return price.toFixed(2) + ' CHF'
      },
      addToBasket (id) {
        console.log(id)
      },
      deleteItem (id) {
        console.log(id)
      }
    }
  }
</script>
