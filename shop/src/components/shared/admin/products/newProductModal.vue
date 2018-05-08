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
      <b-field label="Catégorie">
        <b-select placeholder="Choisir une catégorie" v-model="newData.fk_category_id" expanded>
          <option v-for="category in categories" :value="category.id" :key="category.id"> {{ category.name }} </option>
        </b-select>
      </b-field>
      <b-field label="Marque">
        <b-select placeholder="Choisir une marque" v-model="newData.products_brand" expanded>
          <option v-for="brand in brands" :value="brand.brand_id" :key="brand.brand_id"> {{ brand.brand_name }} </option>
        </b-select>
      </b-field>
      <b-field label="Tailles disponibles">
        <b-field>
          <b-checkbox-button v-model="newData.products_size" native-value="XS">
            <span>XS</span>
          </b-checkbox-button>
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
          <b-checkbox-button v-model="newData.products_size" native-value="XXL">
            <span>XXL</span>
          </b-checkbox-button>
        </b-field>
        {{newData.products_size}}
      </b-field>

      <b-field label="Images">
        <!-- upload button -->
        {{newData}}
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="createProduct">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data () {
    return {
      categories: [],
      brands: [],
      newData: {},
      loaded: false,
      selected: null
    }
  },
  created () {
    this.getBrands()
    this.getCategories()
  },
  methods: {
    getCategories () {
      this.axios({
        method: 'get',
        url: '/categories'
      })
      .then(response => {
        this.categories = response.data
      })
    },
    getBrands () {
      this.axios({
        method: 'get',
        url: '/brands'
      })
      .then(response => {
        this.brands = response.data
      })
    },
    createProduct () {
      this.axios({
        method: 'put',
        url: '/admin/product',
        data: {
          products_lang: 'fr',
          products_name: this.newData.products_name,
          products_description: this.newData.products_description,
          products_category: this.newData.fk_category_id, // category id
          products_price: this.newData.products_price,
          products_brand: this.newData.products_brand, // Brand id
          products_size: ['S'] // this.newData.products_size
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('create')
        this.$parent.close()
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    }
  },
  computed: {
    hasPicture () {
      if (this.loaded) {
        return this.newData.products_pictures.length > 0
      }
    },
    filteredBrands () {
      return this.brands.filter((option) => {
        return option.brand_id
          .toString()
          .toLowerCase()
          .indexOf(this.newData.products_brand.toLowerCase()) >= 0
      })
    }
  }
}
</script>
