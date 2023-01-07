<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати контакти</h1>
  </div>
  <div class="row">
    <div class="col table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID&nbsp;&uarr;</th>
            <th>Прізвище та ім'я</th>
            <th>Група</th>
            <th>Статус</th>
            <th>Створено</th>
            <th>Оновлено</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="subscriber of subscribers">
              <td>{{ subscriber.id }}</td>
              <td>
                <router-link :to="{name: 'edit-subscriber', params: {id: subscriber.id}}">{{ subscriber.lastname }} {{ subscriber.firstname }}</router-link>
              </td>
              <td>{{ subscriber.group_id }}</td>
              <td>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" v-bind:id="['enabled-' + subscriber.id]" v-bind:checked="subscriber.enabled == 1" disabled />
                  <label class="form-check-label" v-bind:for="['enabled-' + subscriber.id]" />
                </div>
              </td>
              <td>{{ new Date(subscriber.created_at).toLocaleString() }}</td>
              <td>{{ new Date(subscriber.updated_at).toLocaleString() }}</td>
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
          { href: false, text: 'Контакти' },
        ],
        subscribers: {},
      };
    },
    mounted() {
      this.getSubscribers();
    },
    methods: {
      getSubscribers() {
        var app = this;
        axios.get('/api/subscribers')
          .then(function (resp) {
            app.subscribers = resp.data;
          })
          .catch(function () {
            alert("Could not load subscribers!");
          });
      },
    }
  };
</script>