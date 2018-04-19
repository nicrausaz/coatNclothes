<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier la liste de souhait</p>
    </header>
    <section class="modal-card-body">
      <form class="card-content">
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
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="update">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      editedName: '',
      editedDescription: ''
    }
  },
  created () {
  },
  methods: {
  }
}
</script>
