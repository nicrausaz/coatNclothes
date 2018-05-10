<template>
  <section>
    <h2 class="subtitle">
      Éditer les commandes
    </h2>
    <hr>
    <b-field grouped group-multiline>
      <b-select v-model="filter.perPage">
        <option value="5">5 par page</option>
        <option value="10">10 par page</option>
        <option value="20">20 par page</option>
      </b-select>
      <b-input placeholder="Rechercher..." type="search" icon-pack="fas" icon="search" v-model="searchContent"></b-input>
    </b-field>
    <b-table :data="orders" :per-page="filter.perPage" default-sort="orders_id" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="orders_id" label="No" width="40" sortable numeric>
          {{ props.row.orders_id }}
        </b-table-column>

        <b-table-column field="orders_paid" label="Payé" sortable>
          {{ props.row.orders_paid }}
        </b-table-column>

        <b-table-column field="orders_paidDate" label="Date de paiement" sortable>
          {{ props.row.orders_paidDate }}
        </b-table-column>

        <b-table-column field="orders_createdDate" label="Date de commande" sortable>
          {{ props.row.orders_createdDate }}
        </b-table-column>
        <b-table-column field="ordersStatus_name" label="Status" sortable>
          {{ props.row.ordersStatus_name }}
        </b-table-column>

        <b-table-column label="Actions" centered>
          <b-tooltip label="Détails et édition" position="is-left">
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
        perPage: 20
      },
      isEditing: false,
      searchContent: '',
      orders: [],
      orderInfos: {}
    }
  },
  created () {
    this.getOrders()
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
    editOrder (orderInfos) {
      this.orderInfos = orderInfos
      this.isEditing = true
    }
  },
  components: {
    orderEditModal
  }
}
</script>
