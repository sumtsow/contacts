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
  <div>
    <h1>Контакт {{ subscriber.id }}</h1>
  </div>
</template>
<script>
  export default {
    data: function () {
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