<template>
  <div class="columns notification" @change="$emit('filter', search)">
    <div class="column is-3">
      <div class="field">
        <b-field label="Prix">
          <vueSlider v-model="search.price" :max="hightestPrice" :formatter="sliderConfig.formatter" :bgStyle="sliderConfig.bgStyle" :processStyle="sliderConfig.processStyle" :tooltipStyle="sliderConfig.tooltipStyle" :tooltip="'hover'"></vueSlider>
        </b-field>
      </div>
    </div>
    <div class="column is-4">
      <b-field label="Marques">
        <b-select placeholder="Choisir des marques" v-model="search.brands">
          <option v-for="brand in namedBrands" :value="brand" :key="brand">{{i}}</option>
        </b-select>
      </b-field>
    </div>
    <div class="column is-2">
      <b-field>
        <b-radio-button v-model="search.selectedView" native-value="cardedView">
          <i class="fa fa-th-large"></i>
        </b-radio-button>
        <b-radio-button v-model="search.selectedView" native-value="listedView">
          <i class="fa fa-list"></i>
        </b-radio-button>
      </b-field>
    </div>

  </div>
</template>

<script>
import vueSlider from 'vue-slider-component'

export default {
  props: ['brands', 'maxprice'],
  data () {
    return {
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
        price: [0, this.maxprice],
        brands: [],
        selectedView: 'cardedView'
      },
      namedBrands: []
    }
  },
  created () {
    this.$emit('filter', this.search)
    this.getBrandsNames()
  },
  methods: {
    getBrandsNames () {
      // get this.brands names from ids
    }
  },
  computed: {
    hightestPrice () {
      console.log(this.maxprice)
      return this.maxprice > 0 ? this.maxprice : 100
    }
  },
  components: {
    vueSlider
  }
}
</script>
