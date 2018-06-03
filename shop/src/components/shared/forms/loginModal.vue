<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Connexion</p>
    </header>
    <section class="modal-card-body">
      <form>
        <b-field :label="$store.state.interface.usernameOrEmail">
            <b-input v-model="credentials.users_login" :placeholder="$store.state.interface.usernameOrEmail" icon="user" required></b-input>
        </b-field>
        <b-field :label="$store.state.interface.password">
            <b-input type="password" v-model="credentials.users_pass" :placeholder="$store.state.interface.password" password-reveal icon="key" required>
            </b-input>
        </b-field>
      <router-link to="/user" class="is-pulled-right">{{$store.state.interface.noAccountYet}}</router-link>
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="connect">{{$store.state.interface.connect}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      credentials: {
        users_login: '',
        users_pass: ''
      }
    }
  },
  methods: {
    connect (event) {
      event.preventDefault()
      this.axios({
        method: 'post',
        url: '/login',
        data: this.credentials
      })
      .then((response) => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        delete response.data.message
        delete response.data.status_code
        this.$store.commit('setUser', response.data)
        this.$store.commit('setTokenExpirationDate')
        location.reload()
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    }
  }
}
</script>
