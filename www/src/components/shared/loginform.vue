<template>
  <div class="card">
    <div class="card-content">
      <b-field label="Nom d'utilisateur ou email">
          <b-input v-model="credentials.username"></b-input>
      </b-field>
      <b-field label="Mot de passe">
          <b-input type="password" v-model="credentials.password" password-reveal>
          </b-input>
      </b-field>
      <footer class="card-footer">
        <p class="card-footer-item">
          <span>
            <a class="button is-primary">Connexion</a>
          </span>
        </p>
      </footer>
    </div>
    {{credentials}}
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
  }
}
</script>

<style>

</style>
