<template>
<div>
  <nav class="navbar is-bottom is-primary is-fixed-bottom">
    <div class="navbar-item items">&copy; 2018 - Nicolas Crausaz & Mathias Brügger (EPSIC ICT 120-155)</div>
    <div class="navbar-end">
      <div class="field is-grouped">
        <a class="navbar-item items" @click="contactOpen = true"><b-icon icon="comment"></b-icon></a>
        <a class="navbar-item items" @click="infoOpen = true"><b-icon icon="info"></b-icon></a>
        <a class="navbar-item items" href="https://github.com/nicrausaz/coatNclothes"><b-icon icon="code-branch"></b-icon></a>
      </div>
    </div>
  </nav>
    <b-modal :active.sync="infoOpen" has-modal-card>
      <infosModal></infosModal>
    </b-modal>
  </div>
</template>

<script>
import infosModal from '@/components/shared/infosModal'
export default {
  data () {
    return {
      infoOpen: false,
      contactOpen: false
    }
  },
  components: {
    infosModal
  }
}
</script>


<style scoped>
.items {
  color: white;
}
.items:hover {
  color: white;
  background-color: #c20d5d;
}
</style>

