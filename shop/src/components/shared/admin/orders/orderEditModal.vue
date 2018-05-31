<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.detailAndEditOrder}}</p>
    </header>
    <section class="modal-card-body">
      <p><b>{{$store.state.interface.orderDate}}:</b> {{orderBaseInfos.orders_createdDate}}</p>
      <p><b>{{$store.state.interface.customer}}:</b>
        {{userData.users_name}}
        {{userData.users_fsname}},
        {{userData.users_email}}
        (#{{orderBaseInfos.fk_users_id}})
      </p>
      <p><b>{{$store.state.interface.address}}:</b> {{orderAddress.adresses_street}}, {{orderAddress.adresses_npa}} {{orderAddress.adresses_locality}}, {{orderAddress.adresses_state}}</p>

      <div v-if="loaded">
      <b>{{$store.state.interface.content}}:</b>
        <ul>
          <li v-for="(info, index) in orderData" :key="info.ordersContent_id">
            {{info.ordersContent_quantity}}x
            <span>{{orderProducts[index].products_name}}</span>
            {{info.productsSize_value}}
          </li>
        </ul>
      </div>
      <br>
      <b-field>
        <b-checkbox v-model="orderBaseInfos.orders_paid" :disabled="orderIsPaid" true-value="1" false-value="0">{{$store.state.interface.paid}} {{orderPaidDate}}</b-checkbox>
      </b-field>
      <b-field :label="$store.state.interface.status">
        <b-select placeholder="Etat de la commande" v-model="orderBaseInfos.fk_ordersStatus_id" expanded>
          <option v-for="status in ordersStatusAvailable" :value="status.ordersStatus_id" :key="status.ordersStatus_id"> {{ status.ordersStatus_name }} </option>
        </b-select>
      </b-field>

    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="updateOrder">{{$store.state.interface.confirm}}</button>
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
      orderAddress: {},
      orderProducts: [],
      ordersStatusAvailable: [],
      originalPaidState: false,
      loaded: false
    }
  },
  created () {
    this.orderBaseInfos = this.orderInfos
    this.originalPaidState = this.orderBaseInfos.orders_paid
    this.getOrder()
    this.getOrdersStatusAvailable()
    this.getUser()
    this.getAddress(this.orderBaseInfos.fk_adresses_id)
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
        this.getProducts()
        this.loaded = true
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
    getAddress (id) {
      this.axios({
        method: 'get',
        url: '/admin/address/' + id
      })
      .then(response => {
        this.orderAddress = response.data
      })
    },
    getProducts () {
      this.orderData.forEach(item => {
        this.axios({
          method: 'get',
          url: '/product/' + item.fk_products_id + '/unrestricted'
        })
        .then(response => {
          this.orderProducts.push(response.data)
        })
      })
    },
    updateOrder () {
      if (this.originalPaidState === 0 && this.orderBaseInfos.orders_paid === '1') {
        this.axios({
          method: 'patch',
          url: '/admin/order/' + this.orderBaseInfos.orders_id + '/paid'
        })
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
