<x-site-layout>
    @section("pageTitle")
    {{ $conference->name }} Registration
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-xl lg:text-2xl"><a href="{{ route('conference', $conference) }}">{{ $conference->name }}</a></div>
        <div class="text-3xl lg:text-6xl">Register</div>
    </x-banner>


    <div class="py-16 bg-otsteel flex-1">

        <div class="mx-auto max-w-3xl px-6 py-4 bg-white shadow flex flex-col gap-4">
            <div class="text-3xl font-bold font-blender text-center">Who Are You?</div>
            <div>
                <a href="{{ route('conference.register', $conference) }}" class="flex gap-6 items-center bg-otblue border border-otblue px-6 py-4 text-white hover:bg-otblue-700">
                    <div>
                        <x-icons.gun class="w-12 h-12" />
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-2xl">
                            First Responder
                        </div>
                        <div>
                            Must be sworn law enforcement, federal law enforcement, retired LE, military, corrections, Fire, EMS or TEMS
                        </div>
                    </div>
                </a>
            </div>
            <div>

                <form method="POST" action="{{ route('conference.register-civilian', $conference) }}">
                    @csrf
                    <button class="w-full flex gap-6 items-center bg-otgray border border-otgray px-6 py-4 text-white hover:bg-otgray-700">

                        <div>
                            <x-icons.users class="w-12 h-12" />
                        </div>
                        <div class="flex-1 text-left">
                            <div class="font-medium text-2xl">
                                Civilian
                            </div>
                            <div>
                                You are not associated with any law enforcement agency
                            </div>
                        </div>
                    </button>
                </form>
            </div>


        </div>

    </div>
</x-site-layout>