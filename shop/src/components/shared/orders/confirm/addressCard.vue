<template>
  <b-collapse class="card">
    <div class="card-header">
      <p class="card-header-title">{{$store.state.interface.address}}</p>
      <a class="card-header-icon">
        <b-icon :icon="isConfirmed ? 'check' : 'times'" :class="{'confirmed': isConfirmed}"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content">
        <nav class="panel">
          <a v-for="adress in adresses" :key="adress.adresses_id" class="panel-block">
            <b-checkbox v-model="selectedAdress" :true-value="adress.adresses_id">
              {{adress.adresses_street}} {{adress.adresses_npa}} {{adress.adresses_locality}}
            </b-checkbox>
          </a>
          <a class="panel-block" @click="isCreatingAdress = true">
            <span class="panel-icon"><b-icon icon="plus" size="is-small"></b-icon></span>
            {{$store.state.interface.createAnAddress}}
          </a>
        </nav>
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item" @click="valid">{{$store.state.interface.confirm}}</a>
    </footer>
    <b-modal :active.sync="isCreatingAdress">
      <createAdressModal @new="getUserAdresses"></createAdressModal>
    </b-modal>
  </b-collapse>
</template>

<script>
import createAdressModal from '@/components/shared/user/createUserAdressModal'

export default {
  data () {
    return {
      isConfirmed: false,
      isCreatingAdress: false,
      adresses: [],
      selectedAdress: null
    }
  },
  created () {
    this.getUserAdresses()
  },
  methods: {
    valid () {
      if (this.selectedAdress) {
        this.isConfirmed = true
        this.$emit('confirm', 'address')
        this.$emit('address', this.selectedAdress)
      } else {
        this.warningToast('Chosissez d\'abord une adresse')
      }
    },
    getUserAdresses () {
      this.axios({
        method: 'get',
        url: '/user/' + this.$store.state.user.users_id + '/adresses'
      })
      .then(response => {
        this.adresses = response.data
      })
    }
  },
  components: {
    createAdressModal
  }
}
</script>

<style scoped>
.confirmed {
  color: #23d160;
}
</style>