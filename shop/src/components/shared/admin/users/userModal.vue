<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editUser}}</p>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.username">
        <b-input v-model="userData.users_login" icon="user" :placeholder="$store.state.interface.username" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.email">
        <b-input v-model="userData.users_email" icon="at" :placeholder="$store.state.interface.email" type="email" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.fsname">
        <b-input v-model="userData.users_fsname" icon="address-card" :placeholder="$store.state.interface.fsname" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.name">
        <b-input v-model="userData.users_name" icon="address-card" :placeholder="$store.state.interface.name" required></b-input>
      </b-field>
      <b-field>
        <b-checkbox v-model="userData.users_admin">{{$store.state.interface.admin}}</b-checkbox>
        {{userData.users_admin}}
        necessaire ?
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="updateUser">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data () {
    return {
      userData: {}
    }
  },
  created () {
    this.getUser()
  },
  methods: {
    getUser () {
      this.axios({
        method: 'get',
        url: '/admin/user/' + this.id
      })
      .then(response => {
        this.userData = response.data
      })
    },
    updateUser () {
      this.axios({
        method: 'patch',
        url: '/admin/user/' + this.id,
        data: this.userData
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$parent.close()
        this.$emit('update')
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
