<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати контакти</h1>
		<div v-if="!modalIsShown && alert" class="alert" :class="alertClass">
			<h5>{{ alert.message }}</h5>
			<p v-for="line of alert.errors">{{ line }}</p>
		</div>
  </div>
	<div class="row justify-content-end">
    <div class="col-auto">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscriberEditModal" @click="clearSubscriber">Додати</button>
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
						<th>Контакти</th>
            <th>Статус</th>
            <th>Створено</th>
            <th>Оновлено</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="subscriber of subscribers" class="position-relative" :class="{ 'text-muted': !subscriber.enabled }" data-bs-toggle="modal" data-bs-target="#subscriberEditModal" @click="selectSubscriber(subscriber)" style="cursor: pointer">
              <td>{{ subscriber.id }}</td>
              <td>{{ subscriber.lastname }} {{ subscriber.firstname }}</td>
							<td>{{ subscriber.group.title }}</td>
							<td>
								<div v-for="contact of subscriber.contact" :class="{ 'text-muted': !contact.enabled }">{{ contact.value }}</div>
							</td>
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
	<div class="modal fade" id="subscriberEditModal" aria-hidden="true" aria-labelledby="subscriberEditModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="subscriberEditModalLabel">Редагувати контакт</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
        </div>
        <div class="modal-body">
					<div v-if="modalIsShown && alert" class="alert" :class="alertClass">
						<h5>{{ alert.message }}</h5>
						<p v-for="line of alert.errors">{{ line }}</p>
					</div>
          <form @submit.prevent="saveSubscriber">
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enabled-selected" v-model="currentSubscriber.enabled" required="required"/>
                <label class="form-check-label" for="enabled-selected" />
              </div>
            </div>
            <div class="mb-3">
              <label for="subscriber-lastname" class="col-form-label">Прізвище</label>
              <input type="text" class="form-control" id="subscriber-lastname" v-model="currentSubscriber.lastname">
            </div>
						<div class="mb-3">
              <label for="subscriber-lastname" class="col-form-label">Ім'я</label>
              <input type="text" class="form-control" id="subscriber-lastname" v-model="currentSubscriber.firstname" required="required">
            </div>
						<div id="form-col-2" class="row input-group mb-3">
              <label class="col-form-label col-4 text-right" label-for="group-select">Група</label>
              <select v-model="currentSubscriber.group_id" class="col form-select form-select-sm" id="group-select" required="required" @click="selectGroup(currentSubscriber.group)">
								<template v-for="item in groups">
                <option :value="item.id">
                  {{ item.title }}
                </option>
								</template>
              </select>
            </div>
						<template v-for="contact in currentSubscriber.contact">
						<div class="row border border-secondary rounded mb-3 mx-1 py-3" :class="{ 'text-muted': !contact.enabled }" style="cursor: pointer" data-bs-target="#contactEditModal" data-bs-toggle="modal" type="button" data-bs-dismiss="modal" @click="selectContact(contact)">
							<div class="col-auto">{{ contact.type.title }}:</div>
							<div class="col">{{ contact.value }}</div>
						</div>
						</template>
					</form>
					<div v-if="currentSubscriber.id" class="row justify-content-end">
						<div class="col-auto" data-bs-dismiss="modal">
							<button class="btn btn-primary" data-bs-target="#contactEditModal" data-bs-toggle="modal" @click="clearContact">Додати контакт</button>
						</div>
					</div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" @click="resetSubscriber">Скасувати</button>
          <button class="btn btn-primary" data-bs-dismiss="modal" @click="saveSubscriber(subscriber)">Зберегти</button>
        </div>
      </div>
    </div>
  </div>
	<div class="modal fade" id="contactEditModal" aria-hidden="true" aria-labelledby="contactEditModalLabel" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="contactEditModalLabel">Редагувати контакт</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="saveContact">
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enabled-selected" v-model="currentContact.enabled" required="required"/>
                <label class="form-check-label" for="enabled-selected" />
              </div>
            </div>
            <div class="mb-3">
              <label for="contact-value" class="col-form-label">Контакт</label>
              <input :type="(currentContact ? currentContact.type.input_type : 'text')" class="form-control" id="contact-value" v-model="currentContact.value" required="required">
            </div>
						<div id="form-col-2" class="row input-group mb-3">
              <label class="col-form-label col-4 text-right" label-for="type-select">Тип</label>
              <select v-model="currentContact.type_id" class="col form-select form-select-sm" id="type-select" required="required" @change="selectTypeId">
								<template v-for="item in types">
                <option v-if="item.enabled" :value="item.id">
                  {{ item.title }}
                </option>
								</template>
              </select>
            </div>
					</form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal" data-bs-target="#subscriberEditModal" data-bs-toggle="modal" @click="resetContact">Скасувати</button>
          <button class="btn btn-primary" data-bs-dismiss="modal" data-bs-target="#subscriberEditModal" data-bs-toggle="modal" @click="saveContact">Зберегти</button>
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
		computed: {
			alertClass() {
				return (this.alert && this.alert.success) ? 'alert-success' : 'alert-danger';
			},
		},
    data() {
      return {
        breadcrumbs: [{ href: '/dashboard', text: 'Домашня' },{ href: false, text: 'Контакти' }],
        subscribers: {},
				emptyContact: {
					id: null,
					value: '',
					subscriber_id: null,
					type_id: 1,
					enabled: true,
					type: {}
				},
				emptySubscriber: {
					id: null,
					firstname: '',
					lastname: '',
					group_id: 1,
					enabled: true,
				},
				currentSubscriber: {},
				currentContact: {type: {}},
				prevState: {},
				prevContactState: {},
				groups: {},
				types: {},
				inputTypes: [],
				alert: null,
				modalIsShown: false,
				subscriberModal: {},
      };
    },
    mounted() {
			this.clearSubscriber();
			this.clearContact();
      this.getSubscribers();
			this.getGroups();
			this.getTypes();
			this.getInputTypes();
			this.setModalHandlers();
    },
    methods: {
			addContact() {
				console.log('Add');
			},
			clearContact() {
        this.currentContact = Object.assign({}, this.emptyContact);
      },
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
            app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати групи!'] };
          });
      },
			getInputTypes() {
        var app = this;
        axios.get('/api/intypes')
          .then(function (resp) {
            app.inputTypes = resp.data;
          })
          .catch(function () {
						app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати типи поля введення!'] };
          });
      },
      getSubscribers() {
        var app = this;
        axios.get('/api/subscribers')
          .then(function (resp) {
            app.subscribers = resp.data;
          })
          .catch(function () {
						app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати контакти!'] };
          });
      },
			getTypes() {
        var app = this;
        axios.get('/api/types')
          .then(function (resp) {
            app.types = resp.data;
          })
          .catch(function () {
						app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати типи контакту!'] };
          });
      },
			pushContactState() {
				this.prevContactState.enabled = this.currentContact.enabled;
				this.prevContactState.value = this.currentContact.value;
				this.prevContactState.subscriber_id = this.currentContact.subscriber_id;
				this.prevContactState.type_id = this.currentContact.type_id;
			},
			pushState() {
				this.prevState.enabled = this.currentSubscriber.enabled;
				this.prevState.firstname = this.currentSubscriber.firstname;
				this.prevState.lastname = this.currentSubscriber.lastname;
				this.prevState.group_id = this.currentSubscriber.group_id;
			},
			resetContact() {
				if (!this.currentContact.id) return;
        this.currentContact.enabled = this.prevContactState.enabled;
        this.currentContact.value = this.prevContactState.value;
				this.currentContact.subscriber_id = this.prevContactState.subscriber_id;
				this.currentContact.type_id = this.prevContactState.type_id;
				this.alert = null;
      },
      resetSubscriber() {
				if (!this.currentSubscriber.id) return;
        this.currentSubscriber.enabled = this.prevState.enabled;
        this.currentSubscriber.firstname = this.prevState.firstname;
				this.currentSubscriber.lastname = this.prevState.lastname;
				this.currentSubscriber.group_id = this.prevState.group_id;
				this.alert = null;
      },
			saveContact() {
        if (!this.currentContact) return;
				var id = this.currentContact.id ? parseInt(this.currentContact.id, 10) : 0;
				if (isNaN(id)) return;
        this.currentContact._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
				if (!this.currentContact.subscriber_id) this.currentContact.subscriber_id = this.currentSubscriber.id;
        var app = this;
        axios.post('/contact/' + id, this.currentContact)
          .then(function (resp) {
						if (resp.data.errors) {
							app.resetContact();
							app.alert = resp.data;
						} else {
							app.getSubscribers();
							app.currentContact.type = app.types.find(elem => elem.id == app.currentContact.type_id);
							if (!id) {
								app.currentSubscriber.contact.push(app.currentContact);
							} else {
								app.currentContact = resp.data[0];
								var index = app.currentSubscriber.contact.findIndex(elem => elem.id == app.currentContact.id);
								app.currentSubscriber.contact[index] = app.currentContact;
							}
							app.alert = { message: 'Збережено!', success: true };
						}
          })
          .catch(function (resp) {
            if (resp.response) {
              app.resetContact();
							app.alert = resp.response.data;
            }
          });
      },
      saveSubscriber() {
        if (!this.currentSubscriber) return;
				var id = this.currentSubscriber.id ? parseInt(this.currentSubscriber.id, 10) : 0;
				if (isNaN(id)) return;
        this.currentSubscriber._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var app = this;
        axios.post('/subscriber/' + id, this.currentSubscriber)
          .then(function (resp) {
						if (resp.data.errors) {
							app.resetSubscriber();
							app.alert = resp.data;
						} else {
							if (!id) app.subscribers.unshift(resp.data[0]);
							app.alert = { message: 'Збережено!', success: true };
						}
          })
          .catch(function (resp) {
            if (resp.response) {
              app.resetSubscriber();
							app.alert = resp.response.data;
            }
          });
      },
			selectContact(contact) {
				if (!contact) return;
				this.currentContact = contact;
				if (this.currentContact.id) this.pushContactState();
				this.currentContact.enabled = !!this.currentContact.enabled;
				this.alert = null;
      },
			selectGroup() {
				var app = this;
				this.currentSubscriber.group = this.groups.find(elem => elem.id == app.currentSubscriber.group_id);
      },
      selectSubscriber(subscr) {
				if (!subscr) return;
				this.currentSubscriber = subscr;
				if (this.currentSubscriber.id) this.pushState();
				this.currentSubscriber.enabled = !!this.currentSubscriber.enabled;
				this.alert = null;
      },
			selectTypeId() {
				var app = this;
				this.currentContact.type.input_type = this.types.find(elem => elem.id == app.currentContact.type_id).input_type;
			},
			setModalHandlers() {
				var app = this;
				this.subscriberModal = document.getElementById('subscriberEditModal');
				this.subscriberModal.addEventListener('show.bs.modal', () => {
					app.modalIsShown = true;
				});
				this.subscriberModal.addEventListener('hide.bs.modal', () => {
					app.modalIsShown = false;
				});
			},
    },
  };
</script>