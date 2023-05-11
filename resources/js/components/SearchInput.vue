<template>
  <label for="search-input" class="form-label">Знайти:</label>
	<input type="search" class="form-control" @keyup="handler" @click="clearField" />
</template>
 
<script>
	export default {
		props: [ 'handler' ],
		methods: {
			clearField(e) {
				var app = this,
						evt = e;
				if (e.target.value) {
					setTimeout(() => { if (!evt.target.value) app.handler(evt); }, 100, evt);
				}
			},
		},
	};
</script>