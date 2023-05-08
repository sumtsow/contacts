<template>
  <nav aria-label="Сторінки">
		<ul class="pagination justify-content-center">
			<li v-for="link of links" class="page-item overflow-hidden text-nowrap">
				<a class="page-link" :class="{ active: link.active, disabled: !link.url }" :href="link.url" v-html="link.label" @click.prevent="handler"></a>
			</li>
		</ul>
	</nav>
</template>
 
<script>
	export default {
		props: [ 'links', 'handler' ],
	};
</script>