<x-dashboard.layout>
    @section("pageTitle")
    Hotel Reservation Edit
    @endSection

    <x-breadcrumbs.holder>
        Hotel Reservation Edit
    </x-breadcrumbs.holder>

    <div class="max-w-xl">
        <div class="mb-4">
            Please let us know about your hotel preference for the
            {{ $conference->name}}.
        </div>

        @if(auth()->user()->can('conference-instructor'))
        <div class="mb-4">
            The OTOA will cover the lodging expenses at Kalahari for the primary instructor and assistant instructors for the following:
            <ul class="list-disc ml-8 mt-4">
                <li>The night before the 1st day of the training</li>
                <li>Night (s) of the training (including the last day of training)</li>
            </ul>
        </div>
        <div class="mb-4">
            <span class="font-medium">Example 1</span> - Teaching a conference training course on Wednesday ONLY -
            OTOA will cover the room for Tuesday and Wednesday<br>

            <span class="font-medium">Example 2</span> - Teaching a conference training course on Wednesday & Thursday -
            OTOA will cover the room for Tuesday and Wednesday, and Thursday
        </div>
        <div class="mb-4">
            If a conference instructor wants to extend his stay at Kalahari BEFORE or AFTER the established parameters, the instructor agrees to pay the per-night room rate.
            OTOA requests that all instructors traveling with assistant instructors book double occupancy rooms.
        </div>
        @else
        <div class="mb-4">
            All rooming is double occupancy.
            If you would like your own room then you pay half the price for the room.
        </div>
        @endif

        <div class="mb-4">
            Please let us know any questions or special requests below or contact - the OTOA office at:
            <x-a href="mailto:office@otoa.org">office@otoa.org</x-a>
        </div>

        <div class="" x-data="payHandler()">
            <form method="POST" action="{{ route('dashboard.staff.conferences.hotel-edit-post',  $conference) }}">
                @csrf
                @method('PATCH')

                <div class="border border-otgray rounded-md overflow-hidden">
                    <label class="flex px-4 py-2 gap-4 bg-otgray-200 items-center">
                        <input type="radio" name="room_type" x-model="room_type" value="No Room" @change="checkComplete" />
                        <div class="flex-1">
                            <div class="font-bold text-xl">I don't need a room</div>
                            @if(auth()->user()->can('conference-instructor'))
                            <div class="">I agree with the instructor lodging parameters for covered expenses above</div>
                            @else
                            <div class="">You live close enough or have other accommodations</div>
                            @endif
                        </div>
                    </label>
                </div>

                <div class="mt-4 border border-otgray rounded-md overflow-hidden">
                    <label class="flex px-4 py-2 gap-4 bg-otgray-200 items-center">
                        <input type="radio" name="room_type" x-model="room_type" value="Single" @change="checkComplete" />
                        <div class="flex-1">
                            <div class="font-bold text-xl">I want my own room</div>
                            @if(auth()->user()->can('conference-instructor'))
                            <div class="">I agree with the instructor lodging parameters for covered expenses above</div>
                            @else
                            <div class="">You will be responsible for paying 1/2 the room rate</div>
                            @endif
                        </div>
                    </label>
                </div>

                <div class="mt-4 border border-otgray rounded-md overflow-hidden">
                    <label class="flex px-4 py-2 gap-4 bg-otgray-200 items-center">
                        <input type="radio" name="room_type" x-model="room_type" value="Double" @change="checkComplete" />
                        <div class="flex-1">
                            @if(auth()->user()->can('conference-instructor'))
                            <div class="font-bold text-xl">I'll bunk with my assistant instructor</div>
                            <div class="">I agree with the instructor lodging parameters for covered expenses above</div>
                            @else
                            <div class="font-bold text-xl">I'll bunk with someone</div>
                            <div class="">OTOA will pay for your room</div>
                            @endif
                        </div>
                    </label>
                    <div x-show="room_type == 'Double'" class="p-4">
                        <div class="mb-4 max-w-sm">
                            <x-label for="roommate">Requested roommate</x-label>
                            <x-input id="roommate" name="roommate" x-model="roommate" type="text" @change="checkComplete" />
                        </div>
                        @csrf
                    </div>
                </div>

                <div class="flex gap-6 mt-4" x-show="room_type=='Single' || room_type=='Double'">
                    <div>
                        <x-label for="start_date">Check In</x-label>
                        <x-input type="date" name="start_date" x-model="start_date" min="{{ $conference->start_date->addDays(-2)->toDateString() }}" max="{{ $conference->end_date->addDays(-1)->toDateString() }}" @change="checkComplete" />
                    </div>
                    <div>
                        <x-label for="end_date">Check Out</x-label>
                        <x-input type="date" name="end_date" x-model="end_date" min="{{ $conference->start_date->addDays(1)->toDateString() }}" max="{{ $conference->end_date->addDays(2)->toDateString() }}" @change="checkComplete" />
                    </div>
                </div>

                <div class="mt-4" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                    <div class=" text-right">
                        <div class="pr-2 text-xs text-otsteel-500"><span x-html="count"></span> of <span x-html="$refs.countme.maxLength"></span> character limit</div>
                    </div>
                    <x-textarea id="comments" name="comments" rows="3" maxlength="250" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" placeholder="Special requests">{!! auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->comments !!}</x-textarea>
                </div>


                <div class="form-group text-center mt-4">
                    <button :disabled="!buttonActive" class="w-full px-4 py-1.5 shadow-md bg-otgold border border-otgold text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150 text-2xl font-medium px-16">Submit</button>
                </div>
            </form>

        </div>
    </div>


    <script type="text/javascript">
        function payHandler() {
            return {                
                roommate: '{{ auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->roommate }}',
                room_type: '{{ auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->room_type }}',
                buttonActive: false,

                start_date: '{{ auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->start_date ? auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->start_date->format('Y-m-d') : '' }}', 
                end_date: '{{ auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->end_date ? auth()->user()->conferenceHotelRequests->where('conference_id', $conference->id)->first()->end_date->format('Y-m-d') : '' }}',
                
                init() {
                    this.checkComplete();
                },
                checkComplete() {
                    this.buttonActive = true;
                    if (this.room_type == null) {
                        this.buttonActive = false;
                    }
                    if (this.room_type == 'Single' || this.room_type == 'Double') {
                        if (this.start_date == null) {
                            this.buttonActive = false;
                        }
                        if (this.end_date == null) {
                            this.buttonActive = false;
                        }
                    }
                },
            }
        }
    </script>

</x-dashboard.layout>