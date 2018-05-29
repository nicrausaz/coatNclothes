<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editYourAddress}}</p>
      <a class="button is-danger is-outlined is-pulled-right" @click.stop="deleteAdress()">
        <span>{{$store.state.interface.delete}}</span>
        <b-icon icon="trash" size="is-small"></b-icon>
      </a>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.address">
        <b-input v-model="newData.adresses_street"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.ZIP">
        <b-input v-model="newData.adresses_npa" max-length="6"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.locality">
        <b-input v-model="newData.adresses_locality"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.country">
        <b-input v-model="newData.adresses_state" required></b-input>
      </b-field>
      <b-field>
        <b-checkbox v-model="newData.adresses_main" size="is-small" true-value="1" false-value="0" :disabled="isMain">
          {{$store.state.interface.defaultAddress}}
        </b-checkbox>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="updateAdress">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['adress'],
  data () {
    return {
      newData: {}
    }
  },
  created () {
    this.newData = this.adress
  },
  computed: {
    isMain () {
      return this.newData.adresses_main === 1
    }
  },
  methods: {
    getData () {
      let data = {
        adresses_locality: this.newData.adresses_locality,
        adresses_npa: this.newData.adresses_npa,
        adresses_street: this.newData.adresses_street,
        adresses_state: this.newData.adresses_state
      }
      if (this.newData.adresses_main) {
        data.adresses_main = 1
      }
      return data
    },
    updateAdress () {
      this.axios({
        method: 'patch',
        url: '/user/' + this.$store.state.user.users_id + '/adresse/' + this.newData.adresses_id,
        data: this.getData()
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('update')
        this.$parent.close()
      })
      .catch(err => {
        let errors = JSON.parse(err.response.data.message)
        Object.keys(errors).forEach(key => {
          this.$toast.open({
            message: errors[key].toString(),
            type: 'is-danger'
          })
        })
      })
    },
    deleteAdress () {
      this.axios({
        method: 'delete',
        url: '/user/' + this.$store.state.user.users_id + '/adresse/' + this.newData.adresses_id
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('update')
        this.$parent.close()
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