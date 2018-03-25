<template>
  <div class="container">
    <subtitle :name="'Votre profil'" :text="'Consultez et modifiez vos informations'"></subtitle>
    <section class="section">
      <div class="tile is-12">
        <b-tooltip label="Cliquer pour éditer" position="is-bottom">
          <figure class="image" @click="editUserPic" style="cursor: pointer;">
            <img src="static/noImgAvailable.png" alt="userpic">
          </figure>
        </b-tooltip>
        <div id="infos">
          <h1 class="title">{{$store.state.user.users_fsname}} {{$store.state.user.users_name}}</h1>
          <h2>{{$store.state.user.users_email}}</h2>
          <h2>{{$store.state.user.users_login}}</h2>
          {{userStatus}}
        </div>
        <fabmenu v-if="!isEditingPhoto && !isEditingInfos" :isAdmin="$store.state.user.users_admin" @editInfos="editInfos"></fabmenu>
      </div>
    </section>
    <b-modal :active.sync="isEditingPhoto">
      <editpicmodal></editpicmodal>
    </b-modal>
    <b-modal :active.sync="isEditingInfos">
      <editinfosmodal></editinfosmodal>
    </b-modal>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import editpicmodal from '@/components/shared/user/editUserPicModal'
import editinfosmodal from '@/components/shared/user/editUserInfosModal'
import fabmenu from '@/components/shared/user/fabMenu'

export default {
  data () {
    return {
      isEditingPhoto: false,
      isEditingInfos: false
    }
  },
  computed: {
    userStatus () {
      return this.$store.state.user.users_admin ? 'Administrateur' : 'Client'
    }
  },
  methods: {
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
    fabmenu
  }
}
</script>
