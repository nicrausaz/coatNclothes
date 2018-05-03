<template>
  <div class="container">
    <subtitle :name="'Accueil'" :text="'Page d\'accueil'"></subtitle>
    <section class="section">
      <h1 class="title">En construction</h1>
      <h2 class="subtitle">Le site Coat&Clothes est en construction !</h2>
    </section>
    <section class="section">
      <h1 class="title">Abonnez-vous</h1>
      <h2 class="subtitle">Abonnez-vous à notre flux RSS (Atom) pour être alerté des nouveautés !</h2>
       <a class="button is-primary" href="https://api.coatandclothes.shop/fr/feed/atom" target="_blank">
        <b-icon icon="rss"></b-icon>
        <span>Flux</span>
      </a>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
export default {
  components: {
    subtitle
  }
}
</script>
