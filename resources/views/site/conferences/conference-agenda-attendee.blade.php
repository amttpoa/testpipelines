<x-site-layout>
    @section("pageTitle")
    {!! $page->name !!}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">Conference Agenda</div>
        <div class="text-base lg:text-lg">for</div>
        <div class="text-xl lg:text-4xl">Attendees</div>
    </x-banner>

    <div class="flex-1 bg-otsteel">
        <div class="max-w-4xl bg-white mx-auto p-6 py-12">

            <div class="mb-8">
                <div class="mb-8">
                    <div class="flex gap-3 items-end py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-3xl">Sunday</div>
                        <div class="flex-1 font-light text-xl">Early Check-in</div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">17:00 - 21:00</div>
                        <div class="flex-1">Attendee Check-in at the Convention Center</div>
                    </div>
                </div>
                <div class="mb-8">
                    <div class="flex gap-3 items-end py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-3xl">Monday</div>
                        <div class="flex-1 font-light text-xl">General Session Day</div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">07:00 - 08:20</div>
                        <div class="flex-1">Attendee Check-in at the Convention Center</div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">08:30 - 16:00</div>
                        <div class="flex-1">
                            General Session &amp; Lecture Series with Critical Incident Debriefing Presentations
                            <div class="font-medium">Kalahari Ballroom</div>
                            <div>
                                <x-a href="{{ route('monday-speakers') }}">FULL details of Monday's presentations</x-a>
                            </div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">18:00 - 21:00</div>
                        <div class="flex-1">
                            Hospitality Night – Meet &amp; Greet Dinner
                            <div class="font-medium">Convention Center</div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">18:00 - 21:00</div>
                        <div class="flex-1">
                            Live-Fire pre-vent
                            <div class="font-medium">Marakesh Bar</div>
                        </div>
                    </div>
                </div>
                <div class="mb-8">
                    <div class="flex gap-3 items-end py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-3xl">Tuesday</div>
                        <div class="flex-1 font-light text-xl">Vendor Show Day</div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">09:00 - 16:00</div>
                        <div class="flex-1">
                            Vendor Exhibition
                            <div class="font-medium">Convention Center</div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">09:00 - 16:00</div>
                        <div class="flex-1">
                            Break–Out Training Courses
                            <div class="font-medium">Executive Center &amp; Convention Center</div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">16:30 - 19:30</div>
                        <div class="flex-1">
                            Vendor Day Live-Fire
                            <div class="font-medium">Erie County Conservation League</div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">17:00 - 19:00</div>
                        <div class="flex-1">
                            Barbeque Dinner
                            <div class="font-medium">Erie County Conservation League</div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">18:00</div>
                        <div class="flex-1">
                            Door prizes awarded <span class="text-otgray text-xs ml-2">(must be present to win)</span>
                            <div class="font-medium">Erie County Conservation League</div>
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">16:00 - 20:00</div>
                        <div class="flex-1">
                            Roundtrip bus service &amp; transportation to Erie County Conservation League
                            <div class="text-xs">Parking is restricted, and we have arranged for executive-caliber buses to drive a continual loop from Kalahari to the Erie County Conservation League.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex gap-3 items-end py-2 border-b border-otgray">
                        <div class="font-medium text-3xl">Wednesday</div>
                        <div class="flex-1 font-light text-xl">Training Day &amp; Awards Banquet</div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">08:00 - 16:00</div>
                        <div class="flex-1">
                            Training Courses
                        </div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">18:00 - 20:30</div>
                        <div class="flex-1">
                            Awards Banquet
                            <div class="font-medium">Kalahari Ballroom</div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex gap-3 items-end py-2 border-b border-otgray">
                        <div class="font-medium text-3xl">Thursday & Friday</div>
                        <div class="flex-1 font-light text-xl">Training Days</div>
                    </div>
                    <div class="lg:flex lg:gap-3 lg:items-center py-2 border-b border-otgray">
                        <div class="w-32 font-medium text-lg">08:00 - 16:00</div>
                        <div class="flex-1">
                            Training Courses
                        </div>
                    </div>
                </div>



            </div>

            <div class="flex gap-3">
                <div class="font-medium whitespace-nowrap">Meals provided:</div>
                <div>
                    Dinner – Monday, Tuesday & Wednesday ONLY<br>
                    Breakfast and lunch on your own all days
                </div>
            </div>

            <div class="prose max-w-full hidden">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-site-layout>