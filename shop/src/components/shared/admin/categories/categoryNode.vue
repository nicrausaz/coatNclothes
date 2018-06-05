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
      <categoryNode v-for="child in children.children" :key="child.id" :children="child" :parentId="children.id" @update="$emit('update')" @editing="emitAgain"></categoryNode>
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
    emitAgain (key, id, parentId) {
      this.$emit('editing', key, id, parentId)
    },
    triggerOpen () {
      this.isOpen = !this.isOpen
    },
    addCategory () {
      this.$emit('editing', 'isCreating', null, this.parentId)
    },
    editCategory () {
      this.triggerOpen()
      this.$emit('editing', 'isEditing', this.children.id, this.parentId)
    }
  }
}
</script>
