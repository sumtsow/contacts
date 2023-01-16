<template>
  <option :value="group.id">
		{{ group.title }}
  </option>
	<template v-for="child of group.children">
		<group-option v-if="group.enabled" :group="child"></group-option>
	</template>
</template>
 
<script>
	export default {
		props: [ 'group' ],
	};
</script>