<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Edition d'utilisateur</p>
    </header>
    <section class="modal-card-body">
      {{userData}}
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
      userData: {}
    }
  },
  created () {
    this.getUser()
  },
  methods: {
    getUser () {
      this.axios({
        method: 'get',
        url: '/admin/user/' + this.id
      })
      .then(response => {
        this.userData = response.data
      })
    },
    updateUser () {}
  }
}
</script>
