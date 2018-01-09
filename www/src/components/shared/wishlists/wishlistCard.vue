<template>
    <b-collapse class="card" :open.sync="isOpen">
      <div slot="trigger" class="card-header">
          <p class="card-header-title">{{ infos.name }}</p>
          <a class="card-header-icon">
              <b-icon :icon="isOpen ? 'angle-up' : 'angle-down'"></b-icon>
          </a>
      </div>
      <div class="card-content">
          <div class="content">
            <i>{{ infos.description }}</i>
            <wishllistArticlelist :articles="infos.articles"></wishllistArticlelist>
          </div>
      </div>
    </b-collapse>
</template>

<script>
import wishllistArticlelist from '@/components/shared/wishlists/wishlistArticlelist'
export default {
  props: ['infos'],
  data () {
    return {
      isOpen: false
    }
  },
  components: {
    wishllistArticlelist
  }
}
</script>

<style scoped>
.card {
  margin-bottom: 10px;
}
</style>
