<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати типи</h1>
  </div>
	<div class="row justify-content-end">
    <div class="col-auto">
      <button type="button" class="btn btn-primary" @click="clearType" data-bs-toggle="modal" data-bs-target="#typeEditModal">Додати</button>
    </div>
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
          <tr v-for="type of types" class="position-relative" :class="{ 'text-muted': !type.enabled }" data-bs-toggle="modal" data-bs-target="#typeEditModal" @click.prevent="selectType(type)" style="cursor: pointer">
              <td>{{ type.id }}</td>
              <td>{{ type.title }}</td>
              <td>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" :id="['enabled-' + type.id]" :checked="type.enabled == 1" disabled />
                  <label class="form-check-label" :for="['enabled-' + type.id]" />
                </div>
              </td>
              <td>{{ new Date(type.created_at).toLocaleString() }}</td>
              <td>{{ new Date(type.updated_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
	<div class="modal fade" id="typeEditModal" tabindex="-1" aria-labelledby="typeEditModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="typeEditModallLabel">Редагувати тип</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="saveType">
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enabled-selected" v-model="currentType.enabled"/>
                <label class="form-check-label" for="enabled-selected" />
              </div>
            </div>
            <div class="mb-3">
              <label for="type-title" class="col-form-label">Назва</label>
              <input type="text" class="form-control" id="type-title" v-model="currentType.title">
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetType">Скасувати</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="saveType(type)">Зберегти</button>
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
        breadcrumbs: [{ href: '/dashboard', text: 'Домашня' },{ href: false, text: 'Типи' }],
        types: {},
				emptyType: {
					id: null,
					title: '',
					enabled: 1,
				},
				currentType: {},
				prevState: {},
      };
    },
    mounted() {
			this.clearType();
      this.getTypes();
    },
    methods: {
			clearType() {
        this.currentType = Object.assign({}, this.emptyType);
      },
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
			pushState() {
				this.prevState.enabled = this.currentType.enabled;
				this.prevState.title = this.currentType.title;
			},
      resetType() {
        this.currentType.enabled = this.prevState.enabled;
        this.currentType.title = this.prevState.title;
      },
      saveType() {
        if (!this.currentType) return;
				var id = this.currentType.id ? parseInt(this.currentType.id, 10) : 0;
				if (isNaN(id)) return;
        this.currentType._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var app = this;
        axios.post('/type/' + id, this.currentType)
          .then(function (resp) {
						if (app.currentType.id) app.currentType = resp.data;
							else app.getTypes();
          })
          .catch(function (resp) {
            if (resp.response) {
              var message = resp.response.data.message;
              var errors = resp.response.data.errors;
            }
          });
      },
      selectType(tp) {
				if (!tp) return;
				this.currentType = tp;
				this.pushState();
				this.currentType.enabled = !!this.currentType.enabled;
      },
    }
  };
</script>