<x-app-layout>
    <x-slot name="header">
        <h1>{{ __('app.home') }}</h1>
    </x-slot>

    <div class="py-12">
        <div class="row">
            <div class="col">
                <div class="alert alert-success">
                    {{ __('app.logged_in') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
