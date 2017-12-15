<template>
    <section>
      <b-table :data="articles" detailed checkable :checked-rows.sync="checkedRows" detail-key="id">

        <template slot-scope="props">
            <b-table-column label="Nom">
                {{ props.row.name }}
            </b-table-column>

            <b-table-column label="Prix">
                {{ formatedPrice(props.row.price) }}
            </b-table-column>
        </template>

        <template slot="detail" slot-scope="props">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-128x128">
                        <img :src="props.row.img">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>{{ props.row.description }}</p>
                    </div>
                </div>
            </article>
        </template>
    </b-table>
    <button class="button field is-danger" @click="checkedRows = []" :disabled="!checkedRows.length">
        <b-icon icon="close"></b-icon>
          <span>Clear checked</span>
        </button>
    </section>
</template>

<script>
  export default {
    props: ['articles'],
    data () {
      return {
        checkedRows: []
      }
    },
    methods: {
      formatedPrice (price) {
        return price.toFixed(2) + 'CHF'
      }
    },
    computed: {
      isChecked () {
        return this.checkedRows > 0
      }
    }
  }
</script>
