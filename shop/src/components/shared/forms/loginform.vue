<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <div class="card">
        <div class="card-content">
          <b-field label="Nom d'utilisateur ou email">
              <b-input v-model="credentials.username" placeholder="Nom d'utilisateur ou email" icon="user" required></b-input>
          </b-field>
          <b-field label="Mot de passe">
              <b-input type="password" v-model="credentials.password" placeholder="Mot de passe" password-reveal icon="key" required>
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
        username: '',
        password: ''
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
    }
  }
}
</script>
