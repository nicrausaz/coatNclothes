<template>
  <div class="container">
    <section class="section" v-for="item in news" :key="item.title">
      <h1 class="title">{{item.title}}</h1>
      <h2 class="subtitle">{{item.content}}</h2>
    </section>
  </div>
</template>

<script>
export default {
  data () {
    return {
      news: [
        {
          title: 'Accueil',
          content: 'Le site Coat&Clothes est en construction !'
        },
        {
          title: 'Nouveautés',
          content: 'Découvrez nos dernières nouveautés !'
        }
      ]
    }
  }
}
</script>

<style>

</style>
