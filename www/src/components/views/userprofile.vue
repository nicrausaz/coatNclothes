<template>
  <div class="container">
    <subtitle :name="'Votre profil'" :text="'Consultez et modifiez vos informations'"></subtitle>
    <section class="section">
      <div class="columns">
        <div class="column is-one-quarter">
          <figure class="image">
            <img src="https://bulma.io/images/placeholders/128x128.png" alt="Image">
          </figure>
        </div>
        <div class="column">
          <h1 class="title">Nicolas Crausaz</h1>
          n.crausaz99@gmail.com

          Mon adresse:
          safiusoid
        </div>
        <!-- <div class="column">Other</div> -->
      </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
export default {
  data () {
    return {
      user: {
      }
    }
  },
  components: {
    subtitle
  }
}
</script>