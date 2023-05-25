<x-app-layout>

    <div class="flex items-center mb-4">
        <div class="flex-1 flex items-center gap-2 font-semibold text-base text-gray-500">
            <a class="text-black flex items-center gap-2" href={{ route('admin.dashboard') }}>
                <i class="fa-solid fa-house text-sm"></i> Home
            </a>
            <i class="fa-solid fa-angle-right text-sm"></i>
            Radios
        </div>
        <div>
            <x-button-link href="{{ route('admin.radios.create') }}">Create Radio</x-button-link>
        </div>
    </div>

    <x-cards.main>
        <h2 class="font-medium text-2xl mb-4">Radios</h2>
        <table>
            @foreach($radios as $key => $radio)
            <tr>
                <td class="pt-4 text-2xl">{{ $key }}</td>
            </tr>
            @foreach($radio as $field)
            <tr>
                <td>
                    <a href="{{ route('admin.radios.edit', $field) }}">
                        {{ $field->field }}
                    </a>
                </td>
                <td>
                    {{ $field->name }}
                </td>
                <td>
                    {{ $field->order }}
                </td>
            </tr>
            @endforeach
            @endforeach
        </table>
    </x-cards.main>

</x-app-layout>