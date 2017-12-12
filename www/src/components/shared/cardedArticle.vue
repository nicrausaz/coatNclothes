<template>
<div class="column is-one-quarter">
  <div class="card">
    <div class="card-image">
      <figure class="image is-square">
        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-content">
          <p class="title is-4">{{ infos.product_name }}</p>
        </div>
      </div>

      <div class="content">
        {{infos.product_description}}
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['infos']
}
</script>

<style>
.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
