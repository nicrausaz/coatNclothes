<template>
  <div>
    <pre>
      {{categories}}
    </pre>
  </div>
</template>

<script>
import VueDragTree from 'vue-drag-tree'
// import categoryNode from '@/components/shared/admin/categories/categoryNode'
export default {
  data () {
    return {
      categories: []
    }
  },
  created () {
    // this.getCategories()
  },
  methods: {
    getCategories () {
      this.axios({
        method: 'get',
        url: '/categories'
      })
      .then(response => {
        this.categories = response.data
        // this.formatCategories()
      })
    },
    formatCategories () {
      this.categories.forEach(category => {
        console.log(category)
        this.formatedCategories.push({
          'id': category.id,
          'text': category.name,
          'data': category.parent,
          'children': category.children,
          'state': {}
        })
      })
    }
  },
  components: {
    VueDragTree
  }
}
</script>

<style>

</style>
