<template>
  <div class="container">
    <subtitle :name="'Votre profil'" :text="'Consultez et modifiez vos informations'"></subtitle>
    <section class="section">
      <div class="tile is-12">
        <figure class="image" @click="editUserPic" style="cursor: pointer;">
          <img src="static/noImgAvailable.png" alt="userpic">
        </figure>
        <div id="infos">
          <h1 class="title">Nicolas Crausaz</h1>
          <h2>n.crausaz99@gmail.com</h2>
          <h2>pseudo</h2>
        </div>
        <fabmenu v-if="!isEditingPhoto" @editInfos="editInfos"></fabmenu>
      </div>
      <div class="tile is-12">

      </div>
      <!-- <div class="columns">
        <div class="column is-one-quarter">
          <div class="updivs">
            <figure class="image" @click="editUserPic" style="cursor: pointer;">
              <img src="static/noImgAvailable.png" alt="userpic">
            </figure>
          </div>

          <b-collapse class="panel">
            <div class="panel-heading">
                <strong>Mon addresse</strong>
            </div>
            <div class="panel-block">
              <ul>
                <li>Rue</li>
                <li>NPA</li>
                <li>Localité</li>
              </ul>
            </div>
          </b-collapse>
        </div>
        <div class="column is-one-third">
          <div class="updivs">
            <h1 class="title">Nicolas Crausaz</h1>
            n.crausaz99@gmail.com
            pseudo
          </div>
           <b-collapse class="panel">
              <div class="panel-heading">
                  <strong>Actions</strong>
              </div>
              <div class="panel-block">
                  <router-link to="/admin/dashboard" class="button is-primary"><b-icon icon="unlock-alt"></b-icon><span>Administration</span></router-link>
                  <a class="button is-primary"><b-icon icon="pencil-alt"></b-icon><span>Modifier mes informations</span></a>
                  <a class="button is-primary" @click="$store.commit('detroyUser')"><b-icon icon="sign-out-alt"></b-icon><span>Déconnexion</span></a>
              </div>
          </b-collapse>
        </div>
        <div class="column">
          <div class="updivs">
            Role (client, admin) #id
          </div>
          <b-collapse class="panel">
            <div class="panel-heading">
                <strong>Mes commandes</strong>
            </div>
            <div class="panel-block" style="display: inline-block; width: 100%;">
              <div class="ordersDiv" v-for="order in orders" :key="order.orders_id">
                <router-link :to="'/order/' + order.orders_id">
                  <small>{{order.orders_id}}</small>
                  <span>{{order.orders_createdDate}}</span>
                  <span>{{order.orders_status}}</span>
                </router-link>
              </div>
              <router-link to="/orders" class="button is-small is-primary">Voir tout <b-icon icon="arrow-right" size="is-small"></b-icon></router-link>
            </div>
        </b-collapse>
        </div>
      </div>-->
    </section>
    <b-modal :active.sync="isEditingPhoto">
      <editpicmodal></editpicmodal>
    </b-modal>
    <b-modal :active.sync="isEditingInfos">
      <!-- <editinfosmodal></editinfosmodal> -->
    </b-modal>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import editpicmodal from '@/components/shared/user/edituserPicModal'
import fabmenu from '@/components/shared/user/fabMenu'

export default {
  data () {
    return {
      orders: [
        {
          orders_id: 1,
          orders_createdDate: '02/02/2018',
          orders_status: 'En préparation'
        },
        {
          orders_id: 2,
          orders_createdDate: '01/02/2018',
          orders_status: 'En livraison'
        },
        {
          orders_id: 3,
          orders_createdDate: '01/01/2018',
          orders_status: 'Terminée'
        }
      ],
      isEditingPhoto: false,
      isEditingInfos: false
    }
  },
  methods: {
    editUserPic () {
      this.isEditingPhoto = true
    },
    editInfos () {
      console.log('start editing user infos')
    }
  },
  components: {
    subtitle,
    editpicmodal,
    fabmenu
  }
}
</script>

<style scoped>
.updivs {
  height: 350px;
}
.ordersDiv {
  padding: 5px;
  border: 1px solid lightgray;
  cursor: pointer;
}
</style>
