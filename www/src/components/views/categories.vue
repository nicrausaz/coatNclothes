<template>
<div class="container">
  <subtitle :name="'Catégories'" :text="'Liste des catégories'"></subtitle>
  <section class="section">
    {{$route.params.id}}
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

<style>

</style>
