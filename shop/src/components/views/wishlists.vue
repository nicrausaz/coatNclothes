<template>
  <div class="container">
    <subtitle :name="'Listes de souhaits'" :text="'Voir vos listes de souhaits'"></subtitle>
    <section class="section">
      <div class="card" id="newWLButton">
        <div class="card-content" @click="createNewWishlist">
          <strong>Créer une nouvelle liste</strong>
          <b-icon pack="fas" icon="plus" type="is-primary" style="float: right;"></b-icon>
        </div>
      </div>
    <wishlistCard v-for="wishlist in wishlists" :key="wishlist.id" :infos="wishlist"></wishlistCard>
    </section>
    <b-modal :active.sync="isCreating">
      <wishlistNewModal></wishlistNewModal>
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
      wishlists: [
        {
          id: 0,
          name: 'Liste 1',
          description: 'description liste 1',
          products: [
            {
              id: 0, name: 'test', description: 'sdgs', price: 30, img: 'http://dl.coatandclothes.shop:8090/Imports/F/lewisskinnyjeanstaillehaute1.jpg'
            },
            {
              id: 1, name: 'testsada', description: 'asfdasd', price: 40, img: 'http://dl.coatandclothes.shop:8090/Imports/F/lewisskinnyjeanstaillehaute2.jpg'
            }
          ]
        },
        {
          id: 1,
          name: 'Liste 2',
          description: '',
          products: [
            {
              id: 0, name: 'yolo', description: 'starfoulah', price: 15
            },
            {
              id: 1, name: 'swag', description: 'urujfjpjp', price: 85
            }
          ]
        },
        {
          id: 2,
          name: 'Liste 3',
          description: 'description liste 3',
          products: []
        }
      ]
    }
  },
  methods: {
    createNewWishlist () {
      this.isCreating = true
    }
  },
  created () {
    this.axios({
      headers: {'Authorization': 'Bearer' + this.$store.state.userToken},
      method: 'get',
      url: 'orders/user/18'
    })
    .then((response) => {
      console.log(response)
    })
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
