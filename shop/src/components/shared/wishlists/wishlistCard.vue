<template>
    <b-collapse class="card" :open.sync="isOpen">
      <div slot="trigger" class="card-header">
        <p class="card-header-title">{{ infos.wishlist_name }}</p>
        <a class="card-header-icon">
          <b-icon :icon="isOpen ? 'angle-up' : 'angle-down'"></b-icon>
        </a>
      </div>
      <div class="card-content">
        <div class="content">
          <i>{{ infos.wishlist_description }}</i>
          <hr>
          <wishllistproductlist :products="infos.ordersContent"></wishllistproductlist>
        </div>
      </div>
      <footer class="card-footer">
        <a class="card-footer-item" @click="deleteWishlist">Supprimer la liste<b-icon icon="trash-alt"></b-icon></a>
        <a class="card-footer-item" @click="edit">Modifier<b-icon icon="pencil-alt"></b-icon></a>
        <a class="card-footer-item" v-if="hasProducts">Tout ajouter au panier <b-icon icon="cart-plus"></b-icon></a>
      </footer>
      <b-modal :active.sync="isEditing" has-modal-card>
        <wishlist-edit-modal :name="infos.wishlist_name" :description="infos.wishlist_description"></wishlist-edit-modal>
      </b-modal>
    </b-collapse>
</template>

<script>
import wishllistproductlist from '@/components/shared/wishlists/wishlistProductlist'
import wishlistEditModal from '@/components/shared/wishlists/wishlistEditModal'

export default {
  props: ['infos'],
  data () {
    return {
      isOpen: false,
      isEditing: false
    }
  },
  methods: {
    edit () {
      this.isEditing = true
    },
    deleteWishlist () {
      this.$dialog.confirm({
        title: 'Supprimer la liste de souhait',
        message: 'Êtes-vous sûr de vouloir supprimer la liste de souhait <b>' + this.infos.wishlist_name + '</b> ?',
        type: 'is-danger',
        hasIcon: true,
        icon: 'times-circle',
        confirmText: 'Confirmer',
        cancelText: 'Annuler',
        onConfirm: () => {
          this.$toast.open('Suppression')
          // delete API
        }
      })
    },
    addItemToBasket () {},
    addListToBasket () {}
  },
  computed: {
    hasProducts () {
      return this.infos.ordersContent.length > 0
    }
  },
  components: {
    wishllistproductlist,
    wishlistEditModal
  }
}
</script>

<style scoped>
.card {
  margin-bottom: 10px;
}
</style>
