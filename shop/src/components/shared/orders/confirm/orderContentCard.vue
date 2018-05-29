<template>
  <b-collapse class="card">
    <div class="card-header">
      <p class="card-header-title">{{$store.state.interface.products}}</p>
      <a class="card-header-icon">
        <b-icon :icon="isConfirmed ? 'check' : 'times'" :class="{'confirmed': isConfirmed}"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content columns is-multiline">
        <orderContentProduct v-for="product in basketproducts" :key="product.products_id" :data="product"></orderContentProduct>
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item" @click="valid">{{$store.state.interface.confirm}}</a>
    </footer>
  </b-collapse>
</template>

<script>
import orderContentProduct from '@/components/shared/orders/confirm/orderContentProduct'

export default {
  props: ['basketproducts'],
  data () {
    return {
      isConfirmed: false
    }
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
  color: #23d160;
}
</style>
