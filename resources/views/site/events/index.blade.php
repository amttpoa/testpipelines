<x-site-layout>
    @section("pageTitle")
    Events
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">Events</div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="h-max max-w-4xl bg-white mx-auto p-6 py-12">

            @guest
            <div class="text-lg text-center">
                <div class="text-2xl">
                    <x-a href="{{ route('login') }}">Login</x-a> or <x-a href="{{ route('register-choice') }}">Sign Up</x-a>
                </div>
                <div>to view our events</div>
            </div>
            @endguest

            @auth

            @if($events->isEmpty())
            <div class="text-center text-lg text-red-700 mb-8">
                There are no upcoming events
            </div>

            @else
            <div class="text-center text-lg mb-8">
                Here are the upcoming events sponsored by the OTOA
            </div>
            <div class="border-t border-otgray">
                @foreach($events as $event)

                <a href="{{ route('events.show', $event) }}">
                    <div class="md:grid md:grid-cols-2 md:gap-3 md:items-center border-b border-otgray p-4">
                        <div>
                            <div class="text-2xl font-medium">{{ $event->name }}</div>
                            <div class="text-lg font-medium">
                                <span class="font-medium">{{ $event->start_date->format('m/d/Y') }}</span>
                                <span class="text-otgray ml-3">
                                    {{ $event->start_date->format('H:i') }} -
                                    {{ $event->end_date->format('H:i') }}
                                </span>
                            </div>
                            <div class="text-otgray text-sm">{{ $event->region ? 'Region ' . $event->region : '' }}</div>
                        </div>
                        <div>
                            @if($event->venue)
                            <div class="font-medium text-lg">{{ $event->venue->name }}</div>
                            @endif
                            @if($event->user)
                            <div>
                                Hosted by:
                                <span class="font-medium">{{ $event->user->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            @endauth
        </div>
    </div>

</x-site-layout>