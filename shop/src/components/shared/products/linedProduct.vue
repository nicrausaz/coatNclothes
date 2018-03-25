<template>
<div class="card">
  <article class="media">
    <figure class="media-left" @click="isImageModalActive = true">
      <p class="image is-64x64">
        <img :src="picture" :alt="altName" draggable="false">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ infos.products_name }}</strong> <small>20 CHF</small>
          <br>
          Description
        </p>
      </div>
      <nav class="level is-mobile">
        <div class="media-right">
          <button class="button is-outlined is-small">
            <b-icon icon="info" size="is-small"></b-icon>
          </button>
          <button class="button is-outlined is-primary is-small" @click="addToBasket">
            <b-icon icon="shopping-cart" size="is-small"></b-icon>
          </button>
        </div>
      </nav>
    </div>
  </article>

  <b-modal :active.sync="isImageModalActive">
    <p class="image is-4by4">
      <img :src="picture">
    </p>
  </b-modal>
</div>
</template>

<script>
export default {
  props: ['infos'],
  data () {
    return {
      isImageModalActive: false
    }
  },
  computed: {
    picture () {
      return this.infos.productsPics_path === null ? 'static/noImgAvailable.png' : this.infos.productsPics_path
    },
    altName (altName) {
      return this.infos.productsPics_altName === null ? 'noimg' : this.infos.productsPics_altName
    }
  },
  methods: {
    addToBasket () {
      // add item to basket
      this.axios({
        method: 'put',
        url: '/basket/user/' + this.$store.state.user.users_id,
        data: {
          'product': this.infos.products_id,
          'quantity': 1
        }
      })
      .then((response) => {
        this.$toast.open({
          duration: 5000,
          message: response.data.message,
          position: 'is-top',
          type: 'is-success'
        })
      })
      .catch((err) => {
        this.$toast.open({
          duration: 5000,
          message: err.response.data.message,
          position: 'is-top',
          type: 'is-warning'
        })
      })
    }
  }
}
</script>

<style scoped>
.card {
  padding: 10px;
  margin-bottom: 10px;
}
.box:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.media-left {
  cursor: pointer;
}
</style>

