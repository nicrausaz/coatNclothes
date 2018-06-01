<template>
  <section>
    <h2 class="subtitle">
      {{$store.state.interface.editCategory}}
    </h2>
    <hr>
    <categoriesTree></categoriesTree>
    <!-- <b-modal :active.sync="isEditing" has-modal-card>
      <categoryEditModal :id="categoryId" @update="getCategories"></categoryEditModal>
    </b-modal>
    <b-modal :active.sync="isCreating" has-modal-card>
      <categoryNewModal @create="getCategories"></categoryNewModal>
    </b-modal> -->
  </section>
</template>

<script>
import categoriesTree from '@/components/shared/admin/categories/categoriesTree'
import categoryEditModal from '@/components/shared/admin/categories/categoryEditModal'
import categoryNewModal from '@/components/shared/admin/categories/categoryNewModal'

export default {
  data () {
    return {
      isEditing: false,
      isCreating: false
    }
  },
  methods: {
    editCategory (categoryId) {
      // OBSOLETE
      this.categoryId = categoryId
      this.isEditing = true
    },
    createCategory () {
      // OBSOLETE
      this.isCreating = true
    }
  },
  components: {
    categoryEditModal,
    categoryNewModal,
    categoriesTree
  }
}
</script>
