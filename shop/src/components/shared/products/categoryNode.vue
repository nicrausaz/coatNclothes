<template>
    <ul>
      <li>
        <router-link :class="{'is-active': isSelected(children.id)}" :to="/category/ + children.id">{{children.name}}</router-link>
        <categoryNode v-for="child in children.children" :key="child.id" :children="child"></categoryNode>
      </li>
    </ul>
</template>

<script>
export default {
  name: 'categoryNode',
  props: ['children'],
  methods: {
    isSelected (id) {
      return parseInt(this.$route.params.id) === id
    }
  }
}
</script>
