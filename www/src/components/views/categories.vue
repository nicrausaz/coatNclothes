<template>
<div class="container">
  <subtitle :name="'Catégories'" :text="''"></subtitle>

  <div class="columns">
    <div class="column is-one-quarter">
      <sidebar></sidebar>
    </div>
    <div>
        <div id="filtersDiv" class="columns">
          <div class="column is-three-fifths">
            <div class="field">
              <b-field label="Prix">
                <vueSlider v-model="search.price" :formatter="sliderConfig.formatter" :bgStyle="sliderConfig.bgStyle" :processStyle="sliderConfig.processStyle" :tooltipStyle="sliderConfig.tooltipStyle" :tooltip="'hover'"></vueSlider>
              </b-field>
            </div>
          </div>
          <div class="column is-three-fifths">
            <div class="field">
              <b-field label="Sexe">
                <b-checkbox size="is-small" native-value="H" v-model="search.genders">H</b-checkbox>
                <b-checkbox size="is-small" native-value="F" v-model="search.genders">F</b-checkbox>
              </b-field>
            </div>
          </div>
          <div class="column is-three-fifths">
            <b-field label="Marque">
              <b-select placeholder="Choisir des marques">
                <!-- <option v-for="option in data" :value="option.id"
                  :key="option.id">
                  {{ option.user.first_name }}
                </option> -->
              </b-select>
            </b-field>
          </div>
        </div>
        {{search}}
    </div>
  </div>
</div>
</template>

<script>
import vueSlider from 'vue-slider-component'
import subtitle from '@/components/templates/subtitle'
import sidebar from '@/components/templates/sidebar'

export default {
  data () {
    return {
      categories: [],
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
        price: [0, 100],
        genders: []
      }
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/categories'
    })
    .then((response) => {
      this.categories = response.data
    })
  },
  components: {
    subtitle,
    sidebar,
    vueSlider
  }
}
</script>

<style scoped>
#filtersDiv {
  margin-top: 20px;
}
</style>
