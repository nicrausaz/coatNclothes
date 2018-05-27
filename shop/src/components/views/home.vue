<template>
  <div class="container">
    <subtitle :name="$store.state.interface.home" :text="''"></subtitle>
    <section class="section">
      <h1 class="title">{{$store.state.interface.subscribe}}</h1>
      <h2 class="subtitle">{{$store.state.interface.subcribeRSS}}</h2>
       <a class="button is-primary" :href="'https://api.coatandclothes.shop/' + this.$store.state.language + '/feed/atom'" target="_blank">
        <b-icon icon="rss"></b-icon>
        <span>RSS</span>
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
