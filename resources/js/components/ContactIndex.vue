<template>
  <div>
    <h1>Контакти</h1>
  </div>
	<div class="row">
		<div class="col table-responsive">
			<table class="table table-striped">
				<thead>
          <tr>
						<th v-for="header of tableHeaders" class="col">{{ header }}</th>
					</tr>
				</thead>
				<tbody>
					<template v-for="group of groups">
						<group-item :group="group" v-if="group.enabled"></group-item>
					</template>
				</tbody>
			</table>
		</div>
	</div>
</template>
<script>
	import GroupItem from './GroupItem.vue';
  export default {
		components: {
      GroupItem,
    },
    data() {
      return {
        groups: [],
				tableHeaders: [
					'Прізвище та ім\'я',
					'Контакти'
				],
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
          })
          .catch(function () {
            alert('Could not load groups!');
          });
      },
    }
  };
</script>