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
        </template>

        <template slot="detail" slot-scope="props">
          <orderProduct v-for="i in 10" :key="i"></orderProduct>
          <!-- <orderProduct v-for="product in props.row.orders_content" :key="product.products_id"></orderProduct> -->
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
      orders: [
        { 'orders_id': 1, 'orders_paid': false, 'orders_paidDate': '', 'orders_status': 'En cours', 'orders_createdDate': '2016/10/15 13:43:27', 'orders_content': {} },
        { 'orders_id': 2, 'orders_paid': false, 'orders_paidDate': '', 'orders_status': 'En cours', 'orders_createdDate': '2016/10/15 13:43:27', 'orders_content': {} },
        { 'orders_id': 3, 'orders_paid': false, 'orders_paidDate': '', 'orders_status': 'En cours', 'orders_createdDate': '2016/10/15 13:43:27', 'orders_content': {} }
      ]
    }
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

<style>

</style>
