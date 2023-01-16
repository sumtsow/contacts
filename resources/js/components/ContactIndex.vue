<template>
  <div>
    <h1>Контакти</h1>
  </div>
	<div class="row">
		<div class="col">
			<label for="group-select-box" class="form-label">Показати:</label>
			<select v-model="selectedGroups" id="group-select-box" multiple class="form-select multiple mb-3">
				<template v-for="group of selectedGroupOptions">
				<group-option v-if="!group.parent_id && group.enabled" :group="group"></group-option>
				</template>
			</select>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div v-for="header of tableHeaders" class="col">{{ header }}</div>
		</div>
		<ul class="list-group list-group-flush">
			<template v-for="group of groups">
			<group-item v-if="!group.parent_id && group.enabled" :group="group"></group-item>
			</template>
		</ul>
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
				tableHeaders: [
					'Прізвище та ім\'я',
					'Контакти'
				],
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
          })
          .catch(function () {
            alert('Could not load groups!');
          });
      },
			filterGroups() {
				
			},
    }
  };
</script>