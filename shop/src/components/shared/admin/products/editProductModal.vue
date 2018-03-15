<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier le produit</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom">
        <!-- <b-input type="text" v-model="editedName" required></b-input> -->
      </b-field>
      <b-field label="Description">
        <!-- <b-input type="textarea" v-model="editedDescription" maxlength="100"></b-input> -->
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="update">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
    }
  },
  created () {
    // get data api from id
  },
  methods: {
    update () {
      console.log('update product')
    }
  }
}
</script>
