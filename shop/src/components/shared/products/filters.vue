<template>
  <div class="columns filters" @change="$emit('filter', search)">
    <div class="column is-3">
      <div class="field">
        <b-field :label="$store.state.interface.price">
          <!-- {{hightestPrice}} -->
          <vueSlider v-model="search.price" :max="300" :formatter="sliderConfig.formatter" :bgStyle="sliderConfig.bgStyle" :processStyle="sliderConfig.processStyle" :tooltipStyle="sliderConfig.tooltipStyle" :tooltip="'hover'"></vueSlider>
        </b-field>
      </div>
    </div>
    <div class="column is-7">
      <b style="color: #363636;">{{$store.state.interface.brands}}</b>
      <b-field class="has-addons">
        {{brandsNames}}
        <b-select :placeholder="$store.state.interface.chooseBrand" v-model="search.brands">
          <option v-for="brand in namedBrands" :value="brand.id" :key="brand.id">{{brand.name}}</option>
        </b-select>
        <b-tooltip :label="$store.state.interface.reset" position="is-right" v-if="search.brands">
          <button class="button" @click="resetBrands">
            <b-icon icon="times" size="is-small"></b-icon>
          </button>
        </b-tooltip>
      </b-field>
    </div>
    <div class="column is-4">
      <b style="color: #363636;">{{$store.state.interface.display}}</b>
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
        price: [0, 300],
        brands: null,
        selectedView: 'cardedView'
      },
      brandsId: [],
      namedBrands: []
    }
  },
  created () {
    this.$emit('filter', this.search)
    console.log(this.maxprice)
  },
  methods: {
    resetBrands () { this.search.brands = null }
  },
  computed: {
    hightestPrice () {
      // TODO: make this work
      // console.log(this.maxprice)
      return this.maxprice === 0 ? 300 : this.maxprice
    },
    brandsNames () {
      this.namedBrands = []
      this.brands.forEach(brand => {
        this.axios({
          method: 'get',
          url: '/brand/' + brand
        })
        .then(response => {
          this.namedBrands.push({id: brand, name: response.data.brand_name})
        })
      })
    }
  },
  components: {
    vueSlider
  }
}
</script>

<style scoped>
.filters {
  margin-top: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid #dbdbdb;
}
</style>
