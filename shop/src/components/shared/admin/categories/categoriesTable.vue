<template>
  <section>
    <h2 class="subtitle">
      Éditer les catégories
    </h2>
    <hr>
    <b-field grouped group-multiline>
      <b-select v-model="filter.perPage">
        <option value="5">5 par page</option>
        <option value="10">10 par page</option>
        <option value="20">20 par page</option>
      </b-select>
      <b-input placeholder="Rechercher..." type="search" icon-pack="fas" icon="search" v-model="searchContent"></b-input>
      <a class="button is-primary is-pulled-right" @click="createCategory">
          <b-icon icon="plus"></b-icon>
          <span>Nouvelle catégorie</span>
        </a>
    </b-field>
    TODO: CHANGE THIS VIEW
    <b-table :data="filteredCategories" :per-page="filter.perPage" :paginated="true" :pagination-simple="true" default-sort="category_id" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="category_id" label="No" width="60" sortable numeric>
          {{ props.row.category_id }}
        </b-table-column>
        <b-table-column field="category_name" label="Nom" sortable>
          {{ props.row.category_name }}
        </b-table-column>

        <b-table-column label="Actions" centered>
          <b-tooltip label="Détails et édition" position="is-left">
            <a @click="editCategory(props.row.category_id)">
              <span class="icon is-small">
                <b-icon icon="edit"></b-icon>
              </span>
            </a>
          </b-tooltip>
        </b-table-column>
      </template>
    </b-table>
    <b-modal :active.sync="isEditing" has-modal-card>
      <categoryEditModal :id="categoryId" @update="getCategories"></categoryEditModal>
    </b-modal>
    <b-modal :active.sync="isCreating" has-modal-card>
      <categoryNewModal @create="getCategories"></categoryNewModal>
    </b-modal>
  </section>
</template>

<script>
import categoryEditModal from '@/components/shared/admin/categories/categoryEditModal'
import categoryNewModal from '@/components/shared/admin/categories/categoryNewModal'

export default {
  data () {
    return {
      filter: {
        perPage: 20
      },
      searchContent: '',
      isEditing: false,
      isCreating: false,
      categories: [],
      categoryId: null
    }
  },
  created () {
    this.getCategories()
  },
  computed: {
    filteredCategories () {
      let results = []
      this.categories.forEach(category => {
        if (!category.category_name.toLowerCase().indexOf(this.searchContent.toLowerCase())) {
          results.push(category)
        }
      })
      return results
    }
  },
  methods: {
    getCategories () {
      this.axios({
        method: 'get',
        url: '/categories/list'
      })
      .then(response => {
        this.categories = response.data
      })
    },
    editCategory (categoryId) {
      this.categoryId = categoryId
      this.isEditing = true
    },
    createCategory () { this.isCreating = true }
  },
  components: {
    categoryEditModal,
    categoryNewModal
  }
}
</script>
