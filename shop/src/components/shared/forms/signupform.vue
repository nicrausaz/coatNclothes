<template>
 <div class="columns is-centered">
    <div class="column is-half">
      <div class="card">
        <form class="card-content">
            <b-field :label="$store.state.interface.username">
                <b-input v-model="infos.users_login" icon="user" :placeholder="$store.state.interface.username" required></b-input>
            </b-field>
            <b-field :label="$store.state.interface.email">
              <b-input v-model="infos.users_email" icon="at" :placeholder="$store.state.interface.email" type="email" required></b-input>
            </b-field>
            <b-field :label="$store.state.interface.password">
              <b-input type="password" v-model="infos.users_pass" icon="key" :placeholder="$store.state.interface.password" minlength="6" password-reveal required></b-input>
            </b-field>
            <b-field :label="$store.state.interface.fsname">
              <b-input v-model="infos.users_fsname" icon="address-card" :placeholder="$store.state.interface.fsname" required></b-input>
            </b-field>
            <b-field :label="$store.state.interface.name">
              <b-input v-model="infos.users_name" icon="address-card" :placeholder="$store.state.interface.name" required></b-input>
            </b-field>
            <div class="level-right">
              <button class="button is-primary" @click="createUser">{{$store.state.interface.signup}}</button>
            </div>
        </form>
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
      }
    }
  },
  methods: {
    createUser (event) {
      event.preventDefault()
      this.axios({
        method: 'post',
        url: '/register',
        data: this.infos
      })
      .then(response => {
        delete response.data.message
        delete response.data.status_code
        this.$store.commit('setUser', response.data)
        location.reload()
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
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
