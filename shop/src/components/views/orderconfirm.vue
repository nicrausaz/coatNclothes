<template>
  <div class="container">
    <subtitle :name="$store.state.interface.confirmation" :text="$store.state.interface.ConfirmOrder"></subtitle>
    <section class="section">
      <orderContentCard @confirm="setConfirmed" :basketproducts="basketproducts"></orderContentCard>
      <div class="columns">
        <div class="column">
          <addressCard @confirm="setConfirmed" @address="setAdress"></addressCard>
        </div>
        <div class="column">
          <paymentCard @confirm="setConfirmed"></paymentCard>
        </div>
      </div>
      <b-tooltip class="is-pulled-right" :label="$store.state.interface.ConfirmOrder" position="is-bottom" :active="!fullConfirmed">
        <button class="button is-primary is-large is-pulled-right" :class="{'is-loading': loading}" :disabled="!fullConfirmed" @click="finishOrder">{{$store.state.interface.confirm}}</button>
      </b-tooltip>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import orderContentCard from '@/components/shared/orders/confirm/orderContentCard'
import addressCard from '@/components/shared/orders/confirm/addressCard'
import paymentCard from '@/components/shared/orders/confirm/paymentCard'

export default {
  data () {
    return {
      confirmed: {
        orderContent: false,
        address: false,
        payment: false
      },
      orderContentFormatedData: {
        adresses_id: null,
        data: []
      },
      basketproducts: [],
      selectedAdress: null,
      loading: false
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'basket/user/' + this.$store.state.user.users_id
    })
    .then((response) => {
      this.basketproducts = response.data
      this.formatOrderContentData()
    })
  },
  computed: {
    fullConfirmed () {
      return Object.keys(this.confirmed).every(k => { return this.confirmed[k] })
    }
  },
  methods: {
    setConfirmed (item) {
      this.confirmed[item] = true
    },
    setAdress (adress) {
      this.selectedAdress = adress
      this.orderContentFormatedData.adresses_id = this.selectedAdress
    },
    formatOrderContentData () {
      this.basketproducts.forEach(product => {
        this.orderContentFormatedData.data.push({
          'product': product.products_id,
          'quantity': product.basket_quantity,
          'size': product.fk_productsSize_id
        })
      })
    },
    clearBasket () {
      this.basketproducts.forEach((product) => {
        this.axios({
          method: 'delete',
          url: '/basket/user/' + this.$store.state.user.users_id,
          data: {
            'product': product.products_id
          }
        })
        .then(() => {
          this.$store.dispatch('getShopbagQuantity')
        })
      })
    },
    finishOrder () {
      this.loading = true
      this.axios({
        method: 'put',
        url: 'orders/user/' + this.$store.state.user.users_id,
        headers: {
          'Content-type': 'application/json'
        },
        data: this.orderContentFormatedData
      })
      .then(response => {
        this.clearBasket()
        this.$router.push('/order/' + response.data.orders_id)
        this.successToast(response.data.message)
        this.loading = false
      })
    }
  },
  components: {
    subtitle,
    orderContentCard,
    addressCard,
    paymentCard
  }
}
</script>

<style scoped>
.card {
  margin-bottom: 30px;
}
</style>
