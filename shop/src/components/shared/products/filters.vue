<template>
  <div class="columns notification" style="border: 1px solid black;">
    <div class="column is-3">
      <div class="field">
        <b-field label="Prix">
          <vueSlider v-model="search.price" :max="hightestPrice" :formatter="sliderConfig.formatter" :bgStyle="sliderConfig.bgStyle" :processStyle="sliderConfig.processStyle" :tooltipStyle="sliderConfig.tooltipStyle" :tooltip="'hover'"></vueSlider>
        </b-field>
      </div>
    </div>
    <div class="column is-3">
        <b-field label="Sexe">
          <b-checkbox size="is-small" native-value="H" v-model="search.genders">H</b-checkbox>
          <b-checkbox size="is-small" native-value="F" v-model="search.genders">F</b-checkbox>
        </b-field>
    </div>
    <div class="column is-4">
      <b-field label="Marque">
        <b-select placeholder="Choisir des marques" v-model="search.brands">
          <option v-for="i in 4" :value="i" :key="i">
            {{ i }}
          </option>
        </b-select>
      </b-field>
    </div>
    <div class="column is-4">
      <b-field>
        <b-radio-button v-model="selectedView" native-value="cardedView">
          <i class="fa fa-th-large"></i>
        </b-radio-button>
        <b-radio-button v-model="selectedView" native-value="listedView">
          <i class="fa fa-list"></i>
        </b-radio-button>
      </b-field>
    </div>

  </div>
</template>

<script>
import vueSlider from 'vue-slider-component'

export default {
  data () {
    return {
      selectedView: 'cardedView',
      sliderConfig: {
        formatter: '{value} CHF',
        bgStyle: {
          'backgroundColor': '#fff',
          'boxShadow': 'inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)'
        },
        tooltipStyle: {
          'backgroundColor': '#666',
          'borderColor': '#666'
        },
        processStyle: {
          'backgroundColor': '#da0f68'
        }
      },
      search: {
        price: [0, 500],
        genders: [],
        brands: []
      }
    }
  },
  computed: {
    hightestPrice () {
      return 500
    }
  },
  components: {
    vueSlider
  }
}
</script>

<style>

</style>
