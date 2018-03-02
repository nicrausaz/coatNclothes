<template>
<section class="section is-mobile is-centered">
  <div class="card is-half is-narrow">
    <div class="card-content">
      <b-field label="Nom d'utilisateur ou email">
          <b-input v-model="credentials.username" required></b-input>
      </b-field>
      <b-field label="Mot de passe">
          <b-input type="password" v-model="credentials.password" password-reveal required>
          </b-input>
      </b-field>
      <span>
        <a class="button is-primary" @click="connect">Connexion</a>
      </span>
    </div>
  </div>
</section>
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

<style>

</style>
