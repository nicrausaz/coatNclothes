<template>
  <div class="container">
    <subtitle :name="'Commandes'" :text="'Liste de vos commandes'"></subtitle>
    <section class="section">
      <b-table :data="orders" :opened-detailed="[requestedOrder]" detailed detail-key="orders_id">
        <template slot-scope="props">
            <b-table-column label="Numéro" width="40" numeric>
              {{ props.row.orders_id }}
            </b-table-column>
            <b-table-column label="Paiement">
              {{ paymentStatus(props.row.orders_paid) }}
            </b-table-column>
            <b-table-column label="Date de paiement">
              {{ props.row.orders_paidDate }}
            </b-table-column>
            <b-table-column label="État" >
              {{ props.row.orders_status}}
            </b-table-column>
            <b-table-column label="Date">
              {{ props.row.orders_createdDate }}
            </b-table-column>
            <b-table-column centered>
              <a><b-icon icon="print"></b-icon></a>
            </b-table-column>
        </template>
        <template slot="detail" slot-scope="props">
          <div class="columns is-multiline">
            <orderProduct v-for="product in props.row.ordersContent" :key="product.products_id" :data="product"></orderProduct>
          </div>
        </template>
         <template slot="empty">
            <section class="section">
              <div class="content has-text-centered has-text-centered subtitle is-3">
                <p><b-icon icon="inbox" size="is-large"> </b-icon></p>
                <p>Vous n'avez effectué aucune commande ...</p>
              </div>
            </section>
         </template>
      </b-table>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import orderProduct from '@/components/shared/orders/orderProduct'

export default {
  data () {
    return {
      orders: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'orders/user/' + this.$store.state.user.users_id + '/contents'
    })
    .then((response) => {
      this.orders = response.data
    })
  },
  methods: {
    paymentStatus (value) {
      return value ? 'Confirmé' : 'En attente'
    }
  },
  computed: {
    requestedOrder () {
      if (this.$route.params.id !== undefined) {
        return parseInt(this.$route.params.id)
      } else {
        return ''
      }
    }
  },
  components: {
    subtitle,
    orderProduct
  }
}
</script>
