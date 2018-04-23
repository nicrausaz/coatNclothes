<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Connexion</p>
    </header>
    <section class="modal-card-body">
      <form>
        <b-field label="Nom d'utilisateur ou email">
            <b-input v-model="credentials.users_login" placeholder="Nom d'utilisateur ou email" icon="user" required></b-input>
        </b-field>
        <b-field label="Mot de passe">
            <b-input type="password" v-model="credentials.users_pass" placeholder="Mot de passe" password-reveal icon="key" required>
            </b-input>
        </b-field>
      <router-link to="/user">Pas de compte ?</router-link>
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="connect">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      credentials: {
        users_login: '',
        users_pass: ''
      }
    }
  },
  methods: {
    connect (event) {
      event.preventDefault()
      this.axios({
        method: 'post',
        url: '/login',
        data: this.credentials
      })
      .then((response) => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        delete response.data.message
        delete response.data.status_code
        this.$store.commit('setUser', response.data)
        location.reload()
      })
      .catch(() => {
        this.$toast.open({
          message: 'Nom de compte, email ou mot passe erroné !',
          type: 'is-danger'
        })
      })
    }
  }
}
</script>
