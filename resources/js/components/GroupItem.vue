<template>
  <li class="list-group-item bg-secondary text-white p-0" :class="'group-' + group.id">
		<div class="m-3" :class="'h' + level">{{ group.title }}</div>
		<ul class="list-group list-group-flush" :class="{'d-none': group.hidden, 'd-block': !group.hidden}" v-for="child of group.children">
			<group-item v-if="!group.parent_id && group.enabled" :group="child" :level="hlevel"></group-item>
		</ul>
		<ul class="list-group list-group-flush" v-for="subscriber of groupInfo.subscriber">
			<li class="list-group-item border-bottom px-0" v-if="subscriber.enabled">
				<div class="row">
					<div class="col">{{ subscriber.lastname }} {{ subscriber.firstname }}</div>
					<div class="col">
						<template v-for="contact of subscriber.contact">
						<p v-if="contact.enabled">
							{{ contact.type.title }}: {{ contact.value }}
						</p>
						</template>
					</div>
				</div>
			</li>
		</ul>
	</li>
</template>
 
<script>
	export default {
		computed: {
			hlevel() {
				return this.level < 6 ? this.level + 1 : this.level;
			}
		},
		methods: {
			getGroupInfo() {
				var gid = this.group.id;
				if (!gid) return;
				gid = parseInt(gid, 10);
				if (isNaN(gid)) return;
				var app = this;
        axios.get('/api/group/' + gid)
          .then(function (resp) {
						app.groupInfo = resp.data[0];
						app.groupInfo.hidden = false;
						app.groupInfo.children.forEach((group) => {
							group.hidden = false;
						});
          })
          .catch(function () {
            alert('Could not load groups!');
          });
			},
		},
		mounted() {
			this.getGroupInfo();
		},
		data: function () {
      return {
				groupInfo: {},
      };
    },
		props: [ 'group', 'level' ],
	};
</script>