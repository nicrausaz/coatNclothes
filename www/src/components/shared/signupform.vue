<template>
  <section class="section">
    <div class="card">
      <div class="card-content">
        <section>
        <b-field label="Nom d'utilisateur">
            <b-input v-model="infos.username" required></b-input>
        </b-field>
        <b-field label="Email">
          <b-input v-model="infos.email" placeholder="Email" type="email" required></b-input>
        </b-field>
        <b-field label="Mot de passe">
            <b-input type="password" v-model="infos.password" password-reveal required>
            </b-input>
        </b-field>
        <b-field label="Confirmer mot de passe">
            <b-input type="password" v-model="passwordConfirm" password-reveal required>
            </b-input>
        </b-field>
        <b-field label="Prénom">
            <b-input v-model="infos.fsname" required></b-input>
        </b-field>
        <b-field label="Nom">
            <b-input v-model="infos.name" required></b-input>
        </b-field>

        <b-field label="Genre">
            <b-input v-model="infos.gender" required></b-input>
        </b-field>
      <span>
        <a class="button is-primary">Créer le compte</a>
      </span>
        </section>
        {{infos}}
        {{passwordConfirm}}
        {{doublePasswordIsValid}}
      </div>
  </div>
  </section>
</template>

<script>
export default {
  data () {
    return {
      infos: {
        username: '',
        email: '',
        password: '',
        fsname: '',
        name: '',
        gender: ''
      },
      passwordConfirm: ''
    }
  },
  computed: {
    doublePasswordIsValid () {
      return this.infos.password === this.passwordConfirm
    }
  }
}
</script>

<style>

</style>
