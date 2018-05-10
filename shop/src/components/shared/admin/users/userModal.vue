<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Edition d'utilisateur</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom d'utilisateur">
        <b-input v-model="userData.users_login" icon="user" placeholder="Nom d'utilisateur" required></b-input>
      </b-field>
      <b-field label="Email">
        <b-input v-model="userData.users_email" icon="at" placeholder="Email" type="email" required></b-input>
      </b-field>
      <b-field label="Prénom">
        <b-input v-model="userData.users_fsname" icon="address-card" placeholder="Prénom" required></b-input>
      </b-field>
      <b-field label="Nom">
        <b-input v-model="userData.users_name" icon="address-card" placeholder="Nom" required></b-input>
      </b-field>
      <b-field>
        <b-checkbox v-model="userData.users_admin">Administrateur</b-checkbox>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="updateUser">Confirmer</button>
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
    updateUser () {
      this.axios({
        method: 'patch',
        url: '/admin/user/' + this.id,
        data: this.userData
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$parent.close()
        this.$emit('update')
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    }
  }
}
</script>
