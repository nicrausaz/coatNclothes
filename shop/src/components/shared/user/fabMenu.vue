<template>
  <fab
    :actions="fabConfig.actions"
    :position="fabConfig.position"
    :bg-color="fabConfig.bgColor"
    position-type="absolute"
    :z-index="1"
    main-icon="settings"
    :main-tooltip="this.$store.state.interface.actions"
    @infos="infos"
    @admin="admin"
    @orders="orders"
    @logoff="logoff">
  </fab>
</template>

<script>
import fab from 'vue-fab'
export default {
  props: ['isAdmin'],
  data () {
    return {
      fabConfig: {
        bgColor: '#da0f68',
        position: 'top-right',
        actions: [
          {
            name: 'infos',
            icon: 'mode_edit',
            tooltip: this.$store.state.interface.seeAndEditInformations
          },
          {
            name: 'orders',
            icon: 'shop_two',
            tooltip: this.$store.state.interface.orders
          },
          {
            name: 'admin',
            icon: 'lock_open',
            tooltip: this.$store.state.interface.administration
          },
          {
            name: 'logoff',
            icon: 'exit_to_app',
            tooltip: this.$store.state.interface.logout
          }
        ]
      }
    }
  },
  created () {
    if (!this.isAdmin) {
      this.fabConfig.actions = this.fabConfig.actions.filter((action) => {
        return action.name !== 'admin'
      })
    }
  },
  methods: {
    infos () {
      this.$emit('editInfos')
    },
    orders () {
      this.$router.push('/orders')
    },
    admin () {
      this.$router.push('/admin/dashboard')
    },
    logoff () {
      this.axios({
        method: 'patch',
        url: '/logout'
      })
      this.$store.commit('detroyUser')
      this.$toast.open({
        message: 'Déconnecté !',
        type: 'is-success'
      })
      this.$store.dispatch('getShopbagQuantity')
    }
  },
  components: {
    fab
  }
}
</script>
