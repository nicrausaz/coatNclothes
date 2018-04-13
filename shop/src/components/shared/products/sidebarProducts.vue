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
  methods: {
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
