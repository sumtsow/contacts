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
    <h1>Група {{ group.id }}</h1>
  </div>
</template>
<script>
  export default {
    data: function () {
      return {
        breadcrumbs: [
          { href: '/dashboard', text: 'Домашня' },
          { href: '/#admin/groups', text: 'Групи' },
          { href: false, text: 'Група' + this.$route.params.id},
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