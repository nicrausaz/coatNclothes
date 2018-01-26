<template>
  <div class="container">
    <subtitle :name="'Listes de souhaits'" :text="'Voir vos listes de souhaits'"></subtitle>
    <section class="section">
    <wishlistCard v-for="wishlist in wishlists" :key="wishlist.id" :infos="wishlist"></wishlistCard>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import wishlistCard from '@/components/shared/wishlists/wishlistCard'
export default {
  data () {
    return {
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
              id: 1, name: 'testsada', description: 'asfdasd', price: 40
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
  components: {
    subtitle,
    wishlistCard
  }
}
</script>