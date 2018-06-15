<template>
  <div class="modal-card" @keyup.enter="updateUser">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editUser}}</p>
      <a class="button is-danger is-outlined is-pulled-right" @click.stop="deleteUser()">
        <span>{{$store.state.interface.delete}}</span>
        <b-icon icon="trash" size="is-small"></b-icon>
      </a>
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
        <b-checkbox v-model="userData.users_admin" :true-value="1" :false-value="0">{{$store.state.interface.admin}}</b-checkbox>
      </b-field>
      <b-field>
        <b-checkbox v-model="userData.users_enabled" :true-value="1" :false-value="0">{{$store.state.interface.enabled}}</b-checkbox>
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
      this.updateAdminStatut()
      this.changeUserActivation()
      this.axios({
        method: 'patch',
        url: '/admin/user/' + this.id,
        data: this.userData
      })
      .then(response => {
        this.successtToast(response.data.message)
        this.$parent.close()
        this.$emit('update')
      })
      .catch(err => { this.dangerToast(err.response.data.message) })
    },
    changeUserActivation () {
      this.axios({
        method: 'patch',
        url: 'admin/user/' + this.id + '/disable/' + this.userData.users_enabled
      })
    },
    deleteUser () {
      this.$dialog.confirm({
        title: this.$store.state.interface.delete,
        message: this.$store.state.interface.remUser,
        type: 'is-danger',
        hasIcon: true,
        icon: 'times-circle',
        confirmText: this.$store.state.interface.confirm,
        cancelText: this.$store.state.interface.cancel,
        onConfirm: () => {
          this.axios({
            method: 'delete',
            url: 'admin/user/' + this.id
          })
          .then(response => {
            this.defaultToast(response.data.message)
            this.$emit('update')
            this.$parent.close()
          })
        }
      })
    },
    updateAdminStatut () {
      this.axios({
        method: 'patch',
        url: '/admin/user/' + this.id + '/admin/' + this.userData.users_admin
      })
    }
  }
}
</script>
