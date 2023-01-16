<template>
  <li class="list-group-item list-group-item-primary" :class="'group-' + group.id">
		<div class="row">
			<div class="col">
			{{ group.title }}
			</div>
		</div>
		<ul class="list-group list-group-flush" v-for="child of group.children">
			<group-item v-if="!group.parent_id && group.enabled" :group="child"></group-item>
		</ul>
		<ul class="list-group list-group-flush" v-for="subscriber of groupInfo.subscriber">
			<li class="list-group-item" v-if="subscriber.enabled">
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
          })
          .catch(function () {
            alert('Could not load groups!');
						return false;
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
		props: [ 'group' ],
	};
</script>