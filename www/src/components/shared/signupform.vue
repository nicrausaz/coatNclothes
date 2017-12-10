<template>
    <div class="card">
      <div class="card-content">
        <section>
        <b-field label="Nom d'utilisateur">
            <b-input v-model="infos.username"></b-input>
        </b-field>
        <b-field label="Email">
          <b-input v-model="infos.email" placeholder="Email" type="email"></b-input>
        </b-field>
        <b-field label="Mot de passe">
            <b-input type="password" v-model="infos.password" password-reveal>
            </b-input>
        </b-field>
        <b-field label="Confirmer mot de passe">
            <b-input type="password" v-model="passwordConfirm" password-reveal>
            </b-input>
        </b-field>
        <b-field label="Prénom">
            <b-input v-model="infos.fsname"></b-input>
        </b-field>
        <b-field label="Nom">
            <b-input v-model="infos.name"></b-input>
        </b-field>

        <b-field label="Genre">
            <b-input v-model="infos.gender"></b-input>
        </b-field>

        </section>
        {{infos}}
        {{passwordConfirm}}
        {{doublePasswordIsValid}}
      </div>
  <footer class="card-footer">
    <p class="card-footer-item">
      <span>
        <a class="button is-primary">Créer le compte</a>
      </span>
    </p>
  </footer>
  </div>
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
