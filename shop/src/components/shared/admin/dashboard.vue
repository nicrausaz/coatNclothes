<template>
  <div>
    <h2 class="subtitle">
      {{$store.state.interface.stats}}
    </h2>
    <hr>
    <div class="graphs">
      <p>{{$store.state.interface.orderStatus}}</p>
      <pie-chart :data="compactOrders"></pie-chart>
    </div>
    <div class="graphs">
      <!-- <p>Commandes par mois</p>
      <column-chart :data="monthlyOrdersData"></column-chart> -->
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      orders: [],
      globalOrdersData: [],
      monthlyOrdersData: [['Janvier', 4], ['Fevrier', 2], ['Mars', 10], ['Avril', 5], ['Mai', 3], ['Juin', 4], ['Juillet', 2], ['Août', 8], ['Septembre', 5], ['Octobre', 3], ['Novembre', 5], ['Decembre', 3]]
    }
  },
  created () { this.getOrders() },
  computed: {
    compactOrders () {
      let result = {}
      this.orders.forEach(obj => {
        for (var key in obj) {
          if (key === 'ordersStatus_name') {
            if (result[obj[key]]) {
              result[obj[key]] ++
            } else {
              result[obj[key]] = 1
            }
          }
        }
      })
      return Object.entries(result)
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
    }
  }
}
</script>

<style scoped>
.graphs {
  margin-bottom: 50px;
}
</style>
