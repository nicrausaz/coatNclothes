<template>
<section class="section">
  <div class="card">
    <div class="card-content">
      <b-field label="Nom d'utilisateur ou email">
          <b-input v-model="credentials.username" required></b-input>
      </b-field>
      <b-field label="Mot de passe">
          <b-input type="password" v-model="credentials.password" password-reveal required>
          </b-input>
      </b-field>
      <span>
        <a class="button is-primary">Connexion</a>
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
  }
}
</script>

<style>

</style>
