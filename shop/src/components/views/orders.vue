<template>
  <div class="container">
    <subtitle :name="$store.state.interface.orders" :text="$store.state.interface.watchOrders"></subtitle>
    <section class="section">
      <b-table :data="orders" :opened-detailed="[requestedOrder]" detailed detail-key="orders_id">
        <template slot-scope="props">
            <b-table-column :label="$store.state.interface.number" width="40" numeric>
              {{ props.row.orders_id }}
            </b-table-column>
            <b-table-column :label="$store.state.interface.paid">
              <b-icon size="is-small" :icon="isPaidIcon(props.row.orders_paid)"></b-icon>
            </b-table-column>
            <b-table-column :label="$store.state.interface.paidDate">
              {{ props.row.orders_paidDate }}
            </b-table-column>
            <b-table-column :label="$store.state.interface.state">
              {{ props.row.ordersStatus_name}}
            </b-table-column>
            <b-table-column :label="$store.state.interface.date">
              {{ props.row.orders_createdDate }}
            </b-table-column>
            <b-table-column centered>
              <b-tooltip :label="$store.state.interface.downloadBill" position="is-bottom">
                <a @click="printOrder(props.row.orders_id)"><b-icon icon="file-pdf"></b-icon></a>
              </b-tooltip>
            </b-table-column>
        </template>
        <template slot="detail" slot-scope="props">
          <div class="columns">
            <orderProduct :orderId="props.row.orders_id" class="column is-6"></orderProduct>
          </div>
        </template>
         <template slot="empty">
            <section class="section">
              <div class="content has-text-centered has-text-centered subtitle is-3">
                <p><b-icon icon="inbox" size="is-large"> </b-icon></p>
                <p>{{$store.state.interface.noOrders}}</p>
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
      orders: [],
      ordersStatusAvailable: []
    }
  },
  created () {
    this.getOrders()
  },
  methods: {
    getOrders () {
      this.axios({
        method: 'get',
        url: 'orders/user/' + this.$store.state.user.users_id
      })
      .then(response => {
        this.orders = response.data
      })
    },
    printOrder (id) {
      this.axios({
        method: 'get',
        url: '/order/' + id + '/pdf',
        responseType: 'arraybuffer'
      })
      .then(response => {
        let blob = new Blob([response.data], { type: 'application/pdf' })
        let url = window.URL.createObjectURL(blob)
        let filename = 'order' + id
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', filename)
        document.body.appendChild(link)
        link.click()
      })
    },
    getOrdersStatusAvailable () {
      this.axios({
        method: 'get',
        url: '/admin/orders/status/available'
      })
      .then(response => {
        this.ordersStatusAvailable = response.data
      })
    },
    isPaidIcon (isAdmin) {
      return isAdmin ? 'check' : 'times'
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
