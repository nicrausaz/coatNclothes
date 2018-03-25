<template>
  <b-collapse class="card">
    <div slot="trigger" slot-scope="props" class="card-header">
      <p class="card-header-title">Produits</p>
      <a class="card-header-icon">
        <b-icon :icon="isOpen ? 'angle-up' : 'angle-down'"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content">
        LISTE DES PRODUITS
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item">Confirmer</a>
    </footer>
  </b-collapse>
</template>

<script>
export default {
  data () {
    return {
      isOpen: true,
      isConfirmed: false
    }
  }
}
</script>

<style>

</style>
