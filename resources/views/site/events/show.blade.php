<x-site-layout>
    @section("pageTitle")
    {!! $event->name !!}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl"><a href="{{ route('events.index') }}">Events</a></div>
        <div class="text-xl lg:text-2xl">{{ $event->name }}</div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="max-w-4xl bg-white mx-auto p-6 py-12">

            @guest
            <div class="text-lg text-center">
                <div class="text-2xl">
                    <x-a href="{{ route('login') }}">Login</x-a> or <x-a href="{{ route('register-choice') }}">Sign Up</x-a>
                </div>
                <div>to view our events</div>
            </div>
            @endguest

            @auth
            <div class="md:grid md:grid-cols-2 md:gap-3 mb-8">
                <div>
                    <div class="text-2xl font-medium">{{ $event->name }}</div>
                    <div class="text-lg font-medium">
                        <span class="font-medium">{{ $event->start_date->format('m/d/Y') }}</span>
                        <span class="text-otgray ml-3">
                            {{ $event->start_date->format('H:i') }} -
                            {{ $event->end_date->format('H:i') }}
                        </span>
                    </div>
                    <div class="">{{ $event->region ? 'Region ' . $event->region : '' }}</div>
                </div>
                <div>
                    @if($event->venue)
                    <div class="font-medium text-lg">{{ $event->venue->name }}</div>
                    <div>
                        {{ $event->venue->address }}<br>
                        {{ $event->venue->city }}, {{ $event->venue->state }} {{ $event->venue->zip }}
                    </div>
                    @endif
                    @if($event->user)
                    <div class="mt-2">
                        Hosted by:
                        <x-a href="{{ route('staffProfile', $event->user) }}" class="font-medium">{{ $event->user->name }}</x-a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mb-8 prose min-w-full">
                {!! $event->description !!}
            </div>

            @if(auth()->user()->eventAttendees->where('event_id', $event->id)->first())
            <x-callouts.info>You are registered for this event.</x-callouts.info>
            @else
            <div class="text-2xl font-medium">Register for this event</div>
            <form method="POST" x-data="{checked:false}" action="{{ route('events.register', $event) }}">
                @csrf
                <div class="my-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" class="hidden" name="terms_agreement" value="true" x-model="checked">
                        <i class="fa-regular fa-square text-4xl" x-show="!checked" style="display:none;"></i>
                        <i class="fa-regular fa-square-check text-4xl" x-show="checked" style="display:none;"></i>
                        <div class="text-lg font-medium leading-tight">
                            I, {{ auth()->user()->name }}, want to go to this event
                        </div>
                    </label>
                </div>
                <x-label for="comments">Comments</x-label>
                <x-input name="comments" maxlength="250" />
                <button :disabled="!checked" disabled class="mt-4 w-full px-4 py-1.5 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium px-16">Register</button>

            </form>
            @endif


            @endauth
        </div>
    </div>


</x-site-layout>