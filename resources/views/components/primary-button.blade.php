<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary inline-flex items-center justify-center gap-2']) }}>
    {{ $slot }}
</button>
