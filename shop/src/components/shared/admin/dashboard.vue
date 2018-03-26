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
      <column-chart :data="monthlyOrdersData" :library="{backgroundColor: '#fff'}"></column-chart>
    </div>

  </div>
</template>

<script>
export default {
  data () {
    return {
      globalOrdersData: [['Jan', 4], ['Feb', 2], ['Mar', 10], ['Apr', 5], ['May', 3]],
      monthlyOrdersData: [['Jan', 4], ['Feb', 2], ['Mar', 10], ['Apr', 5], ['May', 3]]
    }
  }
}
</script>

<style scoped>
.graphs {
  margin-bottom: 50px;
}
</style>
