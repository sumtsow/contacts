<template>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Головна</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownMenu" aria-controls="dropdownMenu" aria-expanded="true" aria-label="Переключити">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Authentication Links -->
      <template v-if="user">
      <div id="dropdownMenu" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true">{{ user }}</a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/dashboard">Домашня</a>
              </li>
              <li>
                <a class="dropdown-item" href="#" v-on:click.prevent="logOut">Вийти</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      </template>
      <a v-else class="nav-link ms-3" href="/login">Увійти</a>
    </div>
    <form class="d-none" name="logout" action="/logout" method="post">
      <input type="hidden" name="_token" v-bind:value="csrf" />
    </form>
  </nav>
</template>
 
<script>
	export default {
		data: function () {
			return {
              	user: document.querySelector('meta[name="user"]').getAttribute('content'),
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
			};
		},
		mounted() {
          //
		},
		methods: {
			logOut() {
				document.forms.logout.submit();
			},
		},
    };
</script>