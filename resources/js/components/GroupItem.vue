<template>
  <tr>
		<th colspan="2" class="bg-secondary text-light">{{ group.title }}</th>
  </tr>
	<template v-for="subscriber of groupInfo.subscriber">
	<tr v-if="subscriber.enabled">
		<td class="w-auto">{{ subscriber.lastname }} {{ subscriber.firstname }}</td>
		<td>
			<template v-for="contact of subscriber.contact">
			<p v-if="contact.enabled">
				{{ contact.type.title }}: {{ contact.value }}
			</p>
			</template>
		</td>
	</tr>
	</template>
	<template v-for="child of group.children" v-if="group.enabled">
		<group-item :group="child"></group-item>
	</template>
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