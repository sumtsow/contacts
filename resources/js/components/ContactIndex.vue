<template>
  <div>
    <h1>Контакти</h1>
  </div>
	<div class="row">
		<div class="col">
			<label for="group-select-box" class="form-label">Показати:</label>
			<select v-model="selectedGroups" id="group-select-box" multiple class="form-select multiple mb-3" @change="filterGroups" :size="selectSize">
				<template v-for="group of selectedGroupOptions">
				<group-option :group="group" :indent="''"></group-option>
				</template>
			</select>
		</div>
	</div>
	<div class="container">
		<page-nav :links="pages.links" :handler="getPage"></page-nav>
		<div class="row mb-3">
			<div class="col">
				<template v-for="group of groups">
					<group-item v-if="!group.parent_id" :group="group" :level="defaultHeaderLevel" :subscribers="subscribers"></group-item>
				</template>
			</div>
		</div>
		<page-nav :links="pages.links" :handler="getPage"></page-nav>
	</div>
</template>
<script>
	import GroupItem from './GroupItem.vue';
	import GroupOption from './GroupOption.vue';
	import PageNav from './PageNav.vue';
  export default {
		components: {
      GroupItem,
			GroupOption,
			PageNav,
    },
		computed: {
			selectSize() {
				return Math.min(this.groups.length + 1, 10);
			},
		},
    data() {
      return {
        groups: [],
				pages: {},
				subscribers: [],
				//groupList: [],
				emptyGroup: {
					id: 0,
					title: '',
					enabled: true,
				},
				selectedGroups: [0],
				selectedGroupOptions: [],
				defaultHeaderLevel: 2,
      };
    },
    mounted() {
      this.getGroups();
			this.getSubscribers();
    },
    methods: {
      getGroups() {
				var app = this;
        axios.get('/api/groups')
          .then(function (resp) {
						app.groups = resp.data;
						app.selectedGroupOptions = [...app.groups];
						app.selectedGroupOptions.unshift(app.emptyGroup);
						app.selectedGroupOptions[0].title = 'Всі';
						app.resetGroupsHidden(app.groups, true);
          })
          .catch(function () {
            alert('Could not load groups!');
          });
      },
			getPage(e) {
        this.getSubscribers(parseInt(new URL(e.target.href).searchParams.get('page'), 10));
			},
			getSubscribers(page) {
        var app = this;
        axios.get('/api/subscribers/1' + (page ? '?page=' + page : ''))
          .then(function (resp) {
            app.pages = resp.data.pages;
						//app.groupList = resp.data.groups;
            app.subscribers = app.pages.data;
          })
          .catch(function () {
						app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати контакти!'] };
          });
      },
			filterGroups() {
				this.resetGroupsHidden(this.groups, true);
				this.hideGroups(this.groups, null);
			},
			hideGroups(groups, currentParent) {
				if (!groups) return;
				var app = this;
				var allSelected = this.selectedGroups.includes(0);
				groups.forEach((group) => {
					if (!group.enabled) return;
					if (allSelected) {
						group.hidden = false;
					} else {
						group.hideContacts = group.hidden = !app.selectedGroups.includes(group.id);
						group.parent = currentParent ? currentParent.parent.slice() : [];
						if (currentParent) group.parent.push(currentParent);
						if (group.parent_id && !group.hidden) app.resetGroupsHidden(group.parent, false);
					}
					if (group.hidden && group.children) app.hideGroups(group.children, group);
				});
			},
			resetGroupsHidden(groups, withChildren) {
				if (!groups) return;
				var app = this;
				groups.forEach((group) => {
					if (!group || !group.enabled) return;
					group.hidden = false;
					if (withChildren && group.children) {
						app.resetGroupsHidden(group.children, true);
						group.hideContacts = false;
					}
				});
			},
    }
  };
</script>