<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Ajouter un produit</p>
    </header>
    Création du produit en anglais !
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
        <div class="field is-grouped">
          <b-select placeholder="Choisir une catégorie" v-model="newData.fk_category_id" expanded>
            <optgroup v-for="category in categories" :key="category.id" :label="category.name">
              <option v-for="cat in category.children" :key="cat.id" :value="cat.id" > {{ cat.name }} </option>
            </optgroup>
          </b-select>
        </div>
      </b-field>
      <b-field label="Marque">
        <div class="field is-grouped">
          <b-select placeholder="Choisir une marque" v-model="newData.fk_brand_id" expanded>
            <option v-for="brand in brands" :value="brand.brand_id" :key="brand.brand_id"> {{ brand.brand_name }} </option>
          </b-select>
          <button class="button is-primary" @click="addBrand">
            <b-icon icon="plus" size="is-small"></b-icon>
          </button>
        </div>
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
      </b-field>

      <b-field label="Images">
        <!-- upload button -->
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
      newData: {
        products_name: '',
        products_description: '',
        products_price: 0,
        fk_category_id: null,
        fk_brand_id: null,
        products_size: []
      },
      loaded: false
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
          products_name: this.newData.products_name,
          products_description: this.newData.products_description,
          products_category: this.newData.fk_category_id,
          products_price: this.newData.products_price,
          products_brand: this.newData.fk_brand_id,
          products_size: JSON.stringify(this.newData.products_size)
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
    },
    addBrand () {
      this.$dialog.prompt({
        message: `Nouvelle marque`,
        cancelText: 'Annuler',
        confirmText: 'Confirmer',
        onConfirm: (value) => {
          this.axios({
            method: 'put',
            url: '/admin/brand',
            data: {
              brand_name: value
            }
          })
          .then(response => {
            this.$toast.open({
              message: response.data.message,
              type: 'is-success'
            })
            this.getBrands()
          })
        }
      })
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
