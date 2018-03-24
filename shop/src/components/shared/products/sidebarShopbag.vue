<template>
  <aside class="menu">
  <p class="menu-label">Résumé du panier</p>
  <ul class="menu-list">
    <li v-for="i in 5" :key="i">
      <a>
        <b-icon icon="times" size="is-small"></b-icon>
        <span class="has-text-centered">Produit {{i}}</span>
      </a>
    </li>
  </ul>
  <p class="menu-label has-text-right">Total - CHF</p>
  <button class="button is-primary is-large">Commander</button>
</aside>
</template>

<script>
export default {
  props: ['products'],
  data () {
    return {
      productsData: []
    }
  },
  computed: {}
}
</script>
