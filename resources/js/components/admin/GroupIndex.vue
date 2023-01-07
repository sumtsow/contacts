<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати групи</h1>
  </div>
  <div class="row">
    <div class="col table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID&nbsp;&uarr;</th>
            <th>Титул</th>
            <th>Статус</th>
            <th>Створено</th>
            <th>Оновлено</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="group of groups">
              <td>{{ group.id }}</td>
              <td>
                <router-link :to="{name: 'edit-group', params: {id: group.id}}">{{ group.title }}</router-link>
              </td>
              <td>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" v-bind:id="['enabled-' + group.id]" v-bind:checked="group.enabled == 1" disabled />
                  <label class="form-check-label" v-bind:for="['enabled-' + group.id]" />
                </div>
              </td>
              <td>{{ new Date(group.created_at).toLocaleString() }}</td>
              <td>{{ new Date(group.updated_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  import Breadcrumbs from '../Breadcrumbs.vue';
  export default {
    components: {
      Breadcrumbs
    },
    data() {
      return {
        breadcrumbs: [
          { href: '/dashboard', text: 'Домашня' },
          { href: false, text: 'Групи' },
        ],
        groups: {},
      };
    },
    mounted() {
      this.getGroups();
    },
    methods: {
      getGroups() {
        var app = this;
        axios.get('/api/groups')
          .then(function (resp) {
            app.groups = resp.data;
          })
          .catch(function () {
            alert("Could not load groups!");
          });
      },
    }
  };
</script>