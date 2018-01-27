<template>
  <section>
    <b-table :data="isEmpty ? [] : products"
        :hoverable="true"
        :mobile-cards="true">

        <template slot-scope="props">
            <b-table-column width="40">
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
            <b-table-column label="" width="110">
                <router-link class="button is-primary is-outlined" to="/article/1"><b-icon icon="info" size="is-small"></b-icon></router-link>
                <a class="button is-primary" @click="addToBasket"><b-icon icon="plus" size="is-small"></b-icon></a>
            </b-table-column>
        </template>

        <template slot="empty">
            <section class="section">
                <div class="content has-text-grey has-text-centered">
                    <p>
                        <b-icon icon="frown-o" size="is-large"></b-icon>
                    </p>
                    <p>La liste est vide ...</p>
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
      addToBasket () {}
    },
    computed: {
      isChecked () {
        return this.checkedRows > 0
      },
      isEmpty () {
        return this.products.lenght === 0
      }
    }
  }
</script>
