<template>
<div class="container">
  <section>
      <b-field>
        <b-radio-button v-model="radioButton"
            native-value="cardedView">
            <i class="fa fa-th-large"></i>
        </b-radio-button>
        <b-radio-button v-model="radioButton"
            native-value="listedView">
            <i class="fa fa-list"></i>
        </b-radio-button>
      </b-field>
  </section>
</div>
</template>

<script>
export default {
  data () {
    return {
      radioButton: 'cardedView'
    }
  }
}
</script>


<style>

</style>
