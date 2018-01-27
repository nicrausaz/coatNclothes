<template>
  <div>
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
          </form>
      </div>
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
    console.log(this)
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
  padding: 20px;
}
</style>
