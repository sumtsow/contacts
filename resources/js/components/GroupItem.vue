<template>
	<ul v-if="group.enabled" class="list-group list-group-flush" :class="{'d-none': group.hidden}">
		<li class="list-group-item bg-secondary text-white p-0">
			<div class="m-3" :class="'h' + level">{{ group.title }}</div>
			<ul v-for="subscriber of group.subscriber" class="list-group list-group-flush">
				<li v-if="subscriber.enabled" class="list-group-item border-bottom px-0" :class="{'d-none': group.hideContacts}">
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
			<template v-for="child of group.children">
				<group-item :group="child" :level="hlevel"></group-item>
			</template>
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
		props: [ 'group', 'level' ],
	};
</script>