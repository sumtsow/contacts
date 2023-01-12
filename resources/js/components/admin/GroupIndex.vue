<template ref="GroupIndex">
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Редагувати групи</h1>
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
            <th>ID&nbsp;&uarr;</th>
            <th>Титул</th>
            <th>Група</th>
            <th>Статус</th>
            <th>Створено</th>
            <th>Оновлено</th>
          </tr>
        </thead>
        <tbody>
        <template v-for="group of groups">
          <table-row :group="group" parent="null" :handler="selectGroup"></table-row>
        </template>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal fade" id="groupEditModal" tabindex="-1" aria-labelledby="groupEditModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="groupEditModallLabel">Редагувати групу</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="saveGroup">
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enabled-selected" v-model="currentGroup.enabled"/>
                <label class="form-check-label" for="enabled-selected" />
              </div>
            </div>
            <div class="mb-3">
              <label for="group-title" class="col-form-label">Назва</label>
              <input type="text" class="form-control" id="group-title" v-model="currentGroup.title">
            </div>
            <div id="form-col-2" class="row input-group mb-3">
              <label class="col-form-label col-4 text-right" label-for="group-select">Група</label>
              <select v-model="currentGroup.parent_id" class="col form-select form-select-sm" id="group-select">
								<template v-for="item in groupsSelectOptions">
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
  import TableRow from '../TableRow.vue';
  export default {
    components: {
      Breadcrumbs,
      TableRow
    },
    data() {
      return {
        breadcrumbs: [
          { href: '/dashboard', text: 'Домашня' },
          { href: false, text: 'Групи' },
        ],
        groups: {},
        groupsSelectOptions: {},
				emptyGroup: {
					id: null,
					title: '',
					enabled: 1,
					parent_id: null
				},
				currentGroup: {},
				prevState: {},
        selectedId: null,
      };
    },
    mounted() {
			this.clearGroup();
      this.getGroups();
			this.getGroups(1);
    },
    methods: {
      clearGroup() {
        this.currentGroup = Object.assign({}, this.emptyGroup);
      },
      getGroups(all) {
				var app = this;
        axios.get('/api/groups' + (all ? ('/' + all) : ''))
          .then(function (resp) {
						if (all) {
							app.groupsSelectOptions = resp.data;
							app.groupsSelectOptions.unshift(Object.assign({}, app.emptyGroup));
							app.groupsSelectOptions[0].title = 'немає';
						} else {
							app.groups = resp.data;
						}
          })
          .catch(function () {
            alert("Could not load groups!");
          });
      },
      getParents() {
        //
      },
			pushState() {
				this.prevState.enabled = this.currentGroup.enabled;
				this.prevState.title = this.currentGroup.title;
			},
      resetGroup() {
        this.currentGroup.enabled = this.prevState.enabled;
        this.currentGroup.title = this.prevState.title;
      },
      saveGroup() {
        if (!this.currentGroup) return;
        this.currentGroup._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var app = this;
        axios.post('/type/' + this.currentGroup.id, this.currentGroup)
          .then(function (resp) {
            app.getGroups();
          })
          .catch(function (resp) {
            if (resp.response) {
              var message = resp.response.data.message;
              var errors = resp.response.data.errors;
            }
          });
      },
      selectGroup(grp) {
				if (!grp) return;
				this.currentGroup = grp;
				this.pushState();
				this.currentGroup.enabled = !!this.currentGroup.enabled;
      },
    }
  };
</script>