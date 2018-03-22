<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier votre photo</p>
    </header>
    <section class="modal-card-body">
      <img src="static/noImgAvailable.png" />
      <b-field>
        <a class="button is-primary">
          <b-icon icon="trash-alt"></b-icon>
          <span>Remove picture</span>
        </a>
      </b-field>
        <b-field>
          <b-upload v-model="files" accept="image/*">
            <a class="button is-primary">
              <b-icon icon="upload"></b-icon>
              <span>Click to upload</span>
            </a>
          </b-upload>
          <div v-if="files && files.length">
            <span class="file-name">
              {{ files[0].name }}
            </span>
          </div>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      files: []
    }
  }
}
</script>