<template>
  <div>
    <h1>Контакти</h1>
  </div>
	<div class="row">
		<div class="col">
			<label for="group-select-box" class="form-label">Показати:</label>
			<select v-model="selectedGroups" id="group-select-box" multiple class="form-select multiple mb-3" @change="filterGroups">
				<template v-for="group of selectedGroupOptions">
				<group-option v-if="!group.parent_id && group.enabled" :group="group" :indent="''"></group-option>
				</template>
			</select>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col">
				<template v-for="group of groups">
					<ul class="list-group list-group-flush" :class="{'d-none': group.hidden}">
					<group-item v-if="!group.parent_id && group.enabled" :group="group" :level="2"></group-item>
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
						app.groups.forEach((group) => {
							group.hidden = false;
							group.children.forEach((child) => {
								child.hidden = false;
							});
						});
          })
          .catch(function () {
            alert('Could not load groups!');
          });
      },
			filterGroups() {
				this.hideGroups(this.groups);
			},
			hideGroups(groups) {
				var app = this;
				groups.forEach((group) => {
					if (app.selectedGroups.includes(0)) {
						group.hidden = false;
					} else {
						group.hidden = !app.selectedGroups.includes(group.id);
					}
					//if (group.children) app.hideGroups(group.children);
				});
			},
    }
  };
</script>