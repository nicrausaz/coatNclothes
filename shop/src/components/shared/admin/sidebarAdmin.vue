<template>
  <aside class="menu">
    <p class="menu-label">
      Dashboard {{activeView}}
    </p>
    <ul class="menu-list">
      <router-link to="/admin/dashboard" :class="{'is-active' : isActive('/admin/dashboard')}">Résumé</router-link>
    </ul>
    <p class="menu-label">Administration</p>
    <ul class="menu-list">
      <router-link to="/admin/products" :class="{'is-active' : isActive('/admin/products')}">Produits</router-link>
    </ul>
    <ul class="menu-list">
      <router-link to="/admin/orders" :class="{'is-active' : isActive('/admin/orders')}">Commandes</router-link>
    </ul>
    <ul class="menu-list">
      <router-link to="/admin/users" :class="{'is-active' : isActive('/admin/users')}">Utilisateurs</router-link>
    </ul>
  </aside>
</template>

<script>
export default {
  data () {
    return {
      active: ''
    }
  },
  methods: {
    isActive (item) {
      return this.active === item
    }
  },
  computed: {
    activeView () {
      this.active = this.$route.fullPath
    }
  }
}
</script>

<style scoped>
.notification {
  margin-top: 10px;
}
</style>
