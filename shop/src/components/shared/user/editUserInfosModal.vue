<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier vos informations</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom">
        <b-input v-model="newData.users_name"></b-input>
      </b-field>
      <b-field label="Prénom">
        <b-input v-model="newData.users_fsname"></b-input>
      </b-field>
      <b-field label="Nom de compte">
        <b-input v-model="newData.users_login"></b-input>
      </b-field>
      <b-field label="Email">
        <b-input v-model="newData.users_email"></b-input>
      </b-field>
      <p class="has-text-right">Changer de mot de passe ?</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      newData: []
    }
  },
  created () {
    this.newData = this.$store.state.user
  }
}
</script>