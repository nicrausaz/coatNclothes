<template>
  <div class="modal-card" @keyup.enter="create">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.newCategory}}</p>
    </header>
    <section class="modal-card-body">
      <b-field :label="$store.state.interface.name">
        <b-input type="text" v-model="newData.category_name" :placeholder="$store.state.interface.name" required></b-input>
      </b-field>
      <b-field :label="$store.state.interface.gender">
        <b-select v-model="newData.gender_id" :placeholder="$store.state.interface.gender" expanded>
          <option v-for="gender in genders" :key="gender.gender_id" :value="gender.gender_id">{{gender.gender_sex}}</option>
        </b-select>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="create">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['parentId'],
  data () {
    return {
      genders: [],
      newData: {
        category_lang: '',
        category_name: '',
        fk_category_id: null,
        gender_id: null
      }
    }
  },
  created () {
    this.getGenders()
    this.newData.fk_category_id = this.parentId
    this.newData.category_lang = this.$store.state.language
  },
  methods: {
    create () {
      this.axios({
        method: 'put',
        url: '/admin/category',
        data: this.newData
      })
      .then(response => {
        this.$emit('update')
        this.successToast(response.data.message)
        this.$parent.close()
      })
      .catch(err => {
        let errors = JSON.parse(err.response.data.message)
        Object.keys(errors).forEach(key => { this.dangerToast(errors[key].toString()) })
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
