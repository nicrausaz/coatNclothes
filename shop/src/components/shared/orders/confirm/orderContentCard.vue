<template>
  <b-collapse class="card">
    <div class="card-header">
      <p class="card-header-title">Produits</p>
      <a class="card-header-icon">
        <b-icon :icon="isConfirmed ? 'check' : 'times'" :class="{'confirmed': isConfirmed}"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content">
        <orderContentProduct v-for="product in basketproducts" :key="product.products_id" :data="product"></orderContentProduct>
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item" @click="valid">Confirmer</a>
    </footer>
  </b-collapse>
</template>

<script>
import orderContentProduct from '@/components/shared/orders/confirm/orderContentProduct'

export default {
  data () {
    return {
      isConfirmed: false,
      basketproducts: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'basket/user/' + this.$store.state.user.users_id
    })
    .then((response) => {
      this.basketproducts = response.data
    })
  },
  methods: {
    valid () {
      this.isConfirmed = true
      this.$emit('confirm', 'orderContent')
    }
  },
  components: {
    orderContentProduct
  }
}
</script>

<style scoped>
.confirmed {
  color: #7CCD7C;
}
</style>
