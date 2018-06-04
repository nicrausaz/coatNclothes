<template>
  <section>
    <h2 class="subtitle">{{$store.state.interface.editCategory}}</h2>
    <hr>
    <categoriesTree></categoriesTree>
  </section>
</template>

<script>
import categoriesTree from '@/components/shared/admin/categories/categoriesTree'
import categoryEditModal from '@/components/shared/admin/categories/categoryEditModal'
import categoryNewModal from '@/components/shared/admin/categories/categoryNewModal'

export default {
  components: {
    categoryEditModal,
    categoryNewModal,
    categoriesTree
  }
}
</script>
