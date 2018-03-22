<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <div class="card">
        <div class="card-content">
          <b-field label="Nom d'utilisateur ou email">
              <b-input v-model="credentials.users_login" placeholder="Nom d'utilisateur ou email" icon="user" required></b-input>
          </b-field>
          <b-field label="Mot de passe">
              <b-input type="password" v-model="credentials.users_pass" placeholder="Mot de passe" password-reveal icon="key" required>
              </b-input>
          </b-field>
          <div class="level-right">
            <button class="button is-primary" @click="connect">Connexion</button>
          </div>
        </div>
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
    connect () {
      let self = this
      this.axios({
        method: 'post',
        url: '/login',
        data: self.credentials
      })
      .then((response) => {
        this.$store.commit('setUser', response.data)
        this.$toast.open({
          duration: 3000,
          message: response.data.message,
          position: 'is-top',
          type: 'is-success'
        })
      })
      .catch((error) => {
        console.log(error)
        this.$toast.open({
          duration: 3000,
          message: 'Nom de compte, email ou mot passe erroné !',
          position: 'is-top',
          type: 'is-danger'
        })
      })
    }
  }
}
</script>
