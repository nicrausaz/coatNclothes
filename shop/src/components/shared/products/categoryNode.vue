<template>
  <ul @click.stop="isOpen = !isOpen">
    <router-link :class="{'is-active': isSelected(children.id)}" :to="/category/ + children.id"><b-icon :icon="getIcon()" size="is-small" v-if="children.children"></b-icon>{{children.name}}</router-link>
    <li v-if="isOpen">
      <categoryNode v-for="child in children.children" :key="child.id" :children="child"></categoryNode>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'categoryNode',
  props: ['children'],
  data () {
    return {
      isOpen: false
    }
  },
  methods: {
    isSelected (id) {
      return parseInt(this.$route.params.id) === id
    },
    getIcon () {
      return this.isOpen ? 'angle-down' : 'angle-right'
    }
  }
}
</script>
