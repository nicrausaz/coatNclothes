<template>
<div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Choisir la liste</p>
    </header>
    <section class="modal-card-body">
      <div v-for="wishlist in wishlists" class="choices" :key="wishlist.wishlist_id" @click="choose(wishlist.wishlist_id)">
        {{wishlist.wishlist_name}}
        <span class="actions"><b-icon icon="plus" type="is-primary"></b-icon></span>
      </div>
      <hr>
      <div class="choices" @click="createNew">
        Créer une nouvelle liste
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['active'],
  data () {
    return {
      wishlists: [],
      chosenWishlist: ''
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'wishlists/user/' + this.$store.state.user.users_id
    })
    .then((response) => {
      this.wishlists = response.data
    })
  },
  methods: {
    choose (id) {
      console.log('add to wishlist' + id)
      // API: add product-Id to wishlist_id
      this.$parent.close()
    },
    createNew () {
      this.$parent.close()
      this.$router.push('/wishlists')
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
  cursor: pointer;
}
.choices:hover {
  background-color: lightgray;
}
.actions {
  float: right;
}
</style>
