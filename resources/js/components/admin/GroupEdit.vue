<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Група {{ group.id }}</h1>
  </div>
</template>
<script>
  import Breadcrumbs from '../Breadcrumbs.vue';
  export default {
    components: {
      Breadcrumbs
    },
    data() {
      return {
        breadcrumbs: [
          { href: '/dashboard', text: 'Домашня' },
          { href: '/#admin/groups', text: 'Групи' },
          { href: false, text: 'Група ' + this.$route.params.id},
        ],
        group: {
          id: this.$route.params.id,
          title: '',
          enabled: '',
          created_at: null,
          updated_at: null
        },
      };
    },
    mounted() {
      //
    },
    methods: {
      //
    }
  };
</script>