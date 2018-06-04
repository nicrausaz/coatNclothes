<template>
<div>
  <li @mouseover="hovered = true" @mouseout="hovered = false">
    <a @click.stop="triggerOpen">
      <span>
        <b-icon :icon="getIcon"></b-icon>
        {{ children.name }}
      </span>
      <span @click="editCategory" v-if="hovered"><b-icon icon="edit" size="is-small"></b-icon></span>
    </a>
    <ul class="menu-list" v-if="isOpen">
      <categoryNode v-for="child in children.children" :key="child.id" :children="child" :parentId="child.id" @update="$emit('update')" @editing="emitAgain"></categoryNode>
      <li class="add" @click="addCategory">
        <a>
          <b-icon icon="plus" size="is-small"></b-icon>
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
    }
  }
}
</script>
