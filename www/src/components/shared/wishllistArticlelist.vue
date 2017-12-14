<template>
    <section>
      <button class="button field is-danger" @click="checkedRows = []" :disabled="!checkedRows.length">
        <b-icon icon="close"></b-icon>
          <span>Clear checked</span>
        </button>
      <b-table :data="articles" detailed checkable :checked-rows.sync="checkedRows" detail-key="id" @details-open="(row, index) => $toast.open(`Expanded ${row.first_name}`)">

        <template slot-scope="props">
            <b-table-column label="Nom">
                {{ props.row.first_name }}
            </b-table-column>

            <b-table-column label="Prix">
                {{ props.row.last_name }}
            </b-table-column>
        </template>

        <template slot="detail" slot-scope="props">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img src="https://bulma.io/images/placeholders/1280x960.png">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Proin ornare magna eros, eu pellentesque tortor vestibulum ut.
                            Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
                        </p>
                    </div>
                </div>
            </article>
        </template>
    </b-table>
    </section>
</template>

<script>
  export default {
    props: ['articles'],
    data () {
      return {
        checkedRows: []
      }
    }
  }
</script>
