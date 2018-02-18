<template>
  <div>
      <div class="card">
        <h1 class="title">Choisir la liste</h1>
        <div class="card-content">
            <div v-for="wishlist in wishlists" class="choices" :key="wishlist.id">
              {{wishlist.name}}
              <a class="button is-primary is-rounded" @click="choose(wishlist.id)"><b-icon class="actions" icon="plus"></b-icon></a>
            </div>
            <hr>
            <div class="choices">
              Créer une nouvelle liste
            </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  props: ['active'],
  data () {
    return {
      wishlists: [
        { id: 1, name: 'liste1' },
        { id: 2, name: 'liste2' }
      ],
      chosenWishlist: ''
    }
  },
  methods: {
    choose (id) {
      console.log('add to wishlist' + id)
      this.$parent.close()
    }
  }
}
</script>

<style scoped>
.card {
  padding: 20px;
  width: 600px;
}
.choices {
  padding: 20px;
  margin-bottom: 10px;
  border: 1px solid lightgray;
}
.actions {
  float: right;
}
</style>
