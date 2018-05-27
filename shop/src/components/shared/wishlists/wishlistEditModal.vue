<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier la liste de souhait</p>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.name">
        <b-input type="text" v-model="editedName" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.description">
        <b-input type="textarea" v-model="editedDescription" maxlength="100"></b-input>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="update">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id', 'name', 'description'],
  data () {
    return {
      editedName: '',
      editedDescription: ''
    }
  },
  created () {
    this.editedName = this.name
    this.editedDescription = this.description
  },
  methods: {
    update () {
      this.axios({
        method: 'patch',
        url: 'wishlist/' + this.id + '/user/' + this.$store.state.user.users_id,
        data: {
          'name': this.editedName,
          'description': this.editedDescription
        }
      })
      .then((response) => {
        this.$parent.close()
        this.$toast.open(response.data.message)
        this.$emit('updateInfo')
      })
    }
  }
}
</script>
