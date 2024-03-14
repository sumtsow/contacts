<template ref="GroupIndex">
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати групи</h1>
		<div v-if="alert" class="alert" :class="alertClass">
			<h5>{{ alert.message }}</h5>
			<p v-for="line of alert.errors">{{ line }}</p>
		</div>
  </div>
  <div class="row justify-content-end">
    <div class="col-auto">
      <button type="button" class="btn btn-primary" @click="clearGroup" data-bs-toggle="modal" data-bs-target="#groupEditModal">Додати</button>
    </div>
  </div>
  <div class="row">
    <div class="col table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Титул&nbsp;&uarr;</th>
            <th>Група</th>
            <th>Статус</th>
            <th>Створено</th>
            <th>Оновлено</th>
          </tr>
        </thead>
        <tbody>
        <template v-for="group of groups">
          <group-table-row v-if="!group.parent_id" :group="group" parent="null" :handler="selectGroup"></group-table-row>
        </template>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal fade" id="groupEditModal" tabindex="-1" aria-labelledby="groupEditModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="groupEditModalLabel">Редагувати групу</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="saveGroup">
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enabled-selected" v-model="currentGroup.enabled" required="required"/>
                <label class="form-check-label" for="enabled-selected" />
              </div>
            </div>
            <div class="mb-3">
              <label for="group-title" class="col-form-label">Назва</label>
              <input type="text" class="form-control" id="group-title" v-model="currentGroup.title" required="required"/>
            </div>
            <div id="form-col-2" class="row input-group mb-3">
              <label class="col-form-label col-4 text-right" label-for="group-select">Група</label>
              <select v-model="currentGroup.parent_id" class="col form-select form-select-sm" id="group-select" required="required">
								<template v-for="item in groupSelectOptions">
                <option v-if="!item.id || item.id !== currentGroup.id" :value="item.id">
                  {{ item.title }}
                </option>
								</template>
              </select>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="resetGroup">Скасувати</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="saveGroup">Зберегти</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Breadcrumbs from '../Breadcrumbs.vue';
  import GroupTableRow from './GroupTableRow.vue';
  export default {
    components: {
      Breadcrumbs,
      GroupTableRow,
    },
		computed: {
			alertClass() {
				return (this.alert && this.alert.success) ? 'alert-success' : 'alert-danger';
			},
		},
    data() {
      return {
        breadcrumbs: [
          { href: '/dashboard', text: 'Домашня' },
          { href: false, text: 'Групи' },
        ],
        groups: {},
        groupSelectOptions: {},
				emptyGroup: {
					id: null,
					title: '',
					enabled: 1,
					parent_id: null
				},
				currentGroup: {},
				prevState: {},
				alert: null,
      };
    },
    mounted() {
			this.clearGroup();
      this.getGroups();
    },
    methods: {
      clearGroup() {
        this.currentGroup = Object.assign({}, this.emptyGroup);
				this.currentGroup.title = '';
      },
      getGroups() {
				var app = this;
        axios.get('/api/groups')
          .then(function (resp) {
						app.groups = resp.data;
						app.groupSelectOptions = [...app.groups];
						app.groupSelectOptions.unshift(app.emptyGroup);
						app.groupSelectOptions[0].title = 'немає';
          })
          .catch(function () {
            app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати групи!'] };
          });
      },
			pushState() {
				this.prevState.enabled = this.currentGroup.enabled;
				this.prevState.title = this.currentGroup.title;
			},
      resetGroup() {
        this.currentGroup.enabled = this.prevState.enabled;
        this.currentGroup.title = this.prevState.title;
				this.alert = null;
      },
      saveGroup() {
        if (!this.currentGroup) return;
				var id = this.currentGroup.id ? parseInt(this.currentGroup.id, 10) : 0;
				if (isNaN(id)) return;
        this.currentGroup._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var app = this;
        axios.post('/group/' + id, this.currentGroup)
          .then(function (resp) {
						if (resp.data.errors) {
							app.resetGroup();
							app.alert = resp.data;
						} else {
							app.getGroups();
							app.alert = { message: 'Збережено!', success: true };
						}
          })
          .catch(function (resp) {
            if (resp.response) {
							app.resetGroup();
              app.alert = resp.response.data;
            }
          });
      },
      selectGroup(grp) {
				if (!grp) return;
				this.currentGroup = grp;
				this.pushState();
				this.currentGroup.enabled = !!this.currentGroup.enabled;
				this.alert = null;
      },
    }
  };
</script>