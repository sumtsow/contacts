<template>
  {{ new Date(date).toLocaleString() }}
</template>
 
<script>
	export default {
		props: [ 'date' ],
	};
</script>