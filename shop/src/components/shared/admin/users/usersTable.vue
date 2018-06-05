<template>
  <section>
    <h2 class="subtitle">
      {{$store.state.interface.editUsers}}
    </h2>
    <hr>
    <b-field grouped group-multiline>
      <b-select v-model="filter.perPage">
        <option value="5">5 {{$store.state.interface.perPage}}</option>
        <option value="10">10 {{$store.state.interface.perPage}}</option>
        <option value="20">20 {{$store.state.interface.perPage}}</option>
      </b-select>
      <b-input :placeholder="$store.state.interface.nameSearch" type="search" icon-pack="fas" icon="search" v-model="searchContent"></b-input>
    </b-field>
    <b-table :data="filteredUsers" :per-page="filter.perPage" :paginated="true" :pagination-simple="true" default-sort="users_id" :mobile-cards="false">
      <template slot-scope="props">
        <b-table-column field="users_id" :label="$store.state.interface.No" width="40" sortable numeric>
          {{ props.row.users_id }}
        </b-table-column>

        <b-table-column field="users_name" :label="$store.state.interface.name" sortable>
          {{ props.row.users_name }}
          {{ props.row.users_fsname }}
        </b-table-column>

        <b-table-column field="users_login" :label="$store.state.interface.username" sortable>
          {{ props.row.users_login }}
        </b-table-column>

        <b-table-column field="users_createDate" :label="$store.state.interface.signupDate" sortable>
          {{ props.row.users_createDate }}
        </b-table-column>
        <b-table-column field="users_admin" :label="$store.state.interface.admin" sortable centered>
          <b-icon size="is-small" :icon="getIcon(props.row.users_admin)"></b-icon>
        </b-table-column>

        <b-table-column field="users_enabled" :label="$store.state.interface.enabled" sortable centered>
          <b-icon size="is-small" :icon="getIcon(props.row.users_enabled)"></b-icon>
        </b-table-column>

        <b-table-column :label="$store.state.interface.actions" centered>
          <b-tooltip label="Détails et édition" position="is-left">
            <a @click="editUser(props.row.users_id)">
              <span class="icon is-small">
                <b-icon icon="edit"></b-icon>
              </span>
            </a>
          </b-tooltip>
        </b-table-column>
      </template>
    </b-table>
    <b-modal :active.sync="isEditing" has-modal-card>
      <userModal :id="userId" @update="getUsers"></userModal>
    </b-modal>
  </section>
</template>

<script>
import userModal from '@/components/shared/admin/users/userModal'

export default {
  data () {
    return {
      filter: {
        perPage: 5
      },
      isEditing: false,
      searchContent: '',
      users: [],
      userId: 0
    }
  },
  created () {
    this.getUsers()
  },
  computed: {
    filteredUsers () {
      let results = []
      this.users.forEach(user => {
        if (!user.users_name.toLowerCase().indexOf(this.searchContent.toLowerCase())) {
          results.push(user)
        }
      })
      return results
    }
  },
  methods: {
    getUsers () {
      this.axios({
        method: 'get',
        url: '/admin/users'
      })
      .then(response => {
        this.users = response.data
      })
    },
    editUser (id) {
      this.userId = id
      this.isEditing = true
    },
    getIcon (value) {
      return value ? 'check' : 'times'
    }
  },
  components: {
    userModal
  }
}
</script>
