<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editCategory}}</p>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.name">
        <b-input type="text" v-model="newData.category_name" :value="category.category_name" :placeholder="$store.state.interface.name" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.gender">
        <b-select v-model="newData.gender_id" :placeholder="$store.state.interface.gender" expanded>
          <option v-for="gender in genders" :key="gender.gender_id" :value="gender.gender_id">{{gender.gender_sex}}</option>
        </b-select>
      </b-field>
      {{category}}
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="update">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data () {
    return {
      genders: [],
      category: {},
      newData: {
        category_lang: '',
        category_name: '',
        fk_category_id: null,
        gender_id: null
      }
    }
  },
  created () {
    this.getCategory()
    this.getGenders()
  },
  methods: {
    update () {
      this.axios({
        method: 'patch',
        url: '/admin/category',
        data: this.newData
      })
      .then(response => {
        this.$emit('update')
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$parent.close()
      })
    },
    getCategory () {
      this.axios({
        method: 'get',
        url: '/category/' + this.id
      })
      .then(response => {
        this.category = response.data
      })
    },
    getGenders () {
      this.axios({
        method: 'get',
        url: '/genders/available'
      })
      .then(response => {
        this.genders = response.data
      })
    }
  }
}
</script>
