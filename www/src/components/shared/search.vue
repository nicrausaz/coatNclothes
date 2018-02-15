<template>
<b-dropdown position="is-bottom-left">
  <a class="navbar-item" slot="trigger">
    <b-icon icon="search" size="is-medium"></b-icon>
  </a>

  <b-dropdown-item custom paddingless>
    <form action="">
      <div class="modal-card" style="width: 400px;">
        <section class="modal-card-body">
          <b-field>
            <b-input placeholder="Chercher un article, catégorie..." type="search" icon="search" v-model="searchContent"></b-input>
          </b-field>
          <div id="searchResults">
            ... {{searchContent}}
          </div>
        </section>
      </div>
    </form>
  </b-dropdown-item>
</b-dropdown>
</template>

<script>
export default {
  data () {
    return {
      searchContent: ''
    }
  }
}
</script>

<style>

</style>
