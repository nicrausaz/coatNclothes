<template>
  <aside class="menu">
    <p class="menu-label">
      <router-link to="/admin/dashboard">Dashboard</router-link>
    </p>
    <ul class="menu-list">
      <li><a>Résumé</a></li>
    </ul>
    <p class="menu-label">
      Administration
    </p>
    <ul class="menu-list">
        <li>
          <a class="is-active">Articles</a>
          <ul>
              <li><a>Members</a></li>
              <li><a>Plugins</a></li>
              <li><a>Add a member</a></li>
          </ul>
        </li>
        <li>
          <a class="is-active">Commandes</a>
          <ul>
              <li><a>Members</a></li>
              <li><a>Plugins</a></li>
              <li><a>Add a member</a></li>
          </ul>
        </li>
        <li>
          <a class="">Utilisateurs</a>
          <ul>
              <li><a>Members</a></li>
              <li><a>Plugins</a></li>
              <li><a>Add a member</a></li>
          </ul>
        </li>

    </ul>
  </aside>
</template>

<script>
export default {
  methods: {
    test (test) {
      console.log(test)
    }
  }
}
</script>

<style scoped>
.notification {
  margin-top: 10px;
}
</style>
