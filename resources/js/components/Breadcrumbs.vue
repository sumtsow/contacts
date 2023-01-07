<template>
  <div class="row breadcrumb px-3">
    <nav class="nav my-0 py-0" id="breadcrumbs">
      <ul class="breadcrumb m-0 text-truncate">
        <li v-for="item in breadcrumbs" class="breadcrumb-item">
          <a v-bind:class="{'text-dark': !item.href}" v-bind:href="item.href" >{{ item.text }}</a>
        </li>
      </ul>
    </nav>
  </div>
</template>
 
<script>
	export default {
        props: ['breadcrumbs'],
    };
</script>