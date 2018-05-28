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
        <wishllistproductlist :id="infos.wishlist_id" :products="infos.ordersContent"></wishllistproductlist>
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item" @click="deleteWishlist">{{$store.state.interface.delete}}<b-icon icon="trash-alt"></b-icon></a>
      <a class="card-footer-item" @click="edit">{{$store.state.interface.editWishlist}}<b-icon icon="pencil-alt"></b-icon></a>
      <a class="card-footer-item" @click="addAllToBasket" v-if="hasProducts">{{$store.state.interface.addAllToBasket}}<b-icon icon="cart-plus"></b-icon></a>
    </footer>
    <b-modal :active.sync="isEditing" has-modal-card>
      <wishlist-edit-modal :id="infos.wishlist_id" :name="infos.wishlist_name" :description="infos.wishlist_description" @updateInfo="$emit('update')"></wishlist-edit-modal>
    </b-modal>
  </b-collapse>
</template>

<script>
import wishllistproductlist from '@/components/shared/wishlists/wishlistProductlist'
import wishlistEditModal from '@/components/shared/wishlists/wishlistEditModal'
import productshelpers from '@/mixins/productsHelpers'

export default {
  props: ['infos'],
  mixins: [productshelpers],
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
        title: this.$store.state.interface.delete,
        message: this.$store.state.interface.confirmDeleteWishlist + '?',
        type: 'is-danger',
        hasIcon: true,
        icon: 'times-circle',
        confirmText: this.$store.state.interface.confirm,
        cancelText: this.$store.state.interface.cancel,
        onConfirm: () => {
          this.axios({
            method: 'delete',
            url: 'wishlist/' + this.infos.wishlist_id + '/user/' + this.$store.state.user.users_id
          })
          .then((response) => {
            this.$toast.open(response.data.message)
            this.$emit('delete')
          })
        }
      })
    },
    addAllToBasket () {
      this.axios({
        method: 'put',
        url: '/wishlist/' + this.infos.wishlist_id + '/addToBasket'
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    }
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
