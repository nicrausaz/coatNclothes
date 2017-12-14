<template>
    <b-collapse class="card" :open.sync="isOpen">
      <div slot="trigger" class="card-header">
          <p class="card-header-title">{{ infos.name }}</p>
          <a class="card-header-icon">
              <b-icon :icon="isOpen ? 'menu-down' : 'menu-up'"></b-icon>
          </a>
      </div>
      <div class="card-content">
          <div class="content">
            Liste des articles
          </div>
      </div>
      <footer class="card-footer">
          <a class="card-footer-item">Supprimer tout</a>
          <a class="card-footer-item">Ajouter tout au panier</a>
      </footer>
    </b-collapse>
</template>

<script>
export default {
  props: ['infos']
}
</script>

<style>

</style>
