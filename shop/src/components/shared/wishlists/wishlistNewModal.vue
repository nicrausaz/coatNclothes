<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.newWishlist}}</p>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.name">
        <b-input type="text" v-model="name" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.description">
        <b-input type="textarea" v-model="description" maxlength="100"></b-input>
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
      name: '',
      description: ''
    }
  },
  methods: {
    create () {
      this.axios({
        method: 'put',
        url: 'wishlist/user/' + this.$store.state.user.users_id,
        data: {
          'name': this.name,
          'description': this.description
        }
      })
      .then(response => {
        this.$parent.close()
        this.successToast(response.data.message)
        this.$emit('new')
      })
      .catch(err => {
        this.dangerToast(err.response.data.message)
      })
    }
  }
}
</script>