<x-app-layout>
  <x-slot name="header">
    <h1>{{ __('app.home') }}</h1>
  </x-slot>
  <div class="py-12">
    <div class="row">
      <div class="col">
        @if (str_ends_with(request()->server->get('HTTP_REFERER'), '/login'))
        <div class="alert alert-success alert-dismissible fade show">
          {{ __('app.logged_in') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрити"></button>
        </div>
        @endif
        <h2>Редагувати</h2>
        <ul class="list-group">
          <a href="/#admin" class="list-group-item list-group-item-action">Контакти</a>
          <a href="/#admin/groups" class="list-group-item list-group-item-action">Групи</a>
          <a href="/#admin/types" class="list-group-item list-group-item-action">Типи</a>
        </ul>
      </div>
    </div>
  </div>
</x-app-layout>
