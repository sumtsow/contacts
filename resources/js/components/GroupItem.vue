<template>
  <li class="list-group-item bg-secondary text-white p-0">
		<div class="m-3" :class="'h' + level">{{ group.title }}</div>
		<template v-for="child of group.children">
		<ul class="list-group list-group-flush" :class="{'d-none': child.hidden}">
			<group-item v-if="group.enabled" :group="child" :level="hlevel"></group-item>
		</ul>
		</template>
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
	</li>
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