<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier le produit</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom">
         <b-input v-model="newData.products_name"></b-input>
      </b-field>
      <b-field label="Description">
         <b-input v-model="newData.products_description" maxlength="300" type="textarea"></b-input>
      </b-field>
      <b-field label="Prix">
        <b-input v-model="newData.products_price" type="number" step="1"></b-input>
      </b-field>
      <b-field label="Catégories">
        <b-taginput v-model="newData.products_categories" :data="filteredCategories" autocomplete :allowNew="true" field="category_name" icon="tag" placeholder="Choisir une catégorie" @typing="getFilteredCategories"></b-taginput>
      </b-field>
       <b-field label="Marque">
         <b-input v-model="newData.products_brand"></b-input>
         <!-- make this searchable -->
        </b-field>

      <b-field label="Tailles disponibles">
         <b-checkbox-button v-model="newData.products_size" native-value="S">
            <span>S</span>
          </b-checkbox-button>
          <b-checkbox-button v-model="newData.products_size" native-value="M">
            <span>M</span>
          </b-checkbox-button>
          <b-checkbox-button v-model="newData.products_size" native-value="L">
            <span>L</span>
          </b-checkbox-button>
          <b-checkbox-button v-model="newData.products_size" native-value="XL">
            <span>XL</span>
          </b-checkbox-button>
      </b-field>

      <b-field label="Images">
        <div v-if="hasPicture" class="columns is-multiline is-mobile">
          <figure class="image is-128x128 column" v-for="pic in newData.products_pictures" :key="pic.altName">
            <img :src="pic.path" draggable="false">
          </figure>
        </div>
        <div v-else>
          No pictures
        </div>
        <!-- upload button -->
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="update">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data () {
    return {
      categories: [
        { category_id: 2, category_name: 'Jeans' }
      ],
      brands: [
        { brand_id: 1, brand_name: 'Lewi\'s' }
      ],
      newData: {},
      filteredCategories: [],
      filteredBrands: [],
      loaded: false
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/product/' + this.id
    })
    .then((response) => {
      this.newData = response.data
      this.loaded = true
    })

    // this.axios({
    //   method: 'get',
    //   url: '/categories'
    // })
    // .then((response) => {
    //   console.log(response)
    // })

    // get brands
  },
  methods: {
    getFilteredCategories (text) {
      this.filteredCategories = this.categories.filter((option) => {
        return option.toString().toLowerCase().indexOf(text.toLowerCase()) >= 0
      })
    },
    getFilteredBrands (text) {
      this.filteredBrands = this.brands.filter((option) => {
        return option.toString().toLowerCase().indexOf(text.toLowerCase()) >= 0
      })
    },
    update () {
      console.log('update product')
    }
  },
  computed: {
    hasPicture () {
      if (this.loaded) {
        return this.newData.products_pictures.length > 0
      }
    }
  }
}
</script>
