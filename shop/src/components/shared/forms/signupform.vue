<template>
 <div class="columns is-centered">
    <div class="column is-half">
      <div class="card">
        <div class="card-content">
          <section>
            <b-field label="Nom d'utilisateur">
                <b-input v-model="infos.users_login" icon="user" placeholder="Nom d'utilisateur" required></b-input>
            </b-field>
            <b-field label="Email">
              <b-input v-model="infos.users_email" icon="at" placeholder="Email" type="email" required></b-input>
            </b-field>
            <b-field label="Mot de passe">
                <b-input type="password" v-model="infos.users_pass" icon="key" placeholder="Mot de passe" password-reveal required>
                </b-input>
            </b-field>
            <b-field label="Confirmer mot de passe">
                <b-input type="password" v-model="passwordConfirm" icon="key" placeholder="Confirmer le mot de passe" password-reveal required>
                </b-input>
            </b-field>
            <b-field label="Prénom">
                <b-input v-model="infos.users_fsname" icon="address-card" placeholder="Prénom" required></b-input>
            </b-field>
            <b-field label="Nom">
                <b-input v-model="infos.users_name" icon="address-card" placeholder="Nom" required></b-input>
            </b-field>
            <div class="level-right">
              <button class="button is-primary" @click="createUser">Créer le compte</button>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
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
      passwordConfirm: '',
      errors: []
    }
  },
  methods: {
    doublePasswordIsValid () {
      return this.infos.users_pass === this.passwordConfirm && this.infos.users_pass !== ''
    },
    createUser () {
      if (this.doublePasswordIsValid()) {
        let self = this
        this.axios({
          method: 'post',
          url: '/register',
          data: self.infos
        })
        .then(response => {
          this.errors = response.data
          console.log('test')
          // console.log(response)
          // console.log(response.data.status_code)
          // if (response.data.status_code !== 201) {
          //   this.errors = response.data.errors
          // }
        })
        .catch(errors => {
          this.errors = errors.response.data.errors
          this.toastErrors()
        })
      } else {
        this.$toast.open({
          duration: 5000,
          message: 'Les mots de passe ne correspondent pas !',
          position: 'is-top',
          type: 'is-danger'
        })
      }
    },
    toastErrors () {
      let self = this
      let errors = Object.keys(this.errors).map(function (key) { return self.errors[key] })
      errors.forEach((error) => {
        self.$toast.open({
          duration: 5000,
          message: error,
          position: 'is-top',
          type: 'is-danger'
        })
      })
    }
  }
}
</script>
