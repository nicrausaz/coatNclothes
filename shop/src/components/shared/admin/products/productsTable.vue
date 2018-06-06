<template>
  <section>
    <h2 class="subtitle">
      {{$store.state.interface.editProducts}}
    </h2>
    <hr>
    <b-field grouped group-multiline>
      <b-select v-model="filter.perPage">
        <option value="5">5 {{$store.state.interface.perPage}}</option>
        <option value="10">10 {{$store.state.interface.perPage}}</option>
        <option value="20">20 {{$store.state.interface.perPage}}</option>
        <option value="40">40 {{$store.state.interface.perPage}}</option>
      </b-select>
      <b-input :placeholder="$store.state.interface.searchProduct" type="search" icon-pack="fas" icon="search" v-model="searchContent"></b-input>
        <a class="button is-primary is-pulled-right" @click="createProduct">
          <b-icon icon="plus"></b-icon>
          <span>{{$store.state.interface.newProduct}}</span>
        </a>
    </b-field>
    <b-table :data="filteredProducts" :per-page="filter.perPage" :paginated="true" :pagination-simple="true" default-sort="products_id" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="products_id" :label="$store.state.interface.No" width="40" sortable numeric>
          {{ props.row.products_id }}
        </b-table-column>

        <b-table-column field="products_name" :label="$store.state.interface.product" sortable>
          {{ props.row.products_name }}
        </b-table-column>

        <b-table-column field="products_price" :label="$store.state.interface.price" sortable>
          {{ props.row.products_price }} CHF
        </b-table-column>

        <b-table-column :label="$store.state.interface.actions" centered>
          <a @click="editProduct(props.row.products_id)">
            <span class="icon is-small">
              <b-icon icon="edit"></b-icon>
            </span>
          </a>
        </b-table-column>
      </template>
    </b-table>
    <b-modal :active.sync="isEditing" has-modal-card>
      <productEditModal @update="getProducts" :id="productId"></productEditModal>
    </b-modal>
    <b-modal :active.sync="isCreating" has-modal-card>
      <newProductModal @create="getProducts"></newProductModal>
    </b-modal>
  </section>
</template>

<script>
import productEditModal from '@/components/shared/admin/products/editProductModal'
import newProductModal from '@/components/shared/admin/products/newProductModal'

export default {
  data () {
    return {
      filter: {
        perPage: 20
      },
      isEditing: false,
      isCreating: false,
      searchContent: '',
      products: [],
      productId: 0
    }
  },
  methods: {
    editProduct (id) {
      this.productId = id
      this.isEditing = true
    },
    getProducts () {
      this.axios({
        method: 'get',
        url: '/products'
      })
      .then((response) => {
        this.products = response.data
      })
    },
    createProduct () {
      this.isCreating = true
    }
  },
  computed: {
    filteredProducts () {
      let results = []
      this.products.forEach(product => {
        if (!product.products_name.toLowerCase().indexOf(this.searchContent.toLowerCase())) {
          results.push(product)
        }
      })
      return results
    }
  },
  created () {
    this.getProducts()
  },
  components: {
    productEditModal,
    newProductModal
  }
}
</script>

<style>

</style>
