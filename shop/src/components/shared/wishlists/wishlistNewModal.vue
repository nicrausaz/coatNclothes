<template>
  <div class="card">
    <h1 class="title">Nouvelle liste de souhait</h1>
    <div class="card-content">
      <form>
        <b-field label="Nom">
            <b-input v-model="name"></b-input>
        </b-field>
        <b-field label="Description">
            <b-input type="textarea" v-model="description"></b-input>
        </b-field>
        <div class="buttons">
          <a class="button" @click="this.$parent.close">Annuler</a>
          <a class="button is-primary" @click="create">Confirmer</a>
        </div>
      </form>
    </div>
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

<style scoped>
.card {
  padding: 40px;
}
.buttons {
  float: right;
}
</style>
