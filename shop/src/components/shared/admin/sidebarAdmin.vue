<template>
  <aside class="menu">
    <p class="menu-label">
      Dashboard
    </p>
    <ul class="menu-list">
      <router-link to="/admin/dashboard" :class="{'is-active' : isActive('/admin/dashboard')}">{{$store.state.interface.summary}}</router-link>
    </ul>
    <p class="menu-label">{{$store.state.interface.administration}}</p>
    <ul class="menu-list">
      <router-link to="/admin/products" :class="{'is-active' : isActive('/admin/products')}">{{$store.state.interface.products}}</router-link>
    </ul>
    <ul class="menu-list">
      <router-link to="/admin/orders" :class="{'is-active' : isActive('/admin/orders')}">{{$store.state.interface.orders}}</router-link>
    </ul>
    <ul class="menu-list">
      <router-link to="/admin/users" :class="{'is-active' : isActive('/admin/users')}">{{$store.state.interface.users}}</router-link>
    </ul>
    <ul class="menu-list">
      <router-link to="/admin/categories" :class="{'is-active' : isActive('/admin/categories')}">{{$store.state.interface.categories}}</router-link>
    </ul>
  </aside>
</template>

<script>
export default {
  methods: {
    isActive (item) {
      return this.$route.fullPath === item
    }
  }
}
</script>
