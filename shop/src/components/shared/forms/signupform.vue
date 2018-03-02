<template>
  <section class="section">
    <div class="card">
      <div class="card-content">
        <section>
        <b-field label="Nom d'utilisateur">
            <b-input v-model="infos.users_login" placeholder="Nom d'utilisateur" required></b-input>
        </b-field>
        <b-field label="Email">
          <b-input v-model="infos.users_email" placeholder="Email" type="email" required></b-input>
        </b-field>
        <b-field label="Mot de passe">
            <b-input type="password" v-model="infos.users_pass" placeholder="Mot de passe" password-reveal required>
            </b-input>
        </b-field>
        <b-field label="Confirmer mot de passe">
            <b-input type="password" v-model="passwordConfirm" placeholder="Confirmer mot de passe" password-reveal required>
            </b-input>
        </b-field>
        <b-field label="Prénom">
            <b-input v-model="infos.users_fsname" placeholder="Prénom" required></b-input>
        </b-field>
        <b-field label="Nom">
            <b-input v-model="infos.users_name" placeholder="Nom" required></b-input>
        </b-field>

        <!-- <b-field grouped>
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
    </b-field> -->

        <!-- <b-field label="Genre">
            <b-input v-model="infos.gender" placeholder="Genre" required></b-input>
        </b-field> -->
      <span>
        <a class="button is-primary" style="float: right" @click="createUser">Créer le compte</a>
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
        users_login: '',
        users_email: '',
        users_pass: '',
        users_name: '',
        users_fsname: ''
      },
      passwordConfirm: ''
    }
  },
  methods: {
    createUser () {
      let self = this
      this.axios({
        method: 'post',
        url: '/register',
        data: self.infos
      })
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
