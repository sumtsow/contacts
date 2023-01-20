<template>
	<template v-if="group.enabled">
		<option :value="group.id">
		{{ indent }}{{ group.title }}
		</option>
		<template v-for="child of group.children">
			<group-option :group="child" :indent="'&nbsp;&nbsp;' + indent"></group-option>
		</template>
	</template>
</template>
 
<script>
	export default {
		props: [ 'group', 'indent' ],
	};
</script>