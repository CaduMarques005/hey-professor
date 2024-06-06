@props([
    'tittle' => 'título padrão',
    'param1'
])

<div>

    <div class="text-black font-bold uppercase p-2">
        {{ $tittle }}
    </div>

<div class="text-lg text-red-600 font-bold bg-red-50 p-20 border-red-300">
    {{ $slot }}
</div>

</div>
