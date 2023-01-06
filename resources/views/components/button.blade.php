<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary ms-3 float-end']) }}>
    {{ $slot }}
</button>
