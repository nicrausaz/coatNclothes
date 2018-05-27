<template>
<div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Choisir la liste</p>
    </header>
    <section class="modal-card-body" v-if="!isCreatingNew">
      <div v-for="wishlist in wishlists" class="choices" :key="wishlist.wishlist_id" @click="choose(wishlist.wishlist_id)">
        {{wishlist.wishlist_name}}
        <span class="actions"><b-icon icon="plus" type="is-primary"></b-icon></span>
      </div>
      <div v-if="wishlists.length == 0">
        <p>{{$store.state.interface.noWishlist}}</p>
      </div>
      <hr>
      <div class="choices" @click="createNew">
        {{$store.state.interface.CreateNewWishlist}}
      </div>
    </section>
    <section class="modal-card-body" v-else>
       <b-field :label="$store.state.interface.name">
        <b-input type="text" v-model="newWishlist.name" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.description">
        <b-input type="textarea" v-model="newWishlist.description" maxlength="100"></b-input>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" type="button" v-if="isCreatingNew" @click="createAndAdd">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['productId'],
  data () {
    return {
      wishlists: [],
      isCreatingNew: false,
      newWishlist: {
        name: '',
        description: ''
      }
    }
  },
  created () {
    if (this.$store.state.user.users_id) {
      this.getUserWishlists()
    } else {
      this.$toast.open({
        message: 'Connectez-vous ou créez un compte pour accéder à cette page!',
        type: 'is-warning'
      })
      this.$router.push('/user')
    }
  },
  methods: {
    getUserWishlists () {
      this.axios({
        method: 'get',
        url: 'wishlists/user/' + this.$store.state.user.users_id
      })
      .then((response) => {
        this.wishlists = response.data
      })
    },
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
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    },
    createAndAdd () {
      this.axios({
        method: 'put',
        url: 'wishlist/user/' + this.$store.state.user.users_id,
        data: {
          'name': this.newWishlist.name,
          'description': this.newWishlist.description
        }
      })
      .then((response) => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.choose(response.data.wishlist_id)
      })
    },
    createNew () { this.isCreatingNew = true }
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
