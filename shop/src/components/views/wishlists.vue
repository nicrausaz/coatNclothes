<template>
  <div class="container">
    <subtitle :name="$store.state.interface.wishlists" :text="$store.state.interface.watchWishList"></subtitle>
    <section class="section">
      <div class="card" id="newWLButton">
        <div class="card-content" @click="createNewWishlist">
          <strong>{{$store.state.interface.CreateNewWishlist}}</strong>
          <b-icon pack="fas" icon="plus" type="is-primary" style="float: right;"></b-icon>
        </div>
      </div>
      <div v-if="hasWishLists">
        <wishlistCard v-for="wishlist in wishlists" :key="wishlist.wishlist_id" :infos="wishlist" @delete="getWishlists" @update="getWishlists"></wishlistCard>
      </div>
      <div class="has-text-centered subtitle is-3" style="margin-top: 150px;" v-else>
        <b-icon icon="inbox" size="is-large"></b-icon>
        <p>{{$store.state.interface.noWishlists}}</p>
      </div>
    </section>
    <b-modal :active.sync="isCreating">
      <wishlistNewModal @new="getWishlists"></wishlistNewModal>
    </b-modal>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import wishlistCard from '@/components/shared/wishlists/wishlistCard'
import wishlistNewModal from '@/components/shared/wishlists/wishlistNewModal'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
      isCreating: false,
      wishlists: []
    }
  },
  methods: {
    getWishlists () {
      this.axios({
        method: 'get',
        url: 'wishlists/user/' + this.$store.state.user.users_id + '/contents'
      })
      .then((response) => {
        this.wishlists = response.data
      })
    },
    createNewWishlist () {
      this.isCreating = true
    }
  },
  created () {
    this.getWishlists()
  },
  computed: {
    hasWishLists () {
      return this.wishlists.length > 0
    }
  },
  components: {
    subtitle,
    wishlistCard,
    wishlistNewModal
  }
}
</script>

<style scoped>
#newWLButton {
  margin-bottom: 50px;
  cursor: pointer;
}
</style>
