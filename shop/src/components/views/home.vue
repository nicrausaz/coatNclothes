<template>
  <div class="container">
    <subtitle :name="'Accueil'" :text="'Page d\'accueil'"></subtitle>
    <section class="section" v-for="item in news" :key="item.title">
      <h1 class="title">{{item.title}}</h1>
      <h2 class="subtitle">{{item.content}}</h2>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
export default {
  data () {
    return {
      news: [
        {
          title: 'En construction',
          content: 'Le site Coat&Clothes est en construction !'
        },
        {
          title: 'Nouveautés',
          content: 'Découvrez nos dernières nouveautés !'
        }
      ]
    }
  },
  components: {
    subtitle
  }
}
</script>

<style>

</style>
