<template>
  <div class="container">
    <!-- <div class="columns">
    <div class="column is-two-fifths">
        <div class="column">
        <pictureCarousel></pictureCarousel>
      Article {{$route.params.id}}
    </div>
  </div> -->
    </div>
</template>

<script>
import pictureCarousel from '@/components/shared/pictureCarousel'
export default {
  data () {
    return {}
  },
  created () {
    // request via id $route.params.id
  },
  components: {
    pictureCarousel
  }
}
</script>