<template>
  <div class="row breadcrumb px-3">
    <nav class="nav my-0 py-0" id="breadcrumbs">
      <ul class="breadcrumb m-0 text-truncate">
        <li v-for="item in breadcrumbs" class="breadcrumb-item">
          <a v-bind:class="{'text-dark': !item.href}" v-bind:href="item.href" >{{ item.text }}</a>
        </li>
      </ul>
    </nav>
  </div>
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
  export default {
    data: function () {
      return {
        breadcrumbs: [
          { href: '/dashboard', text: 'Домашня' },
          { href: false, text: 'Типи' },
        ],
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