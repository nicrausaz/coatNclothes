<template>
  <aside class="menu">
  <p class="menu-label">{{$store.state.interface.categories}}</p>
  <categoryNode :children="category" v-for="category in categories" :key="category.id" class="menu-list"></categoryNode>
</aside>
</template>

<script>
import categoryNode from '@/components/shared/products/categoryNode'
export default {
  data () {
    return {
      categories: [],
      allProducts: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/categories'
    })
    .then((response) => {
      this.categories = response.data
    })
  },
  methods: {
    isSelected (id) {
      return parseInt(this.$route.params.id) === id
    }
  },
  components: {
    categoryNode
  }
}
</script>

<style scoped>
.menu {
  margin-top: 30px;
}
</style>
