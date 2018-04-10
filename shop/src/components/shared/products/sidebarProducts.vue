<template>
  <aside class="menu">
  <p class="menu-label">
    Catégories
  </p>
  <ul class="menu-list">
    <li v-for="mainCategory in categories" :key="mainCategory.id">
      <router-link :class="{'is-active': isSelected(mainCategory.id)}" :to="/category/ + mainCategory.id">{{mainCategory.name}}</router-link>
      <ul>
        <li v-for="subCategory in mainCategory.children" :key="subCategory.id">
          <router-link :class="{'is-active': isSelected(subCategory.id)}" :to="/category/ + subCategory.id">{{subCategory.name}}</router-link>
          <ul>
            <li v-for="child in subCategory.children" :key="child.id">
              <router-link :class="{'is-active': isSelected(child.id)}" :to="/category/ + child.id">{{child.name}}</router-link>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</aside>
</template>

<script>
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
  watch: {
    $route () {
      this.getCategoryProducts(this.$route.params.id)
    }
  },
  methods: {
    getChildrenProducts (category) {
      if (category.children !== undefined && category.children.length > 0) {
        category.children.forEach((cat) => {
          this.getChildrenProducts(cat)
        })
      } else {
        this.getCategoryProducts(category.id)
      }
    },
    getCategoryProducts (id) {
      this.axios({
        method: 'get',
        url: '/category/' + id + '/products'
      })
      .then((response) => {
        if (response.data.length > 0) {
          this.allProducts.push(response.data)
          console.dir(this.allProducts)
          // this.$emit('products', this.allProducts)
        }
      })
    },
    isSelected (id) {
      return parseInt(this.$route.params.id) === id
    }
  }
}
</script>

<style scoped>
.menu {
  margin-top: 30px;
}
</style>
