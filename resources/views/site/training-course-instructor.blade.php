<x-site-layout>

    <div class="h-48 bg-black bg-cover bg-center" style="background-image:url(/img/otoabanner-35thanniversary-protect-and-serve.jpg);">
        <div class="h-full" style="background-color: rgba(0,0,0,.7);">
            <div class="h-full flex flex-col justify-center max-w-7xl mx-auto">
                <div class="text-otgold font-blender text-6xl font-bold text-center">
                    <a href="{{ route('trainings') }}">Advanced Training</a>
                    <div class="text-2xl">
                        <a href="{{ route('training', $trainingCourse->training->slug) }}">
                            {{ $trainingCourse->training->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="bg-otsteel border-b py-8 flex-1">

        <div class="max-w-6xl mx-auto rounded-xl bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-6 p-2 text-4xl font-bold font-blender">
                Course Details
            </div>
            <div class="p-6 flex items-center gap-6">
                <div class="">

                    <div class="font-semibold text-3xl">
                        <a href="{{ route('training', $trainingCourse->training->slug) }}">
                            {{ $trainingCourse->training->name }}
                        </a>
                    </div>
                    <div class="font-semibold text-xl">
                        {{ date('F j, Y', strtotime($trainingCourse->start_date)) }}
                        - {{ date('F j, Y', strtotime($trainingCourse->end_date)) }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('venue', $trainingCourse->venue->slug) }}" class="font-semibold text-xl text-otgold">{{ $trainingCourse->venue->name }}</a>
                    </div>
                    <div>
                        {{ $trainingCourse->venue->address }}<br>
                        {{ $trainingCourse->venue->city }}, {{ $trainingCourse->venue->state }} {{ $trainingCourse->venue->zip }}
                    </div>
                    @if($trainingCourse->description)
                    <div class="prose text-xl max-w-full mt-4">
                        {!! $trainingCourse->description !!}
                    </div>
                    @endif
                </div>
                <div class="flex-1 text-center">
                    <div class="font-medium text-sm">Price</div>
                    <div class="font-semibold text-4xl">${{ $trainingCourse->price }}</div>
                    <div class="text-otsteel mt-4">{{ $trainingCourse->attendees->count() }} of {{ $trainingCourse->capacity }} seats taken</div>
                </div>

                <div class="text-center">
                    <a href="{{ route('staffProfile', $trainingCourse->user) }}">
                        <x-profile-image class="w-40 h-40" :profile="$trainingCourse->user->profile" />
                        <div class="text-xl font-medium">{{ $trainingCourse->user->name }}</div>
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto rounded-xl bg-white overflow-hidden mb-8">
            <div class="bg-otblue text-white px-6 p-2 text-4xl font-bold font-blender">
                {{ $trainingCourse->training->name }} Roster
            </div>
            <div class="p-6">


                <div class="overflow-hidden w-full">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full whitespace-no-wrap">
                            <thead class="">
                                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                    <th class="px-4 py-3">Name</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-ot-steel">


                                @foreach($trainingCourse->attendees as $attendee)
                                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                    <td class="px-4 py-3">
                                        {{-- <a href="{{ route('admin.users.show', $attendee->user) }}"> --}}
                                            {{ $attendee->user->name }}
                                            {{-- </a> --}}
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>

    </section>


</x-site-layout>