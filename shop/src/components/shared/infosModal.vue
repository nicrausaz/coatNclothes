<template>
  <div class="modal-card" @keyup.enter="create" color>
    <header class="modal-card-head">
      <p class="modal-card-title">Infos</p>
    </header>
    <section class="modal-card-body">
      <p>Ce site est un magasin fictif dans le cadre d'un projet d'étude.</p>
      <p>Aucun produit / commande n'est officiel et ne sera traité.</p>
      <p>Ce projet à été réalisé pour le module ICT 120-151.</p>
      <p>Nicolas Crausaz & Mathias Brugger</p>
    </section>
    <!-- <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="create">{{$store.state.interface.confirm}}</button>
    </footer> -->
  </div>
</template>

<script>
export default {
  data () {
    return {}
  }
}
</script>
