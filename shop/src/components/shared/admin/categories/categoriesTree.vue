<template>
  <div class="menu">
    <ul class="menu-list">
<!-- <draggable :element="'ul'" :list="categories" class="dragArea">
			<li v-for="el in categories" :key="el.id">
         <p>{{el.name}}</p>
         <local-draggable v-if="el.children" :tasks="el.children" >
          </local-draggable>
        <categoryNode :children="category" :parentId="null" v-for="category in categories" :key="category.id" @update="getCategories" @editing="openModal"></categoryNode>
			  </li>
	</draggable> -->





      <draggable>
        <categoryNode :categories="categories" :children="category" :parentId="null" v-for="category in categories" :key="category.id" @update="getCategories" @editing="openModal"></categoryNode>
      </draggable>
    </ul>
    <b-modal :active.sync="isEditing" has-modal-card>
      <categoryEditModal :id="tempId" :parentId="parentId" @update="getCategories"></categoryEditModal>
    </b-modal>
    <b-modal :active.sync="isCreating" has-modal-card>
      <categoryNewModal :parentId="parentId" @update="getCategories"></categoryNewModal>
    </b-modal>
    <pre>{{categories}}</pre>
  </div>
</template>

<script>
import categoryNode from '@/components/shared/admin/categories/categoryNode'
import categoryEditModal from '@/components/shared/admin/categories/categoryEditModal'
import categoryNewModal from '@/components/shared/admin/categories/categoryNewModal'
import draggable from 'vuedraggable'

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
    categoryNewModal,
    draggable
  }
}
</script>
