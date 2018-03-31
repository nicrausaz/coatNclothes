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
      <div v-if="wishlists.length == 0">
        <p>Vous n'avez créé aucune liste de souhaits...</p>
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
  props: ['productId'],
  data () {
    return {
      wishlists: []
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
    choose (wishlistId) {
      this.$parent.close()
      this.axios({
        method: 'put',
        url: '/wishlist/' + wishlistId + '/user/' + this.$store.state.user.users_id + '/content',
        data: {
          product: this.productId
        }
      })
      .then((response) => {
        this.$toast.open(response.data.message)
      })
      .catch((err) => {
        this.$toast.open({
          duration: 2000,
          message: err.response.data.message,
          position: 'is-top',
          type: 'is-danger'
        })
      })
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
