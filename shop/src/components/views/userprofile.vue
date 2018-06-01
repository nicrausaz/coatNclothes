<template>
  <div class="container">
    <subtitle :name="$store.state.interface.yourProfile" :text="$store.state.interface.seeAndEditInformations"></subtitle>
    <section class="section">
      <div class="columns">
        <div class="column is-6">
          <b-tooltip :label="$store.state.interface.clickToEdit" position="is-bottom">
            <figure class="image" @click="editUserPic" alt="userpic" id="userpic" style="cursor: pointer;">
              <img :src="userPic">
            </figure>
          </b-tooltip>
          <div id="infos">
            <h1 class="title">{{userFullInfos.users_fsname}} {{userFullInfos.users_name}}</h1>
            <h2><b>{{$store.state.interface.email}}:</b> {{userFullInfos.users_email}}</h2>
            <h2><b>{{$store.state.interface.username}}:</b> {{userFullInfos.users_login}}</h2>
            <h2><b>{{$store.state.interface.status}}:</b> {{userStatus}}</h2>
          </div>
        </div>
        <div class="column is-6">
          <userAdresses></userAdresses>
        </div>
      </div>
    <fabmenu :isAdmin="$store.state.user.users_admin" @editInfos="editInfos"></fabmenu>
    </section>
    <b-modal :active.sync="isEditingPhoto">
      <editpicmodal :img="userPic" @edit="getUserInfos"></editpicmodal>
    </b-modal>
    <b-modal :active.sync="isEditingInfos">
      <editinfosmodal @edit="getUserInfos"></editinfosmodal>
    </b-modal>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import editpicmodal from '@/components/shared/user/editUserPicModal'
import editinfosmodal from '@/components/shared/user/editUserInfosModal'
import userAdresses from '@/components/shared/user/userAdresses'
import fabmenu from '@/components/shared/user/fabMenu'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
      isEditingPhoto: false,
      isEditingInfos: false,
      userFullInfos: []
    }
  },
  created () {
    this.getUserInfos()
  },
  computed: {
    userStatus () {
      return this.userFullInfos.users_admin ? this.$store.state.interface.admin : this.$store.state.interface.customer
    },
    userPic () {
      return this.userFullInfos.users_pic || '/static/noImgAvailable.png'
    }
  },
  methods: {
    getUserInfos () {
      this.axios({
        method: 'get',
        url: '/user/' + this.$store.state.user.users_id
      })
      .then(response => {
        this.userFullInfos = response.data
      })
      .catch(() => {
        // this.$store.commit('detroyUser')
        // this.$router.push('/user')
        // this.$toast.open({
        //   message: 'Session expirée, veuillez vous connecter à nouveau',
        //   type: 'is-warning'
        // })
      })
    },
    editUserPic () {
      this.isEditingPhoto = true
    },
    editInfos () {
      this.isEditingInfos = true
    }
  },
  components: {
    subtitle,
    editpicmodal,
    editinfosmodal,
    userAdresses,
    fabmenu
  }
}
</script>

<style scoped>
#userpic {
  max-width: 300px;
}
</style>
