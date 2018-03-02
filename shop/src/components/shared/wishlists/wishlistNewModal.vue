<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Nouvelle liste de souhait</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom">
        <b-input type="text" v-model="name" required></b-input>
      </b-field>
      <b-field label="Description">
        <b-input type="textarea" v-model="description" maxlength="100"></b-input>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="create">Confirmer</button>
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
      console.log('create wishlist')
      // TO API
    }
  }
}
</script>