<template>
  <section class="section">
    <div class="card">
      <div class="card-content">
        <section>
        <b-field label="Nom d'utilisateur">
            <b-input v-model="infos.username" placeholder="Nom d'utilisateur" required></b-input>
        </b-field>
        <b-field label="Email">
          <b-input v-model="infos.email" placeholder="Email" type="email" required></b-input>
        </b-field>
        <b-field label="Mot de passe">
            <b-input type="password" v-model="infos.password" placeholder="Mot de passe" password-reveal required>
            </b-input>
        </b-field>
        <b-field label="Confirmer mot de passe">
            <b-input type="password" v-model="passwordConfirm" placeholder="Confirmer mot de passe" password-reveal required>
            </b-input>
        </b-field>
        <b-field label="Prénom">
            <b-input v-model="infos.fsname" placeholder="Prénom" required></b-input>
        </b-field>
        <b-field label="Nom">
            <b-input v-model="infos.name" placeholder="Nom" required></b-input>
        </b-field>

        <b-field grouped>
        <b-field>
          <b-field label="Adresse">
            <b-input v-model="infos.address" placeholder="Adresse"></b-input>
          </b-field>
        </b-field>
        <b-field label="NPA" expanded>
            <b-input v-model="infos.npa" placeholder="NPA"></b-input>
        </b-field>
        <b-field label="Localité" expanded>
            <b-input v-model="infos.locality" placeholder="Localité"></b-input>
        </b-field>
    </b-field>

        <b-field label="Genre">
            <b-input v-model="infos.gender" placeholder="Genre" required></b-input>
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
        address: '',
        npa: '',
        locality: '',
        gender: ''
      },
      passwordConfirm: ''
    }
  },
  computed: {
    doublePasswordIsValid () {
      return this.infos.password === this.passwordConfirm && this.infos.password !== ''
    }
  }
}
</script>

<style>

</style>
