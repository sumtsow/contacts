<template>
	<ul v-if="group.enabled" class="list-group list-group-flush">
		<li class="list-group-item bg-secondary text-white p-0">
			<div class="m-3" :class="'h' + level">{{ group.title }}</div>
			<ul v-for="subscriber of subscribers" class="list-group list-group-flush">
				<li v-if="subscriber.enabled && subscriber.group_id === group.id" class="list-group-item border-bottom px-0" :class="{'d-none': group.hideContacts}">
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
	</ul>
</template>
 
<script>
	export default {
		computed: {
			hlevel() {
				return this.level < 6 ? this.level + 1 : this.level;
			},
		},
		props: [ 'group', 'level', 'subscribers' ],
	};
</script>