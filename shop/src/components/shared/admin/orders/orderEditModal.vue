<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Info & édition de commande</p>
    </header>
    <section class="modal-card-body">
      <h1 class="subtitle">Infos</h1>
      <p><b>Date de commande:</b> {{orderBaseInfos.orders_createdDate}}</p>
      <p><b>Client:</b>
        {{userData.users_name}}
        {{userData.users_fsname}},
        {{userData.users_email}}
        (#{{orderBaseInfos.fk_users_id}})
      </p>
      <p><b>Adresse:</b> {{orderBaseInfos.fk_adresses_id}}</p>
      <b-table :data="orderData" default-sort="ordersContent_id" :mobile-cards="false">
        <template slot-scope="props">
          <b-table-column field="ordersContent_quantity" label="Quantité" width="40" numeric>
            {{ props.row.ordersContent_quantity }}
          </b-table-column>
          <b-table-column field="ordersContent_quantity" label="Produit">
            {{ props.row.fk_products_id }}
          </b-table-column>
          <b-table-column field="ordersContent_quantity" label="Taille">
            {{ props.row.fk_productsSize_id }}
          </b-table-column>
        </template>
      </b-table>
      <br>

      <h1 class="subtitle">Edition</h1>
      <b-field>
        <b-checkbox v-model="orderBaseInfos.orders_paid" :disabled="orderIsPaid" true-value="1" false-value="0">Paiement reçu {{orderPaidDate}}</b-checkbox>
      </b-field>
      <b-field label="Etat de la commande">
        <b-select placeholder="Etat de la commande" v-model="orderBaseInfos.fk_ordersStatus_id" expanded>
          <option v-for="status in ordersStatusAvailable" :value="status.ordersStatus_id" :key="status.ordersStatus_id"> {{ status.ordersStatus_name }} </option>
        </b-select>
      </b-field>

    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="updateOrder">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['orderInfos'],
  data () {
    return {
      orderBaseInfos: {},
      orderData: [],
      userData: {},
      ordersStatusAvailable: [],
      originalPaidState: false
    }
  },
  created () {
    this.orderBaseInfos = this.orderInfos
    this.originalPaidState = this.orderBaseInfos.orders_paid
    this.getOrder()
    this.getOrdersStatusAvailable()
    this.getUser()
    // this.getProducts()
  },
  computed: {
    orderIsPaid () {
      return this.orderBaseInfos.orders_paid === 1
    },
    orderPaidDate () {
      return this.orderBaseInfos.orders_paid === 1 ? 'le ' + this.orderBaseInfos.orders_paidDate : ''
    }
  },
  methods: {
    getOrder () {
      this.axios({
        method: 'get',
        url: '/admin/order/' + this.orderInfos.orders_id
      })
      .then(response => {
        this.orderData = response.data
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
    getUser () {
      this.axios({
        method: 'get',
        url: '/admin/user/' + this.orderBaseInfos.fk_users_id
      })
      .then(response => {
        this.userData = response.data
      })
    },
    updateOrder () {
      // if paid: patch /admin/order/id/paid
      if (!this.originalPaidState && this.orderBaseInfos.orders_paid) {
        console.log('need to pay')
      }
      this.axios({
        method: 'patch',
        url: '/admin/order/' + this.orderBaseInfos.orders_id + '/status/' + this.orderBaseInfos.fk_ordersStatus_id
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('update')
        this.$parent.close()
      })
    }
  }
}
</script>
