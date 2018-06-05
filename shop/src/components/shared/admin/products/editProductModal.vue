<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editProduct}}</p>
      <button class="button is-danger is-outlined" @click="deleteProduct">
        <span>{{$store.state.interface.delete}}</span>
        <b-icon icon="trash" size="is-small"></b-icon>
      </button>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.lang">
        <b-select :aria-placeholder="$store.state.interface.lang" v-model="newData.selectedLang" expanded>
          <option v-for="lang in languages" :key="lang" _:value="lang">{{lang}}</option>
        </b-select>
      </b-field>

      <b-field :label="$store.state.interface.name">
        <b-input v-model="newData.products_name"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.description">
        <b-input v-model="newData.products_description" maxlength="300" type="textarea"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.price">
        <b-input v-model="newData.products_price" type="number" step="1"></b-input>
      </b-field>
      <b-field :label="$store.state.interface.category">
        <div class="field">
          <Treeselect v-model="newData.fk_category_id" :placeholder="$store.state.interface.chooseCategory" :normalizer="normalizer" :options="categories"></Treeselect>
        </div>
      </b-field>
      <b-field :label="$store.state.interface.brand">
        <div class="field is-grouped">
          <b-select :placeholder="$store.state.interface.chooseBrand" v-model="newData.fk_brand_id" expanded>
            <option v-for="brand in brands" :value="brand.brand_id" :key="brand.brand_id"> {{ brand.brand_name }} </option>
          </b-select>
          <button class="button is-primary" @click="addBrand">
            <b-icon icon="plus" size="is-small"></b-icon>
          </button>
        </div>
      </b-field>
      <b-field :label="$store.state.interface.sizeAvailable">
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

      <b-field :label="$store.state.interface.pics">
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
              <p>{{$store.state.interface.clicAndDropFile}}</p>
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
      <button class="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="update">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  props: ['id'],
  data () {
    return {
      categories: [],
      brands: [],
      languages: [],
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
    this.getLanguages()
  },
  methods: {
    normalizer (node) {
      return {
        id: node.id,
        label: node.name,
        children: node.children
      }
    },
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
    getLanguages () {
      this.axios({
        method: 'get',
        url: '/lang/available'
      })
      .then(response => {
        this.languages = response.data.lang
      })
    },
    updateProductInfos () {
      this.axios({
        method: 'patch',
        url: '/admin/product/' + this.id,
        data: {
          products_lang: this.newData.selectedLang,
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
        message: this.$store.state.interface.newBrand,
        cancelText: this.$store.state.interface.cancel,
        confirmText: this.$store.state.interface.confirm,
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
  },
  components: {
    Treeselect
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