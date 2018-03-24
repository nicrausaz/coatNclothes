<template>
  <div class="container">
    <subtitle :name="'Confirmation'" :text="'Confirmez votre commande'"></subtitle>
    <section class="section">
      <b-collapse class="card">
        <div slot="trigger" slot-scope="props" class="card-header">
          <p class="card-header-title">
            Produits
          </p>
          <a class="card-header-icon">
            <b-icon :icon="isOpen.products ? 'angle-up' : 'angle-down'"></b-icon>
          </a>
        </div>
        <div class="card-content">
          <div class="content">
            LISTE DES PRODUITS
          </div>
        </div>
        <footer class="card-footer">
          <a class="card-footer-item">Confirmer</a>
        </footer>
      </b-collapse>
<div class="columns">
  <div class="column">
    <b-collapse class="card">
        <div slot="trigger" slot-scope="props" class="card-header">
          <p class="card-header-title">
            Adresse
          </p>
          <a class="card-header-icon">
            <b-icon :icon="isOpen.address ? 'angle-up' : 'angle-down'"></b-icon>
          </a>
        </div>
        <div class="card-content">
          <div class="content">
            <div class="field">
              <label class="label">Rue No</label>
              <div class="control">
                <input class="input" type="text">
              </div>
            </div>

            <div class="field">
              <label class="label">Localité</label>
              <div class="control">
                <input class="input" type="text">
              </div>
            </div>

            <div class="field">
              <label class="label">NPA</label>
              <div class="control">
                <input class="input" type="text">
              </div>
            </div>
          </div>
        </div>
        <footer class="card-footer">
          <a class="card-footer-item">Confirmer</a>
        </footer>
      </b-collapse>
  </div>
  <div class="column">
    <b-collapse class="card">
      <div slot="trigger" slot-scope="props" class="card-header">
        <p class="card-header-title">
          Paiement
        </p>
        <a class="card-header-icon">
          <b-icon :icon="isOpen.payment ? 'angle-up' : 'angle-down'"></b-icon>
        </a>
      </div>
      <div class="card-content">
        <div class="content">
          LISTE DES PRODUITS
        </div>
      </div>
      <footer class="card-footer">
        <a class="card-footer-item">Confirmer</a>
      </footer>
      </b-collapse>
      </div>
  </div>
      <button class="button is-primary is-large is-pulled-right" disabled>Terminer</button>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
export default {
  data () {
    return {
      isOpen: {
        products: false,
        address: false,
        payment: false
      },
      isConfirmed: {
        products: false,
        address: false,
        payment: false
      }
    }
  },
  components: {
    subtitle
  }
}
</script>

<style scoped>
.card {
  margin-bottom: 50px;
}
</style>
