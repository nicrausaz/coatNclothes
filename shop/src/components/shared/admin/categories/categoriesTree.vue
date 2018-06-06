<template>
  <div class="menu">
    <ul class="menu-list">
      <categoryNode :categories="categories" :children="category" :parentId="category.parent" v-for="category in categories" :key="category.id" @update="getCategories" @editing="openModal"></categoryNode>
      <li class="add" @click="openModal('isCreating', null, null)">
        <a>
          <small>
            <b-icon icon="plus" size="is-small"></b-icon>
            <i>{{this.$store.state.interface.new}}</i>
          </small>
        </a>
      </li>
    </ul>
    <b-modal :active.sync="isEditing" has-modal-card>
      <categoryEditModal :id="tempId" :parentId="parentId" @update="getCategories"></categoryEditModal>
    </b-modal>
    <b-modal :active.sync="isCreating" has-modal-card>
      <categoryNewModal :parentId="parentId" @update="getCategories"></categoryNewModal>
    </b-modal>
  </div>
</template>

<script>
import categoryNode from '@/components/shared/admin/categories/categoryNode'
import categoryEditModal from '@/components/shared/admin/categories/categoryEditModal'
import categoryNewModal from '@/components/shared/admin/categories/categoryNewModal'

export default {
  data () {
    return {
      categories: [],
      isEditing: false,
      isCreating: false,
      tempId: null,
      parentId: null
    }
  },
  created () {
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
    openModal (key, id, parentId) {
      this[key] = true
      this.tempId = id
      this.parentId = parentId
    }
  },
  components: {
    categoryNode,
    categoryEditModal,
    categoryNewModal
  }
}
</script>
