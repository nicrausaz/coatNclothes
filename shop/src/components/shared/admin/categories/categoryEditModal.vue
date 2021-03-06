<template>
  <div class="modal-card" @keyup.enter="update">
    <header class="modal-card-head">
      <p class="modal-card-title">{{$store.state.interface.editCategory}}</p>
      <a class="button is-danger is-outlined is-pulled-right" @click.stop="deleteCategory">
        <span>{{$store.state.interface.delete}}</span>
        <b-icon icon="trash" size="is-small"></b-icon>
      </a>
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
      <b-field :label="$store.state.interface.parentCat">
        <Treeselect v-model="newData.fk_category_id" :openDirection="'below'" :placeholder="$store.state.interface.chooseCategory" :normalizer="normalizer" :options="categories"></Treeselect>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">{{$store.state.interface.cancel}}</button>
      <button class="button is-primary" @click="update">{{$store.state.interface.confirm}}</button>
    </footer>
  </div>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  props: ['id', 'parentId'],
  data () {
    return {
      genders: [],
      category: {},
      categories: [],
      newData: {
        category_lang: '',
        category_name: '',
        fk_category_id: null,
        gender_id: null
      }
    }
  },
  created () {
    this.getCategories()
    this.getCategory()
    this.getGenders()
  },
  methods: {
    normalizer (node) {
      return {
        id: node.id,
        label: node.name,
        children: node.children
      }
    },
    getCategories () {
      this.axios({
        method: 'get',
        url: '/categories'
      })
      .then(response => {
        this.categories = response.data
      })
    },
    update () {
      this.axios({
        method: 'patch',
        url: '/admin/category/' + this.id,
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
    getCategory () {
      this.axios({
        method: 'get',
        url: '/category/' + this.id
      })
      .then(response => {
        this.category = response.data
        this.setData()
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
    },
    setData () {
      this.newData.category_lang = this.$store.state.language
      this.newData.category_name = this.category.category_name
      this.newData.fk_category_id = this.parentId
      this.newData.gender_id = this.category.gender_id
    },
    deleteCategory () {
      this.$dialog.confirm({
        title: this.$store.state.interface.delete,
        message: this.$store.state.interface.warningDeletCatAndSub,
        type: 'is-danger',
        hasIcon: true,
        icon: 'times-circle',
        confirmText: this.$store.state.interface.confirm,
        cancelText: this.$store.state.interface.cancel,
        onConfirm: () => {
          this.axios({
            method: 'delete',
            url: 'admin/category/' + this.id
          })
          .then((response) => {
            this.defaultToast(response.data.message)
            this.$emit('update')
            this.$parent.close()
          })
        }
      })
    }
  },
  components: {
    Treeselect
  }
}
</script>

<style scoped>

</style>

