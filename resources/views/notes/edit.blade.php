<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Note') }}
    </x-slot>

    @if ($message = Session::get('success'))
        <div class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-center w-12 bg-green-500">
                <x-icons.check-circle />
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Success</span>
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete button -->
    <div class="mb-4">
        <form action="{{ route('notes.destroy', $note) }}" method="POST">
            @method('DELETE')
            @csrf
            <x-button class="">{{ __('Delete') }}</x-button>
        </form>
    </div>

    <div class="p-4 bg-white rounded-lg shadow-md">

        <form action="{{ route('notes.update', $note) }}" method="POST">
            @method('PATCH')
            @csrf

            <!-- body -->
            <div class="mt-4">
                <x-label for="body" :value="__('Body')"/>
                <x-input type="text"
                         id="body"
                         name="body"
                         class="block w-full"
                         value="{{ old('body', $note->body) }}"
                />
                @error('body')
                <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- status -->
            <div class="mt-4">
                <x-label for="status" :value="__('Status')"/>
                <select name="status" id="status">
                    @foreach($statuses as $status)
                        <option @selected($note->status) value="{{ $status->value }}">{{ $status->getName() }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mt-4">
                <x-button class="block w-full">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>

    </div>
</x-app-layout>
