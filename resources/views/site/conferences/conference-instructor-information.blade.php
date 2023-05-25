<x-site-layout>
    @section("pageTitle")
    Conference Instructor Information
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Conference Instructor Information</div>
    </x-banner>


    <div class="flex-1 bg-otsteel">
        <div class="max-w-5xl h-full mx-auto bg-white shadow p-6 py-10">

            {{-- @guest
            <div class="text-center">
                <div class="font-medium text-xl">
                    This page is for conference instructors only. Please login to view conference instructor information.
                </div>
                <div class="mt-5">
                    <x-button-link-site href="{{ route('login') }}" class="text-xl">Login</x-button-link-site>
                </div>
            </div>
            @endguest



            @auth

            @can('conference-instructor') --}}
            <div class="prose max-w-full sponsorships">
                {!! $information->content !!}
            </div>
            {{-- @else
            <div class="font-medium text-xl text-center">
                This page is for conference instructors only.
            </div>
            @endcan

            @endauth --}}



        </div>
    </div>

</x-site-layout>