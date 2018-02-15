<template>
  <div class="container">
  <subtitle :name="'products'" :text="'Liste des products'"></subtitle>
    <section class="section">
      <div id="filters">
        <b-field>
          <b-radio-button v-model="selectedView" native-value="cardedView">
              <i class="fa fa-th-large"></i>
          </b-radio-button>
          <b-radio-button v-model="selectedView" native-value="listedView">
              <i class="fa fa-list"></i>
          </b-radio-button>
        </b-field>
        <hr>
      </div>
        <div id="cardedproducts" class="columns is-multiline" v-if="isCardedView">
          <cardedproduct v-for="product in products_list" :key="product.product_id" :infos="product"></cardedproduct>
        </div>
        <div id="linedproducts" v-else>
          <lined-product v-for="product in products_list" :key="product.product_id" :infos="product"></lined-product>
        </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import cardedproduct from '@/components/shared/products/cardedproduct'
import linedproduct from '@/components/shared/products/linedproduct'
export default {
  data () {
    return {
      selectedView: 'cardedView',
      products_list: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/products'
    })
    .then((response) => {
      this.products_list = response.data
    })
  },
  computed: {
    isCardedView () {
      return this.selectedView === 'cardedView'
    }
  },
  components: {
    subtitle,
    cardedproduct,
    linedproduct
  }
}
</script>
