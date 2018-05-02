<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <div class="card">
        <form class="card-content">
          <b-field label="Nom d'utilisateur ou email">
            <b-input v-model="credentials.users_login" placeholder="Nom d'utilisateur ou email" icon="user" required></b-input>
          </b-field>
          <b-field label="Mot de passe">
            <b-input type="password" v-model="credentials.users_pass" placeholder="Mot de passe" password-reveal icon="key" required></b-input>
          </b-field>
          <div class="level-right">
            <button class="button is-primary" @click="connect">Connexion</button>
          </div>
        </form>
      </div>
    </div>
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
