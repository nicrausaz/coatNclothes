<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Info & édition de commande</p>
    </header>
    <section class="modal-card-body">
      Contenu
      
      dates
      
      status
      {{orderData}}
      <!-- <b-table :data="orders" :per-page="filter.perPage" default-sort="orders_id" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="orders_id" label="No" width="40" sortable numeric>
          {{ props.row.orders_id }}
        </b-table-column>
      </template>
    </b-table> -->
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="updateOrder">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data () {
    return {
      orderData: {}
    }
  },
  created () {
    this.getOrder()
  },
  methods: {
    getOrder () {
      this.axios({
        method: 'get',
        url: '/admin/order/' + this.id
      })
      .then(response => {
        this.orderData = response.data
      })
    },
    updateOrder () {}
  }
}
</script>
