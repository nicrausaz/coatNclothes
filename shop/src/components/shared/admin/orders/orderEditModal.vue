<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Info & édition de commande</p>
    </header>
    <section class="modal-card-body">
      <h1 class="subtitle">Infos</h1>
      <p><b>Date de commande:</b> {{orderBaseInfos.orders_createdDate}}</p>
      <p><b>Client:</b> ?? ?? (#{{orderBaseInfos.fk_users_id}})</p>
      <p><b>Adresse:</b> {{orderBaseInfos.fk_adresses_id}}</p>
      <b-table :data="orderData" default-sort="ordersContent_id" :mobile-cards="false">
        <template slot-scope="props">
          <b-table-column field="ordersContent_quantity" label="Quantité" width="40" numeric>
            {{ props.row.ordersContent_quantity }}
          </b-table-column>
          <b-table-column field="ordersContent_quantity" label="Produit">
            {{orderProducts}}
            {{ props.row.fk_products_id }}
          </b-table-column>
          <b-table-column field="ordersContent_quantity" label="Taille">
            {{ props.row.fk_productsSize_id }}
          </b-table-column>
        </template>
      </b-table>
      <br>
      <h1 class="subtitle">Edition</h1>

      <b-field label="Payée ?">
        <b-checkbox v-model="orderBaseInfos.orders_paid" ></b-checkbox>
      </b-field>
      <b-field>
        <!-- <b-datepicker placeholder="Date de paiement" icon="calendar-alt" v-model="paymentDate"></b-datepicker> -->
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
      ordersStatusAvailable: {},
      newData: {
        orderStatus: null
      }
    }
  },
  created () {
    this.orderBaseInfos = this.orderInfos
    this.getOrder()
    this.getOrdersStatusAvailable()
    this.getUser()
    this.getProducts()
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
    updateOrder () {}
  }
}
</script>
