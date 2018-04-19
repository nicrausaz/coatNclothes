<template>
  <div>
    <div class="card">
      <div class="card-content">
        <p class="subtitle">
          Mes adresses
        </p>
          <nav class="panel">
              <a v-for="adress in adresses" :key="adress.adresses_id" class="panel-block" @click="editAdress(adress)" :class="{'is-active': isMainAdress(adress.adresses_main)}">
                <b-tooltip label="Cliquer pour éditer" position="is-right">
                  <span class="panel-icon"><b-icon icon="home" size="is-small"></b-icon></span>
                  {{adress.adresses_street}} {{adress.adresses_npa}} {{adress.adresses_locality}}
                </b-tooltip>
              </a>
          </nav>
      </div>
      <footer class="card-footer">
        <a class="card-footer-item" @click="newAdress">
          <span>
            Nouvelle
          </span>
        </a>
      </footer>
    </div>
    <b-modal :active.sync="isEditingAdress">
      <editAdressModal :adress="editingAdress"></editAdressModal>
    </b-modal>
    <b-modal :active.sync="isCreatingAdress">
      <createAdressModal :adress="editAdress"></createAdressModal>
    </b-modal>
  </div>
</template>

<script>
import editAdressModal from '@/components/shared/user/editUserAdressModal'
import createAdressModal from '@/components/shared/user/createUserAdressModal'

export default {
  data () {
    return {
      adresses: [],
      editingAdress: {},
      isEditingAdress: false,
      isCreatingAdress: false
    }
  },
  created () {
    this.getUserAdresses()
  },
  methods: {
    getUserAdresses () {
      this.axios({
        method: 'get',
        url: '/user/' + this.$store.state.user.users_id + '/adresses'
      })
      .then((response) => {
        this.adresses = response.data
      })
    },
    editAdress (adress) {
      this.editingAdress = adress
      this.isEditingAdress = true
    },
    newAdress () {
      this.isCreatingAdress = true
    },
    isMainAdress (isMain) {
      return isMain
    }
  },
  components: {
    editAdressModal,
    createAdressModal
  }
}
</script>

<style>

</style>
