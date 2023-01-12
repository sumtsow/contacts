<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати контакти</h1>
  </div>
	<div class="row justify-content-end">
    <div class="col-auto">
      <button type="button" class="btn btn-primary" @click="clearType" data-bs-toggle="modal" data-bs-target="#subscriberEditModal">Додати</button>
    </div>
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
          <tr v-for="subscriber of subscribers" class="position-relative" :class="{ 'text-muted': !subscriber.enabled }" data-bs-toggle="modal" data-bs-target="#subscriberEditModal" @click.prevent="selectSubscriber(subscriber)" style="cursor: pointer">
              <td>{{ subscriber.id }}</td>
              <td>{{ subscriber.lastname }} {{ subscriber.firstname }}</td>
							<td>{{ subscriber.group.title }}</td>
              <td>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" :id="['enabled-' + subscriber.id]" :checked="subscriber.enabled == 1" disabled />
                  <label class="form-check-label" :for="['enabled-' + subscriber.id]" />
                </div>
              </td>
              <td>{{ new Date(subscriber.created_at).toLocaleString() }}</td>
              <td>{{ new Date(subscriber.updated_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
	<div class="modal fade" id="subscriberEditModal" tabindex="-1" aria-labelledby="subscriberEditModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="subscriberEditModallLabel">Редагувати контакт</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="saveSubscriber">
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enabled-selected" v-model="currentSubscriber.enabled"/>
                <label class="form-check-label" for="enabled-selected" />
              </div>
            </div>
            <div class="mb-3">
              <label for="subscriber-lastname" class="col-form-label">Прізвище</label>
              <input type="text" class="form-control" id="subscriber-lastname" v-model="currentSubscriber.lastname">
            </div>
						<div class="mb-3">
              <label for="subscriber-lastname" class="col-form-label">Ім'я</label>
              <input type="text" class="form-control" id="subscriber-lastname" v-model="currentSubscriber.firstname">
            </div>
						<div id="form-col-2" class="row input-group mb-3">
              <label class="col-form-label col-4 text-right" label-for="group-select">Група</label>
              <select v-model="currentSubscriber.group_id" class="col form-select form-select-sm" id="group-select">
								<template v-for="item in groups">
                <option :value="item.id">
                  {{ item.title }}
                </option>
								</template>
              </select>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetSubscriber">Скасувати</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="saveSubscriber(subscriber)">Зберегти</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Breadcrumbs from '../Breadcrumbs.vue';
  export default {
    components: {
      Breadcrumbs,
    },
    data() {
      return {
        breadcrumbs: [{ href: '/dashboard', text: 'Домашня' },{ href: false, text: 'Контакти' }],
        subscribers: {},
				emptyІubscriber: {
					id: null,
					firstname: '',
					lastname: '',
					group_id: 1,
					enabled: 1,
				},
				currentSubscriber: {},
				prevState: {},
				groups: {},
      };
    },
    mounted() {
			this.clearSubscriber();
      this.getSubscribers();
			this.getGroups();
    },
    methods: {
			clearSubscriber() {
        this.currentSubscriber = Object.assign({}, this.emptySubscriber);
      },
			getGroups() {
				var app = this;
        axios.get('/api/groups/1')
          .then(function (resp) {
						app.groups = resp.data;
          })
          .catch(function () {
            alert("Could not load groups!");
          });
      },
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
			pushState() {
				this.prevState.enabled = this.currentSubscriber.enabled;
				this.prevState.firstname = this.currentSubscriber.firstname;
				this.prevState.lastname = this.currentSubscriber.lastname;
				this.prevState.group_id = this.currentSubscriber.group_id;
			},
      resetSubscriber() {
        this.currentSubscriber.enabled = this.prevState.enabled;
        this.currentSubscriber.firstname = this.prevState.firstname;
				this.currentSubscriber.lastname = this.prevState.lastname;
				this.currentSubscriber.group_id = this.prevState.group_id;
      },
      saveSubscriber() {
        if (!this.currentSubscriber) return;
				var id = this.currentSubscriber.id ? parseInt(this.currentSubscriber.id, 10) : 0;
				if (isNaN(id)) return;
        this.currentSubscriber._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var app = this;
        axios.post('/subscriber/' + id, this.currentSubscriber)
          .then(function (resp) {
						app.getSubscribers();
          })
          .catch(function (resp) {
            if (resp.response) {
              var message = resp.response.data.message;
              var errors = resp.response.data.errors;
            }
          });
      },
      selectSubscriber(subscr) {
				if (!subscr) return;
				this.currentSubscriber = subscr;
				this.pushState();
				this.currentSubscriber.enabled = !!this.currentSubscriber.enabled;
      },
    }
  };
</script>