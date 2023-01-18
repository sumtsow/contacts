<template>
  <option :value="group.id">
	{{ indent }}{{ group.title }}
  </option>
	<template v-for="child of group.children">
		<group-option v-if="group.enabled" :group="child" :indent="'&nbsp;&nbsp;' + indent"></group-option>
	</template>
</template>
 
<script>
	export default {
		props: [ 'group', 'indent' ],
	};
</script>