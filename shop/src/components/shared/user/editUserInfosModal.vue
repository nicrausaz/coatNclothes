<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editYourInformations}}</p>
    </header>
    <section class="modal-card-body" v-if="!editPassword">
      <b-field :label="$store.state.interface.name">
        <b-input v-model="newData.users_name"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.fsname">
        <b-input v-model="newData.users_fsname"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.username">
        <b-input v-model="newData.users_login"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.email">
        <b-input v-model="newData.users_email"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.gender">
        <div class="block">
          <b-radio v-for="gender in genders" :key="gender.gender_id" v-model="newData.fk_gender_id" :native-value="gender.gender_id">{{gender.gender_sex}}</b-radio>
        </div>
      </b-field>
      <a class="is-pulled-right" @click="editPassword = true">{{$store.state.interface.changePassword}}</a>
    </section>

    <section class="modal-card-body" v-else>
      <b-field :label="$store.state.interface.actualPass">
        <b-input type="password" v-model="newPassword.actual" :placeholder="$store.state.interface.actualPass" password-reveal icon="key" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.newPass">
        <b-input type="password" v-model="newPassword.new" :placeholder="$store.state.interface.newPass" password-reveal icon="key" required></b-input>
      </b-field>
      <a class="is-pulled-right" @click="editPassword = false">{{$store.state.interface.editYourInformations}} ?</a>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" v-if="!editPassword" @click="updateInfos">{{$store.state.interface.confirm}}</button>
      <button class="button is-primary" v-else @click="changePassword">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      newData: [],
      genders: [],
      newPassword: {
        actual: '',
        new: ''
      },
      editPassword: false
    }
  },
  created () {
    this.getUserInfos()
    this.getGenders()
  },
  methods: {
    updateInfos () {
      this.changeInfos()
      this.changeGender()
    },
    changeInfos () {
      this.axios({
        method: 'patch',
        url: '/user/' + this.newData.users_id,
        data: {
          'users_name': this.newData.users_name,
          'users_fsname': this.newData.users_fsname,
          'users_email': this.newData.users_email,
          'users_login': this.newData.users_login
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('edit')
        this.$parent.close()
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    },
    changePassword () {
      this.axios({
        method: 'post',
        url: '/user/' + this.newData.users_id + '/pass',
        data: {
          users_pass: this.newPassword.actual,
          users_newpass: this.newPassword.new
        }
      })
      .then(response => {
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
    },
    getGenders () {
      this.axios({
        method: 'get',
        url: '/genders/available'
      })
      .then(response => {
        this.genders = response.data
      })
    },
    changeGender () {
      this.axios({
        method: 'patch',
        url: '/user/' + this.newData.users_id + '/gender/' + this.newData.fk_gender_id
      })
    },
    getUserInfos () {
      this.axios({
        method: 'get',
        url: '/user/' + this.$store.state.user.users_id
      })
      .then(response => {
        this.newData = response.data
      })
    }
  }
}
</script>