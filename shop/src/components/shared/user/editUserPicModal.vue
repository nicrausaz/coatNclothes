<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier votre photo</p>
    </header>
    <section class="modal-card-body">
      <div class="columns">
      <img :src="img" class="image is-128x128" />
        <div class="column">
          <b-field>
            <a class="button is-primary" @click="deletePic">
              <b-icon icon="trash-alt"></b-icon>
              <span>Supprimer la photo</span>
            </a>
          </b-field>
          <b-field>
            <b-upload v-model="files" accept="image/*">
              <a class="button is-primary">
                <b-icon icon="upload"></b-icon>
                <span>Choisir une photo</span>
              </a>
            </b-upload>
            <div v-if="files && files.length">
              <span class="files-name">
                {{ files[0].name }}
              </span>
            </div>
          </b-field>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="updatePic">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['img'],
  data () {
    return {
      files: []
    }
  },
  methods: {
    deletePic () {
      this.axios({
        method: 'delete',
        url: '/user/' + this.$store.state.user.users_id + '/pic'
      })
      .then(response => {
        this.$toast.open(response.data.message)
      })
    },
    updatePic () {
      // check if patch or post
      console.dir(this.files[0])
      this.postPic()
    },
    postPic () {
      this.axios({
        method: 'post',
        url: '/user/' + this.$store.state.user.users_id + '/pic',
        data: {
          users_pic: this.files[0]
        }
      })
    },
    update () {
      // update pic patch
    }
  }
}
</script>

<style scoped>
.modal-card {
  width: 500px;
}
</style>
