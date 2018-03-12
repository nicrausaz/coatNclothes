<template>
  <article class="media column is-4">
    <figure class="media-left">
      <p class="image is-64x64">
        <img src="static/noImgAvailable.png">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>Nom de l'article</strong>
          <small>20 CHF</small>
        </p>
      </div>
    </div>
  </article>
</template>

<script>
export default {
  props: ['data']
}
</script>

<style scoped>
.media {
  border: none;
  margin: 0px;
  padding-left: 20px;
  /* border: 1px solid black; */
}
</style>
