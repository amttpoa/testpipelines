<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.trainings.index') }}">Trainings</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.trainings.show', $training) }}">{{ $training->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.training-courses.index', $training) }}">Courses</x-crumbs.a>
            {{ $trainingCourse->start_date->format('m/d/Y') }}
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.training-course-attendees.export', [$training, $trainingCourse]) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200" target="_blank" download>Export Attendees</a>
        </x-page-menu>
        <div>
            <x-button-link href="{{ route('admin.training-courses.edit', [$training, $trainingCourse]) }}">Edit Course</x-button-link>
        </div>
    </x-crumbs.bar>

    <x-cards.main class="mb-6">

        <div class="flex gap-4">

            <div>
                <div class="font-semibold text-3xl">
                    {{ $trainingCourse->training->name }}
                </div>
                <div class="font-semibold text-xl">
                    {{ date('F j, Y', strtotime($trainingCourse->start_date)) }}
                    - {{ date('F j, Y', strtotime($trainingCourse->end_date)) }}
                </div>
                @if($trainingCourse->venue)
                <div class="mt-4">
                    <a href="{{ route('admin.venues.edit', $trainingCourse->venue) }}" class="font-semibold text-xl text-otgold">{{ $trainingCourse->venue->name }}</a>
                </div>
                <div>
                    {{ $trainingCourse->venue->address }}<br>
                    {{ $trainingCourse->venue->city }}, {{ $trainingCourse->venue->state }} {{ $trainingCourse->venue->zip }}
                </div>
                @endif
                @if($trainingCourse->description)
                <div class="prose text-base max-w-none mt-4">
                    {!! $trainingCourse->description !!}
                </div>
                @endif

            </div>

            <div class="flex-1 text-center">
                <div class="font-medium text-sm">Price</div>
                <div class="font-semibold text-4xl">${{ $trainingCourse->price }}</div>
                <div class="text-otsteel mt-4">{{ $trainingCourse->attendees->count() }} of {{ $trainingCourse->capacity }} seats taken</div>
                <div class="font-medium mt-4">{{ $trainingCourse->visible ? '' : 'NOT' }} Visible</div>
                <div class="font-medium">{{ $trainingCourse->active ? '' : 'NOT' }} Active</div>
            </div>

            @if($trainingCourse->user)
            <div class="text-center w-40 flex-none">
                <a href="{{ route('admin.users.show', $trainingCourse->user) }}">
                    <x-profile-image class="w-40 h-40" :profile="$trainingCourse->user->profile" />
                    <div class="text-xl font-medium">{{ $trainingCourse->user->name }}</div>
                </a>
            </div>
            @endif

            @if($trainingCourse->users->isNotEmpty())
            <div class="">
                @foreach($trainingCourse->users as $user)
                <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-3 mb-2">
                    <x-profile-image class="w-10 h-10" :profile="$user->profile" />
                    <div class="font-medium">{{ $user->name }}</div>
                </a>
                @endforeach
            </div>
            @endif
        </div>

    </x-cards.main>



    <div class="grid md:grid-cols-2 gap-6">
        <x-cards.main>
            <form method="POST" action="{{ route('admin.training-course-attendees.add-attendee', [$training, $trainingCourse]) }}">
                @csrf
                <div>
                    <div class="font-medium text-xl mb-4">Add Attendee</div>
                    @livewire('user-autocomplete', ['user_id' => '', 'user_name' => ''] )
                </div>
                <div class="mt-4">
                    <x-button>Add Attendee</x-button>
                </div>
            </form>
        </x-cards.main>

        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\TrainingCourse', 'subject_id' => $trainingCourse->id])
        </x-cards.main>

    </div>

    <div class="font-medium text-otsteel-300 text-center text-4xl m-4">
        Roster
    </div>

    <form method="POST" id="main-form" action="{{ route('admin.training-course-attendees.updateBatch', [$training, $trainingCourse]) }}">
        @csrf
        @method('PATCH')

        <x-cards.plain>

            <div class="overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="">
                            <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                <th class="px-4 py-3" colspan="5"></th>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Organization</th>
                                <th class="px-4 py-3 text-center">Payment</th>
                                {{-- <th class="px-4 py-3 text-center">Member</th> --}}
                                <th class="px-4 py-3 text-center">Checked In</th>
                                <th class="px-4 py-3 text-center">Completed</th>
                                <th class="px-4 py-3 text-center">Survey</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-ot-steel">


                            @foreach($trainingCourse->attendees as $attendee)
                            <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                <td class="px-4 py-3 w-0">
                                    <input type="checkbox" class="selectAll" name="attendee_id[]" value="{{ $attendee->id }}" />
                                </td>

                                <td class="py-3 w-0">
                                    @if($attendee->user)
                                    @if($attendee->user->subscribed())
                                    <span class="font-medium">M</span>
                                    @endif
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->comp)
                                    <span class="font-medium">C</span>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->invoiced)
                                    <i class="fa-solid fa-i"></i>
                                    @endif
                                </td>
                                <td class="py-3 w-0">
                                    @if($attendee->paid)
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($attendee->user)
                                    <a class="flex gap-3 items-center" href="{{ route('admin.training-course-attendees.show', [$attendee->trainingCourse->training, $attendee->trainingCourse, $attendee]) }}">
                                        <div class="w-10">
                                            <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-lg">{{ $attendee->user->name }}</div>
                                            <div class="text-otsteel text-sm">{{ $attendee->user->email }}</div>
                                        </div>
                                    </a>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($attendee->user)
                                    @if($attendee->user->organization)
                                    <div>
                                        <a class="font-medium" href="{{ route('admin.organizations.show', $attendee->user->organization) }}">
                                            {{ $attendee->user->organization->name }}
                                        </a>
                                    </div>
                                    @endif
                                    @if($attendee->user->organizations)
                                    @foreach($attendee->user->organizations as $organization)
                                    <div class="leading-tight">
                                        <a class="font-medium text-sm" href="{{ route('admin.organizations.show', $organization) }}">
                                            {{ $organization->name }}
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="font-medium">{{ $attendee->total ? '$' . $attendee->total : ''}}</div>
                                    <div class="text-sm">{{ $attendee->pay_type}}</div>
                                </td>
                                {{-- <td class="px-4 py-3 text-center">
                                    @if($attendee->user)
                                    @if($attendee->user->subscribed())
                                    <i class="fa-solid fa-check"></i>
                                    @endif
                                    @endif
                                </td> --}}
                                <td class="px-4 py-3 text-center">
                                    @if($attendee->checked_in)
                                    <i class="fa-solid fa-check"></i>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($attendee->completed)
                                    <i class="fa-solid fa-check"></i>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($attendee->surveyTrainingCourseSubmission)
                                    <i class="fa-solid fa-check"></i>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-4 py-3 border-t border-otsteel">
                <label class="inline-flex items-center justify-start">
                    <input type="checkbox" value="" id="selectAll2" class="mr-2" />
                    select/deselect all
                </label>
            </div>

            <script>
                $(document).ready(function() {
                    $('#selectAll2').change(function() {
                        if($(this).is(":checked")) {
                            $('.selectAll').prop('checked', true);
                        } else {
                            $('.selectAll').prop('checked', false);
                        }      
                    });
                });
            </script>

        </x-cards.plain>

        <div class="flex gap-3 mt-6 ml-6 items-center" x-data="{ item: '' }">
            <div>
                Mark selected as
            </div>
            <x-select name="not" :selections="['' => '', 'NOT' => 'NOT']" />
            <x-select name="item" x-model="item" :selections="['' => '', 'full comp' => 'full comp', 'invoiced' => 'invoiced', 'paid' => 'paid', 'checked in' => 'checked in', 'completed' => 'completed']" />
            <button :disabled="!item" class="inline-flex items-center px-4 py-1.5 shadow-md bg-otgold border border-otgold rounded-md text-sm text-white hover:bg-otgold-500 hover:border-otgold-500 active:bg-otgold-600 focus:outline-none focus:border-otgold-500 focus:ring ring-otgold-200 disabled:opacity-25 transition ease-in-out duration-150">
                Submit
            </button>
        </div>
    </form>



    @if($trainingCourse->trainingWaitlists->isNotEmpty())

    <div class="font-medium text-otsteel-300 text-center text-4xl m-4">
        Waitlist
    </div>

    <form method="POST" id="main-form" action="{{ route('admin.training-course-attendees.updateBatch', [$training, $trainingCourse]) }}">
        @csrf
        @method('PATCH')

        <x-cards.plain>

            <div class="overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="">
                            <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Organization</th>
                                <th class="px-4 py-3">Comments</th>
                                <th class="px-4 py-3">Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-ot-steel">
                            @foreach($trainingCourse->trainingWaitlists as $waitlist)
                            <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">

                                <td class="px-4 py-3">
                                    <input type="checkbox" class="selectAll" name="waitlist_id[]" value="{{ $waitlist->id }}" />
                                </td>
                                <td class="px-4 py-3">
                                    @if($waitlist->user)
                                    <a class="flex gap-3 items-center" href="{{ route('admin.users.show', $waitlist->user) }}">
                                        <div class="w-10">
                                            <x-profile-image class="w-10 h-10" :profile="$waitlist->user->profile" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-lg">{{ $waitlist->user->name }}</div>
                                            <div class="text-otsteel text-sm">{{ $waitlist->user->email }}</div>
                                        </div>
                                    </a>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($waitlist->user->organization)
                                    <a href="{{ route('admin.organizations.show', $waitlist->user->organization) }}">
                                        <div class="">{{ $waitlist->user->organization->name }}</div>
                                        <div class="text-otsteel text-sm">{{ $waitlist->user->organization->domain }}</div>
                                    </a>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ $waitlist->comments}}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $waitlist->created_at->format('m/d/Y h:i')}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-cards.plain>

        <div class="flex gap-3 mt-6 ml-6">
            <x-button>Make selected users attendees</x-button>
        </div>
    </form>
    @endif





</x-app-layout>