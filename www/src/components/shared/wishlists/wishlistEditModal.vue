<template>
  <div class="card">
    <h1 class="title">Modifier la liste de souhait</h1>
    <div class="card-content">
      <form>
        <b-field label="Nom">
            <b-input v-model="editedName"></b-input>
        </b-field>
        <b-field label="Description">
            <b-input type="textarea" v-model="editedDescription"></b-input>
        </b-field>
        <div class="buttons">
          <a class="button" @click="this.$parent.close">Annuler</a>
          <a class="button is-primary" @click="update">Confirmer</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['name', 'description'],
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
      console.log('update wishlist')
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
