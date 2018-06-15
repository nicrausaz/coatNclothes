<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editYourPic}}</p>
    </header>
    <section class="modal-card-body">
      <div class="columns">
      <img :src="img" class="image is-128x128" alt="userpic"/>
        <div class="column">
          <b-field>
            <b-upload v-model="files" accept="image/*">
              <a class="button is-primary">
                <b-icon icon="upload"></b-icon>
                <span>{{$store.state.interface.chooseaPic}}</span>
              </a>
            </b-upload>
            <div v-if="files && files.length">
              <span class="files-name">
                {{ files[0].name }}
              </span>
            </div>
          </b-field>
          <b-field>
            <a class="button is-danger is-outlined" @click="deletePic">
              <b-icon icon="trash-alt"></b-icon>
              <span>{{$store.state.interface.remPic}}</span>
            </a>
          </b-field>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="updatePic" :disabled="!canPost">{{$store.state.interface.confirm}}</button>
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
        this.successToast(response.data.message)
        this.$parent.close()
        this.$emit('edit')
      })
      .catch(err => {
        this.dangerToast(err.response.data.message)
      })
    },
    updatePic () {
      this.postPic()
    },
    postPic () {
      let formData = new FormData()
      formData.append('users_pic', this.files[0])
      this.axios({
        method: 'post',
        url: '/user/' + this.$store.state.user.users_id + '/pic',
        data: formData
      })
      .then(response => {
        this.successToast(response.data.message)
        this.$parent.close()
        this.$emit('edit')
      })
      .catch(err => { this.dangerToast(err.response.data.message) })
    }
  },
  computed: {
    canPost () { return this.files.length > 0 }
  }
}
</script>

<style scoped>
.modal-card {
  width: 500px;
}
</style>
