<x-email-layout>

    <x-slot name="name">
        {{ $name }}
    </x-slot>

    <div>
        {!! $email_body !!}
    </div>

</x-email-layout>