<template>
  <section>
    <h2 class="subtitle">
      {{$store.state.interface.editOrders}}
    </h2>
    <hr>
    <b-field grouped group-multiline>
      <b-select v-model="filter.perPage">
        <option value="5">5 {{$store.state.interface.perPage}}</option>
        <option value="10">10 {{$store.state.interface.perPage}}</option>
        <option value="20">20 {{$store.state.interface.perPage}}</option>
        <option value="40">40 {{$store.state.interface.perPage}}</option>
      </b-select>
      <b-select v-model="filter.orderStatus" :placeholder="$store.state.interface.statusSearch">
        <option v-for="orderStatus in ordersStatusAvailable" :key="orderStatus.ordersStatus_id" :value="orderStatus.ordersStatus_id">{{orderStatus.ordersStatus_name}}</option>
      </b-select>
    </b-field>
    <b-table :data="filteredOrders" :per-page="filter.perPage" :paginated="true" :pagination-simple="true" default-sort="orders_createdDate" :default-sort-direction="'desc'" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="orders_id" :label="$store.state.interface.No" width="40" sortable numeric>
          {{ props.row.orders_id }}
        </b-table-column>

        <b-table-column field="orders_paid" :label="$store.state.interface.paid" sortable>
          <b-icon size="is-small" :icon="isPaidIcon(props.row.orders_paid)"></b-icon>
        </b-table-column>

        <b-table-column field="orders_paidDate" :label="$store.state.interface.paidDate" sortable>
          {{ props.row.orders_paidDate }}
        </b-table-column>

        <b-table-column field="orders_createdDate" :label="$store.state.interface.orderDate" sortable>
          {{ props.row.orders_createdDate }}
        </b-table-column>
        <b-table-column field="ordersStatus_name" :label="$store.state.interface.status" sortable>
          {{ props.row.ordersStatus_name }}
        </b-table-column>

        <b-table-column :label="$store.state.interface.actions" centered>
          <b-tooltip :label="$store.state.interface.detailsAndEdit" position="is-left">
            <a @click="editOrder(props.row)">
              <span class="icon is-small">
                <b-icon icon="edit"></b-icon>
              </span>
            </a>
          </b-tooltip>
        </b-table-column>
      </template>
    </b-table>
    <b-modal :active.sync="isEditing" has-modal-card>
      <orderEditModal :orderInfos="orderInfos" @update="getOrders"></orderEditModal>
    </b-modal>
  </section>
</template>

<script>
import orderEditModal from '@/components/shared/admin/orders/orderEditModal'

export default {
  data () {
    return {
      filter: {
        perPage: 10,
        orderStatus: null
      },
      isEditing: false,
      orders: [],
      orderInfos: {},
      ordersStatusAvailable: []
    }
  },
  created () {
    this.getOrders()
    this.getOrdersStatusAvailable()
  },
  computed: {
    filteredOrders () {
      let results = []
      if (!this.filter.orderStatus) {
        return this.orders
      } else {
        this.orders.forEach(order => {
          if (order.fk_ordersStatus_id === this.filter.orderStatus) {
            results.push(order)
          }
        })
      }
      return results
    }
  },
  methods: {
    getOrders () {
      this.axios({
        method: 'get',
        url: '/admin/orders'
      })
      .then(response => {
        this.orders = response.data
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
    editOrder (orderInfos) {
      this.orderInfos = orderInfos
      this.isEditing = true
    },
    isPaidIcon (isAdmin) {
      return isAdmin ? 'check' : 'times'
    }
  },
  components: {
    orderEditModal
  }
}
</script>
