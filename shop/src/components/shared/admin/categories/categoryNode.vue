<template>
<div>
  <li @mouseover="hovered = true" @mouseout="hovered = false">
    <a @click.stop="triggerOpen">
      <span>
        <b-icon :icon="getIcon"></b-icon>
        {{ children.name }}
      </span>
      <span @click="editCategory" v-if="hovered"><b-icon icon="edit" size="is-small"></b-icon></span>
      <span @click="deleteCategory" v-if="hovered"><b-icon icon="trash" size="is-small"></b-icon></span>
    </a>
    <ul class="menu-list" v-if="isOpen">
      <categoryNode v-for="child in children.children" :key="child.id" :children="child" :parentId="child.id" @update="$emit('update')" @editing="emitAgain"></categoryNode>
      <li class="add" @click="addCategory">
        <a>
          <small>
            <b-icon icon="plus" size="is-small"></b-icon>
            <i>{{this.$store.state.interface.new}}</i>
          </small>
        </a>
      </li>
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
  computed: {
    getIcon () {
      return this.isOpen ? 'angle-down' : 'angle-right'
    }
  },
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
    },
    deleteCategory () {
      this.$dialog.confirm({
        title: this.$store.state.interface.delete,
        message: 'Attention! Toutes les sous-catégories et leurs produits seront également supprimés',
        type: 'is-danger',
        hasIcon: true,
        icon: 'times-circle',
        confirmText: this.$store.state.interface.confirm,
        cancelText: this.$store.state.interface.cancel,
        onConfirm: () => {
          // this.axios({
          //   method: 'delete',
          //   url: 'wishlist/' + this.infos.wishlist_id + '/user/' + this.$store.state.user.users_id
          // })
          // .then((response) => {
          //   this.$toast.open(response.data.message)
          //   this.$emit('delete')
          // })
        }
      })
    }
  }
}
</script>
