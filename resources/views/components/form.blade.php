@props([
    'action',
    'post' => null,
    'patch' => null,
    'put' => null,
    'delete' => null,
])

<form action="{{ $action }}" method="POST">
@csrf

    @if($put)
            @method('PUT')
    @endif

    @if($patch)
            @method('patch')
    @endif

    @if($delete)
            @method('delete')
    @endif


        {{ $slot }}
</form>
