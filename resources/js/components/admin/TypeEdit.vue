<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Тип {{ type.id }}</h1>
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
          { href: '/#admin/types', text: 'Типи' },
          { href: false, text: 'Тип ' + this.$route.params.id},
        ],
        type: {
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