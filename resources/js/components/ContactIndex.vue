<template>
  <div>
    <h1>Контакти</h1>
  </div>
	<div class="row">
		<div class="col">
			<label for="group-select-box" class="form-label">Показати:</label>
			<select v-model="selectedGroups" id="group-select-box" multiple class="form-select multiple mb-3" @change="filterGroups" :size="selectSize">
				<template v-for="group of selectedGroupOptions">
				<group-option v-if="group.enabled" :group="group" :indent="''"></group-option>
				</template>
			</select>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col">
				<template v-for="group of groups">
					<ul class="list-group list-group-flush" :class="{'d-none': group.hidden}">
					<group-item v-if="!group.parent_id && group.enabled" :group="group" :level="defaultHeaderLevel"></group-item>
				</ul>
				</template>
			</div>
		</div>
	</div>
</template>
<script>
	import GroupItem from './GroupItem.vue';
	import GroupOption from './GroupOption.vue';
  export default {
		components: {
      GroupItem,
			GroupOption,
    },
		computed: {
			selectSize() {
				return Math.min(this.groups.length + 1, 10);
			},
		},
    data() {
      return {
        groups: [],
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
    },
    methods: {
      getGroups() {
				var app = this;
        axios.get('/api/groups')
          .then(function (resp) {
						app.groups = resp.data;
						app.selectedGroupOptions = app.groups.slice();
						app.selectedGroupOptions.unshift(app.emptyGroup);
						app.selectedGroupOptions[0].title = 'Всі';
						app.resetGroupsHidden(app.groups, true);
          })
          .catch(function () {
            alert('Could not load groups!');
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