<template>
  <fab
    :actions="fabConfig.actions"
    :position="fabConfig.position"
    :bg-color="fabConfig.bgColor"
    position-type="absolute"
    :z-index="1"
    main-icon="settings"
    main-tooltip="Actions"
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
            tooltip: 'Éditer mes infos'
          },
          {
            name: 'orders',
            icon: 'shop_two',
            tooltip: 'Voir mes commandes'
          },
          {
            name: 'admin',
            icon: 'lock_open',
            tooltip: 'Administration'
          },
          {
            name: 'logoff',
            icon: 'exit_to_app',
            tooltip: 'Déconnexion'
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
      this.$store.commit('detroyUser')
      this.$toast.open({
        message: 'Déconnecté !',
        type: 'is-success'
      })
    }
  },
  components: {
    fab
  }
}
</script>
