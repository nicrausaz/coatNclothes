<template>
  <div>
    <h2 class="subtitle">
      Statistiques
    </h2>
    <hr>
    <div class="graphs">
      <p>État global des commandes</p>
      <pie-chart :data="globalOrdersData"></pie-chart>
    </div>
    <div class="graphs">
      <p>Commandes par mois</p>
      <column-chart :data="monthlyOrdersData"></column-chart>
    </div>

  </div>
</template>

<script>
export default {
  data () {
    return {
      globalOrdersData: [['En attente', 1], ['En traitement', 2], ['En livraison', 10], ['Terminée', 5]],
      monthlyOrdersData: [['Janvier', 4], ['Fevrier', 2], ['Mars', 10], ['Avril', 5], ['Mai', 3], ['Juin', 4], ['Juillet', 2], ['Août', 8], ['Septembre', 5], ['Octobre', 3], ['Novembre', 5], ['Decembre', 3]]
    }
  }
}
</script>

<style scoped>
.graphs {
  margin-bottom: 50px;
}
</style>
