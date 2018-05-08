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
        <div class="field is-grouped">
          <b-select placeholder="Choisir une catégorie" v-model="newData.fk_category_id" expanded>
          <option v-for="category in categories" :value="category.id" :key="category.id"> {{ category.name }} </option>
        </b-select>
          <button class="button is-primary" @click="addCategory">
            <b-icon icon="plus" size="is-small"></b-icon>
          </button>
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
      categories: [],
      brands: [],
      newData: {},
      loaded: false,
      selected: null
    }
  },
  created () {
    this.getProduct()
    this.getBrands()
    this.getCategories()
  },
  methods: {
    getProduct () {
      this.axios({
        method: 'get',
        url: '/product/' + this.id
      })
      .then(response => {
        this.newData = response.data
        this.loaded = true
      })
    },
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
    update () {
      this.axios({
        method: 'patch',
        url: '/admin/product/' + this.id,
        data: {
          products_lang: 'fr',
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
        this.$emit('update')
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
    },
    addCategory () {
      this.$dialog.prompt({
        message: `Nouvelle catégorie`,
        cancelText: 'Annuler',
        confirmText: 'Confirmer',
        onConfirm: (value) => this.$toast.open(`Your name is: ${value}`)
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
