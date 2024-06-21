<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form post :action="route('question.store')">
                <div class="mb-4">
                    <x-textarea label="Question" name="question"/>
                    <x-btn.primary>
                        Save
                    </x-btn.primary>

                    <x-btn.reset>
                        Cancel
                    </x-btn.reset>
                </div>
            </x-form>

            <hr class="border-gray-700 border-dashed my-4">

            {{-- Listagem --}}

            <div class="dark:text-gray-400 uppercase font-bold">
                drafts
            </div>


            <div class="dark:text-gray-400 space-y-4">
                <x-table>
                    <x-thead>
                        <tr>

                            <x-th>Question</x-th>
                            <x-th>Actions</x-th>

                        </tr>
                    </x-thead>
                    <tbody>
                        @foreach($questions->where('draft', true) as $question)
                            <x-tr>
                                <x-td>{{$question->question}}</x-td>
                                <x-td>

                                    <x-form :action="route('question.destroy', $question)" delete>

                                        <x-btn.primary type="submit">
                                            Deletar
                                        </x-btn.primary>

                                    </x-form>

                                    <x-form :action="route('question.publish', $question)" put>

                                        <x-btn.primary type="submit">
                                            Publicar
                                        </x-btn.primary>

                                    </x-form>


                                    <a href="{{ route('question.edit', $question) }}" class="hover:underline text-blue-500">Editar</a>
                                </x-td>
                            </x-tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>

            <hr class="border-gray-700 border-dashed my-4">

            {{-- Listagem --}}

            <div class="dark:text-gray-400 uppercase font-bold">
                My Questions
            </div>


            <div class="dark:text-gray-400 space-y-4">
                <x-table>
                    <x-thead>
                        <tr>

                            <x-th>Question</x-th>
                            <x-th>Actions</x-th>

                        </tr>
                    </x-thead>
                    <tbody>
                    @foreach($questions->where('draft', false) as $question)
                        <x-tr>
                            <x-td>{{$question->question}}</x-td>
                            <x-td>

                                <x-form :action="route('question.destroy', $question)" delete >

                                    <x-btn.primary type="submit">
                                        Deletar
                                    </x-btn.primary>

                                </x-form>

                                <x-form :action="route('question.archive', $question)" patch>

                                    <x-btn.primary type="submit">
                                        Arquivar
                                    </x-btn.primary>

                                </x-form>
                            </x-td>
                        </x-tr>
                    @endforeach
                    </tbody>
                </x-table>
            </div>
        </div>
    </div>

    <hr class="border-gray-700 border-dashed my-4">

    <div class="text-center">

        <div class="dark:text-gray-400 uppercase font-bold">
            Archived Questions
        </div>


        <div class="dark:text-gray-400 space-y-4">
            <x-table>
                <x-thead>
                    <tr>

                        <x-th>Question</x-th>
                        <x-th>Actions</x-th>

                    </tr>
                </x-thead>
                <tbody>
                @foreach($archivedQuestions->where('draft' , false) as $question)
                    <x-tr>
                        <x-td>{{$question->question}}</x-td>
                        <x-td>

                            <x-form :action="route('question.destroy', $question)" delete>

                                <x-btn.primary type="submit">
                                    Deletar
                                </x-btn.primary>

                            </x-form>

                            <x-form :action="route('question.restore', $question)" patch>

                                <x-btn.primary type="submit">
                                    Restaurar
                                </x-btn.primary>

                            </x-form>
                        </x-td>
                    </x-tr>
                @endforeach
                </tbody>
            </x-table>
        </div>

    </div>
</x-app-layout>
