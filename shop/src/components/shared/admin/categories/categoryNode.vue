<template>
<div>
  <li @mouseover="hovered = true" @mouseout="hovered = false">
    <a @click.stop="triggerOpen">
      <span>
        <b-icon icon="angle-right"></b-icon>
        {{ children.name }}
      </span>
      <span @click="editCategory" v-if="hovered"><b-icon class="is-primary" icon="edit" size="is-small"></b-icon></span>
    </a>
    <ul class="menu-list" v-if="isOpen">
      <categoryNode v-for="child in children.children" :key="child.id" :children="child" :parentId="child.id" @update="$emit('update')" @editing="emitAgain"></categoryNode>
      <li class="add" @click="addCategory"><a>+</a></li>
    </ul>
  </li>

</div>
</template>

<script>
export default {
  data () {
    return {
      isOpen: false,
      hovered: false
    }
  },
  name: 'categoryNode',
  props: ['children', 'parentId'],
  methods: {
    emitAgain (key, id) {
      this.$emit('editing', key, id)
    },
    triggerOpen () {
      this.isOpen = !this.isOpen
    },
    addCategory () {
      this.$emit('editing', 'isCreating', this.parentId)
    },
    editCategory () {
      this.triggerOpen()
      this.$emit('editing', 'isEditing', this.children.id)
      // this.$dialog.prompt({
      //   message: 'Éditer la catégorie',
      //   cancelText: this.$store.state.interface.cancel,
      //   confirmText: this.$store.state.interface.confirm,
      //   inputAttrs: {
      //     placeholder: this.$store.state.interface.name
      //   },
      //   onConfirm: (value) => {
      //     this.axios({
      //       method: 'patch',
      //       url: '/admin/category/' + this.children.id,
      //       data: {
      //         category_lang: this.$store.state.language,
      //         category_name: value
      //       }
      //     })
      //     .then(response => {
      //       this.$emit('update')
      //       this.$toast.open({
      //         message: response.data.message,
      //         type: 'is-success'
      //       })
      //     })
      //   }
      // })
    }
  }
}
</script>
