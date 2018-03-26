<template>
  <b-collapse class="card">
    <div class="card-header">
      <p class="card-header-title">Produits</p>
      <a class="card-header-icon">
        <b-icon :icon="isConfirmed ? 'check' : 'times'"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content">
        LISTE DES PRODUITS
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item" @click="valid">Confirmer</a>
    </footer>
  </b-collapse>
</template>

<script>
export default {
  data () {
    return {
      isConfirmed: false
    }
  },
  methods: {
    valid () {
      this.isConfirmed = true
      this.$emit('confirm', 'orderContent')
    }
  }
}
</script>

<style>

</style>
