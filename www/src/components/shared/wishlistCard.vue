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
            <wishllistArticlelist :articles="infos.articles"></wishllistArticlelist>
          </div>
      </div>
      <footer class="card-footer">
          <a class="card-footer-item">Supprimer tout</a>
          <a class="card-footer-item">Ajouter tout au panier</a>
      </footer>
    </b-collapse>
</template>

<script>
import wishllistArticlelist from '@/components/shared/wishllistArticlelist'
export default {
  props: ['infos'],
  data () {
    return {
      isOpen: true
    }
  },
  components: {
    wishllistArticlelist
  }
}
</script>

<style>

</style>
