<template>
  <div class="container">
    <subtitle :name="'Votre profil'" :text="'Consultez et modifiez vos informations'"></subtitle>
    <section class="section">
      <div class="columns">
        <div class="column is-one-quarter">
          <div class="updivs">
            <figure class="image">
              <img src="static/noImgAvailable.png" alt="Image">
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
        <div class="column">
          <div class="updivs">
            <h1 class="title">Nicolas Crausaz</h1>
            n.crausaz99@gmail.com
            pseudo
          </div>

          <b-collapse class="panel">
            <div class="panel-heading">
                <strong>Mes commandes</strong>
            </div>
            <div class="panel-block">
              <p>Dernieres commandes</p>
              <ul>
                <li>Commande1</li>
                <li>Commande2</li>
                <li>Commande3</li>
              </ul>
              <p>Voir tout</p>
            </div>
        </b-collapse>
        </div>
        <div class="column">
          <div class="updivs">
            Role (client, admin) #id
          </div>
          <b-collapse class="panel">
              <div class="panel-heading">
                  <strong>Actions</strong>
              </div>
              <div class="panel-block">
                <a class="button is-primary"><b-icon icon="pencil"></b-icon><span>Modifier mes informations</span></a>
                <a class="button is-primary"><b-icon icon="sign-out"></b-icon><span>Déconnexion</span></a>
              </div>
          </b-collapse>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
export default {
  data () {
    return {
      user: {
      }
    }
  },
  components: {
    subtitle
  }
}
</script>

<style scoped>
.updivs {
  height: 350px;
}
</style>
