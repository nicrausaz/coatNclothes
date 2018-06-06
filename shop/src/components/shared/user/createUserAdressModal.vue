<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.createAnAddress}}</p>
    </header>
    <section class="modal-card-body" @keyup.enter="create">
      <b-field :label="$store.state.interface.address">
        <b-input v-model="newData.adresses_street" :placeholder="$store.state.interface.address" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.ZIP">
        <b-input v-model="newData.adresses_npa" :placeholder="$store.state.interface.ZIP" max-length="6" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.locality">
        <b-input v-model="newData.adresses_locality" :placeholder="$store.state.interface.locality" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.country">
        <b-input v-model="newData.adresses_state" :placeholder="$store.state.interface.country" required></b-input>
      </b-field>
      <b-field>
        <b-checkbox v-model="newData.adresses_main" size="is-small" :checked="newData.adresses_main">
          {{$store.state.interface.defaultAddress}}
        </b-checkbox>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="create">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      newData: {}
    }
  },
  methods: {
    create () {
      this.axios({
        method: 'put',
        url: '/user/' + this.$store.state.user.users_id + '/adresses',
        data: {
          adresses_locality: this.newData.adresses_locality,
          adresses_npa: this.newData.adresses_npa,
          adresses_street: this.newData.adresses_street,
          adresses_main: this.newData.adresses_main,
          adresses_state: this.newData.adresses_state
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('new')
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