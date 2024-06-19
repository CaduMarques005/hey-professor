<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vote for a question') }}
        </h2>
    </x-slot>


                        {{-- Listagem --}}

            <div class="dark:text-gray-400 uppercase font-bold">List of Questions:</div>


            <div class="dark:text-gray-400 space-y-4">

                @foreach($questions as $item)
                <x-question :question="$item" />


                @endforeach
            </div>

</x-app-layout>
