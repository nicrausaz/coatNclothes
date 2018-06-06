<template>
  <div class="modal-card" @keyup.enter="createProduct">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.addProduct}}</p>
    </header>
    <section class="modal-card-body">
      <i>{{$store.state.interface.defaultCreationLanguage}}</i>
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
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="createProduct">{{$store.state.interface.confirm}}</button>
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
      newData: {
        products_name: '',
        products_description: '',
        products_price: 0,
        fk_category_id: null,
        fk_brand_id: null,
        products_size: []
      }
    }
  },
  created () {
    this.getBrands()
    this.getCategories()
  },
  methods: {
    normalizer (node) {
      return {
        id: node.id,
        label: node.name,
        children: node.children
      }
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
    }
  },
  components: {
    Treeselect
  }
}
</script>
