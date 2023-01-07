<template>
  <breadcrumbs :breadcrumbs="breadcrumbs"></breadcrumbs>
  <div>
    <h1>Контакт {{ subscriber.id }}</h1>
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
          { href: '/#admin', text: 'Контакти' },
          { href: false, text: 'Контакт ' + this.$route.params.id},
        ],
        subscriber: {
          id: this.$route.params.id,
          group_id: null,
          firstname: '',
          lastname: '',
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