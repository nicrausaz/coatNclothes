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
import wishlistCard from '@/components/shared/wishlistCard'
export default {
  data () {
    return {
      wishlists: [
        {
          id: 0,
          name: 'Liste 1',
          description: 'description liste 1',
          articles: [
            {
              id: 0, name: 'test', description: 'sdgs', price: 30
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
          articles: [
            {
              id: 0, name: 'yolo', description: 'starfoulah', price: 15
            },
            {
              id: 1, name: 'swag', description: 'urujfjpjp', price: 85
            }
          ]
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