<template>
  <div>
    <h1>Контакти</h1>
  </div>
	<div class="row">
		<div class="col">
			<search-input :handler="searchSubscribers"></search-input>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<label for="group-select-box" class="form-label">Показати:</label>
			<select v-model="selectedGroupId" id="group-select-box" class="form-select mb-3" @change="getSubscribers" :size="selectSize">
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
				<TransitionGroup>
					<template v-for="group of groups" :key="group.id">
						<group-item :group="group" :level="defaultHeaderLevel" :subscribers="subscribers"></group-item>
					</template>
				</TransitionGroup>
			</div>
		</div>
		<page-nav :links="pages.links" :handler="getPage"></page-nav>
	</div>
</template>
<script>
	import GroupItem from './GroupItem.vue';
	import GroupOption from './GroupOption.vue';
	import PageNav from './PageNav.vue';
	import SearchInput from './SearchInput.vue';
  export default {
		components: {
      GroupItem,
			GroupOption,
			PageNav,
			SearchInput,
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
				emptyGroup: {
					id: 0,
					title: '',
					enabled: true,
				},
				selectedGroupId: 0,
				selectedGroupOptions: [],
				defaultHeaderLevel: 2,
				searchText: '',
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
						app.selectedGroupOptions = [...resp.data];
						app.selectedGroupOptions.unshift(app.emptyGroup);
						app.selectedGroupOptions[0].title = 'Всі';
          })
          .catch(function () {
            alert('Could not load groups!');
          });
      },
			getPage(e) {
				this.getSubscribers(parseInt(new URL(e.target.href).searchParams.get('page'), 10));
			},
			getSubscribers(page) {
        var app = this,
						url = '/api/subscribers/1' + (this.selectedGroupId ? '/' + this.selectedGroupId : '') + '?' + (page ? 'page=' + page + '&' : '') + (this.searchText ? 'q=' + encodeURIComponent(this.searchText) : '');
        axios.get(url)
          .then(function (resp) {
            app.pages = resp.data.pages;
						app.groups = resp.data.groups;
            app.subscribers = app.pages.data;
          })
          .catch(function () {
						app.alert = { message: 'Помилка завантаження',  errors: ['Не вдається отримати контакти!'] };
          });
      },
			searchSubscribers(e) {
				this.searchText = e.target.value;
				this.getSubscribers();
			},
    }
  };
</script>