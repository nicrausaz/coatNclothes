<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier le produit</p>
      <button class="button is-danger is-outlined" @click="deleteProduct">
        <span>Supprimer</span>
        <b-icon icon="trash" size="is-small"></b-icon>
      </button>
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
        <div v-if="hasPicture" style="display: flex;">
          <figure class="image is-128x128" v-for="pic in newData.products_pictures" :key="pic.altName">
            <button id="delete" class="delete" @click="deletePicture(pic.id)"></button>
            <img :src="pic.path" draggable="false">
          </figure>
        </div>
      </b-field>
      <b-field class="file">
        <b-upload v-model="newfiles" multiple drag-drop accept="image/*">
            <div class="content has-text-centered">
              <p><b-icon icon="upload" size="is-large"></b-icon></p>
              <p>Cliquer ou déposer des fichiers</p>
            </div>
        </b-upload>
        <div class="tags">
          <span v-for="(file, index) in newfiles" :key="index" class="tag is-primary">
            {{file.name}}
            <button class="delete is-small" type="button" @click="deleteFile(index)"></button>
          </span>
        </div>
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
      newfiles: [],
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
    updateProductInfos () {
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
    updateProductPictures () {
      if (this.newfiles.length > 0) {
        let formData = new FormData()
        this.newfiles.forEach(file => {
          console.log(file)
          formData.append('products_pic', file)
          formData.append('productsPics_altName', file.name.replace(/\.[^/.]+$/, ''))
          this.postPicture(formData)
        })
      }
    },
    postPicture (formData) {
      this.axios({
        method: 'post',
        url: '/admin/product/' + this.id + '/pic',
        data: formData
      })
      .then(response => {
        console.log(response.data)
        // toast
      })
    },
    update () {
      this.updateProductInfos()
      this.updateProductPictures()
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
    deleteProduct () {
      this.axios({
        method: 'delete',
        url: '/admin/product/' + this.id
      })
      .then(response => {
        this.$parent.close()
        this.$emit('update')
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
      })
    },
    deleteFile (index) { this.newfiles.splice(index, 1) },
    deletePicture (id) {
      this.axios({
        method: 'delete',
        url: '/admin/pic/' + id
      })
      .then(response => {
        this.newData.products_pictures = this.newData.products_pictures.filter(el => { return el.id !== id })
        this.$toast.open(response.data.message)
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

<style scoped>

#delete {
  position: absolute;
  margin-left: 10px;
  z-index: 1;
}
</style>