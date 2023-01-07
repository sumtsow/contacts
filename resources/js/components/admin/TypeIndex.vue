<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати типи</h1>
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
          <tr v-for="type of types">
              <td>{{ type.id }}</td>
              <td>
                <router-link :to="{name: 'edit-type', params: {id: type.id}}">{{ type.title }}</router-link>
              </td>
              <td>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" v-bind:id="['enabled-' + type.id]" v-bind:checked="type.enabled == 1" disabled />
                  <label class="form-check-label" v-bind:for="['enabled-' + type.id]" />
                </div>
              </td>
              <td>{{ new Date(type.created_at).toLocaleString() }}</td>
              <td>{{ new Date(type.updated_at).toLocaleString() }}</td>
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
        breadcrumbs: [{ href: '/dashboard', text: 'Домашня' },{ href: false, text: 'Типи' }],
        types: {},
      };
    },
    mounted() {
      this.getTypes();
    },
    methods: {
      getTypes() {
        var app = this;
        axios.get('/api/types')
          .then(function (resp) {
            app.types = resp.data;
          })
          .catch(function () {
            alert("Could not load types!");
          });
      },
    }
  };
</script>