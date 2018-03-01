<template>
  <div class="container">
    <subtitle :name="'Panier'" :text="'Voir votre panier d\'achats'"></subtitle>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
export default {
  data () {
    return {}
  },
  components: {
    subtitle
  }
}
</script>