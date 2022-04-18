<x-app-layout>
    <x-slot name="header">
        {{ __('Notes Tree') }}
    </x-slot>



    <div class="p-4 bg-white rounded-lg shadow-xs">

        <!-- Sample table page info -->
        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
            <div class="flex justify-center items-center w-12 bg-blue-500">
                <x-icons.exclamation-circle />
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-blue-500">Info</span>
                    <p class="text-sm text-gray-600">You can only see users who are below you in the hierarchy.</p>
                    <p class="text-sm text-gray-600">You can only see the public notes of other users.</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">


            <div class="flex justify-center">
                <div class="mb-3">
                    <form class="space-x-2 flex items-center">
                        <label for="username">Username:</label>
                        <select name="username" id="username"
                                class="form-select appearance-none
                                       block w-full px-3 py-2
                                       text-base font-normal
                                       text-gray-700 bg-white bg-clip-padding bg-no-repeat
                                       border border-solid border-gray-300 rounded
                                       transition ease-in-out m-0
                                       focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        >
                            <option value="">Please select</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->username }}" @selected( request('username') == $user->username )>
                                    {{ $user->id }} - {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                        <x-button>Go</x-button>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                        <th class="px-4 py-3">id</th>
                        <th class="px-4 py-3">user_id</th>
                        <th class="px-4 py-3">body</th>
                        <th class="px-4 py-3">is_private</th>
                        <th class="px-4 py-3">created_at</th>
                        <th class="px-4 py-3">updated_at</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @unless( empty($notes) )
                        @foreach($notes as $note)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $note->id }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $note->user_id }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $note->body }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $note->is_private ? 'true':'false' }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $note->created_at }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $note->updated_at }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <x-link-button href="{{ route('notes.edit', $note) }}">Edit</x-link-button>
                                </td>
                            </tr>
                        @endforeach
                        @if($notes->total() == 0)
                            <tr class=" text-gray-500 text-xl text-center">
                                <td colspan="7" class="p-6">Public notes not found!</td>
                            </tr>
                        @endif
                    @else
                        <tr class=" text-gray-500 text-xl text-center">
                            <td colspan="7" class="p-6">Notes not found!</td>
                        </tr>
                    @endunless
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                @if($notes instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{ $notes->links() }}
                @endif
            </div>

        </div>

    </div>
</x-app-layout>
