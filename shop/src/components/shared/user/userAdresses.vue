<template>
  <div>
    <div class="card">
      <div class="card-content">
        <p class="subtitle">
          {{$store.state.interface.myAddresses}}
        </p>
        <nav v-if="adresses.length === 0">
          {{$store.state.interface.noAddress}}
        </nav>
        <nav class="panel" v-else>
          <a v-for="adress in adresses" :key="adress.adresses_id" class="panel-block" @click="editAdress(adress)" :class="{'is-active': adress.adresses_main}">
            <b-tooltip :label="$store.state.interface.clickToEdit" position="is-right">
              <span class="panel-icon"><b-icon icon="home" size="is-small"></b-icon></span>
              {{adress.adresses_street}} {{adress.adresses_npa}} {{adress.adresses_locality}}
            </b-tooltip>
          </a>
        </nav>
      </div>
      <footer class="card-footer">
        <a class="card-footer-item" @click="newAdress">
          <span>{{$store.state.interface.new}}</span>
        </a>
      </footer>
    </div>
    <b-modal :active.sync="isEditingAdress">
      <editAdressModal :adress="editingAdress" @update="getUserAdresses"></editAdressModal>
    </b-modal>
    <b-modal :active.sync="isCreatingAdress">
      <createAdressModal @new="getUserAdresses"></createAdressModal>
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
