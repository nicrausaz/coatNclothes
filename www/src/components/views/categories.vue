<template>
<div class="container">
  <sidemenu></sidemenu>
  <subtitle :name="'Catégories'" :text="'Liste des catégories'"></subtitle>
  <section class="section">
    {{$route.params.id}}
  </section>
</div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import sidemenu from '@/components/shared/sidemenu'
export default {
  components: {
    subtitle,
    sidemenu
  }
}
</script>

<style>

</style>
