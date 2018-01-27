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
            <wishllistArticlelist :products="infos.products"></wishllistArticlelist>
          </div>
      </div>
      <footer class="card-footer">
        <a class="card-footer-item">Supprimer la liste <b-icon icon="trash-o"></b-icon></a>
        <a class="card-footer-item" @click="editName">Modifier le nom <b-icon icon="pencil"></b-icon></a>
        <a class="card-footer-item" @click="editDescription">Modifier la description <b-icon icon="pencil"></b-icon></a>
        <a class="card-footer-item" v-if="hasProducts">Tout ajouter au panier <b-icon icon="cart-plus"></b-icon></a>
      </footer>
    </b-collapse>
</template>

<script>
import wishllistArticlelist from '@/components/shared/wishlists/wishlistArticlelist'
// import wishlistEditModal from '@/components/shared/wishlists/wishlistEditModal'

export default {
  props: ['infos'],
  data () {
    return {
      isOpen: false
    }
  },
  methods: {
    editName () {
      this.$dialog.prompt({
        message: 'Modifier le nom de la liste de souhaits',
        inputAttrs: [
          {
            placeholder: this.infos.name,
            maxlength: 30
          }
        ],
        cancelText: 'Annuler',
        confirmText: 'Modifier'
        // onConfirm: (value) => this.$toast.open(`Your name is: ${value}`)
      })
    },
    editDescription () {},
    delete () {},
    addItemToBasket () {},
    addListToBasket () {}
  },
  computed: {
    hasProducts () {
      return this.infos.products.length > 0
    }
  },
  components: {
    wishllistArticlelist
    // wishlistEditModal
  }
}
</script>

<style scoped>
.card {
  margin-bottom: 10px;
}
</style>
