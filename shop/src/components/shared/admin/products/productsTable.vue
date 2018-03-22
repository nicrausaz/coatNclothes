<template>
  <section>
    <h2 class="subtitle">
      Éditer les produits
    </h2>
    <hr>
    <b-field grouped group-multiline>
      <b-select v-model="filter.perPage">
        <option value="5">5 par page</option>       
        <option value="10">10 par page</option>
        <option value="20">20 par page</option>
      </b-select>
      <b-input placeholder="Rechercher..." type="search" icon-pack="fas" icon="search" v-model="searchContent"></b-input>
    </b-field>
    <b-table :data="filteredProducts" :per-page="filter.perPage" default-sort="products_id" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="products_id" label="No" width="40" sortable numeric>
          {{ props.row.products_id }}
        </b-table-column>

        <b-table-column field="products_name" label="Produit" sortable>
          {{ props.row.products_name }}
        </b-table-column>

        <b-table-column field="products_price" label="Prix" sortable>
          {{ props.row.products_price }} CHF
        </b-table-column>

        <b-table-column label="Actions" centered>
          <a @click="editProduct(props.row.products_id)">
            <span class="icon is-small">
              <b-icon icon="edit"></b-icon>
            </span>
          </a>
        </b-table-column>
      </template>
    </b-table>
    <b-modal :active.sync="isEditing" has-modal-card>
      <productEditModal :id="productId"></productEditModal>
    </b-modal>
  </section>
</template>

<script>
import productEditModal from '@/components/shared/admin/products/editProductModal'

export default {
  data () {
    return {
      filter: {
        perPage: 20
      },
      isEditing: false,
      searchContent: '',
      products: [],
      productId: 0
    }
  },
  methods: {
    editProduct (id) {
      this.productId = id
      this.isEditing = true
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
    this.axios({
      method: 'get',
      url: '/products'
    })
    .then((response) => {
      this.products = response.data
    })
  },
  components: {
    productEditModal
  }
}
</script>

<style>

</style>
