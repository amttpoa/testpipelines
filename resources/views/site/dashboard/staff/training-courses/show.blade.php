<x-dashboard.layout>
    @section("pageTitle")
    {{ $trainingCourse->training->name }} -
    {{ $trainingCourse->start_date->format('m/d/Y') }} -
    {{ $trainingCourse->end_date->format('m/d/Y') }}
    @endSection

    <x-breadcrumbs.holder>
        <a href="{{ route('dashboard.staff.trainings.index') }}" class="text-black">Advanced Training</a>
        <x-breadcrumbs.arrow />
        {{ $trainingCourse->training->name }} -
        {{ $trainingCourse->start_date->format('m/d/Y') }} -
        {{ $trainingCourse->end_date->format('m/d/Y') }}
    </x-breadcrumbs.holder>

    <div class="lg:grid lg:grid-cols-2 lg:gap-4 mb-4">
        <div>
            <div class="font-medium text-2xl">
                {{ $trainingCourse->training->name }}
            </div>
            <div class="text-lg">
                {{ $trainingCourse->start_date->format('m/d/Y') }} -
                {{ $trainingCourse->end_date->format('m/d/Y') }}
            </div>
            <div>
                {{ $trainingCourse->attendees->count() }} of
                {{ $trainingCourse->capacity}} registered
            </div>
            @if($trainingCourse->user_id == auth()->user()->id)
            <div>
                You are the lead instructor
            </div>
            @else
            <div>
                You are not the lead instructor
            </div>
            @endif
        </div>
        @if($trainingCourse->venue)
        <div class="">
            <div>
                <x-a class="text-xl" href="{{ route('venue', $trainingCourse->venue) }}">
                    {{ $trainingCourse->venue->name }}
                </x-a>
            </div>
            <div>
                {{ $trainingCourse->venue->address }}<br>
                {{ $trainingCourse->venue->city }}, {{ $trainingCourse->venue->state }} {{ $trainingCourse->venue->zip }}
            </div>
        </div>
        @endif
    </div>

    <div x-data="formHandler()">
        <form method="POST" id="main-form" action="{{ route('dashboard.staff.training-course-attendees.updateBatch', $trainingCourse) }}">
            @csrf
            @method('PATCH')

            @foreach($trainingCourse->attendees as $attendee)
            <div class="flex gap-3 items-center py-3 border-b border-otgray">
                <div>
                    <input type="checkbox" class="selectAll oneCheck" name="attendee_id[]" x-model="formFields.attendee_id" value="{{ $attendee->id }}" />
                </div>
                <div class="w-20">
                    <x-profile-image class="w-20 h-20" :profile="$attendee->user->profile" />
                </div>
                <div class="flex-1">
                    <div class="lg:grid lg:grid-cols-4 lg:gap-4 items-center">
                        <div class="col-span-2">
                            <div class="text-2xl font-medium">{{ $attendee->user->name }}</div>
                            <div class="font-medium">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</div>
                            <div>
                                {{ $attendee->user->profile->phone }} &bull; {{ $attendee->user->email }}
                            </div>
                        </div>
                        <div class="text-sm text-center">
                            <div>
                                @if($attendee->checked_in)
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                                    <i class="fa-solid fa-check w-5 text-center"></i> Checked In
                                </div>
                                @else
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
                                    <i class="fa-solid fa-x w-5 text-center"></i> Not Checked In
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm text-center">
                            <div class="">
                                @if($attendee->completed)
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 bg-otblue text-white">
                                    <i class="fa-solid fa-check w-5 text-center"></i> Completed
                                </div>
                                @else
                                <div class="inline-flex items-center border border-otblue rounded-full p-1 pl-2 pr-4 gap-2 text-otgray">
                                    <i class="fa-solid fa-x w-5 text-center"></i> Not Completed
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            @endforeach

            <div class="flex gap-3 items-center py-3 border-t border-otgray">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" value="" id="selectAllCheck" class="mr-2" @click="toggleAllCheckboxes()" />
                        select/deselect all
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <input type="hidden" name="type" id="markType" value="" />
                <x-button-site id="markCheck">Mark selected as Checked In</x-button-site>
                <x-button-site id="markCompleted">Mark selected as Completed</x-button-site>
                <x-button-site id="emailSelected" @click.prevent="emailModal=true">Email selected</x-button-site>

            </div>

            <script>
                $(document).ready(function() {
                    $('#markCheck').click(function() {
                        $('#markType').val('checkedin');
                    });
                    $('#markCompleted').click(function() {
                        $('#markType').val('completed');
                    });
                    $('#selectAll2').change(function() {
                        if($(this).is(":checked")) {
                            $('.selectAll').prop('checked', true);
                        } else {
                            $('.selectAll').prop('checked', false);
                        }      
                    });
                });
            </script>
        </form>


        <div x-show="emailModal" style="display:none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="emailModal" class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

                    <div x-show="emailModal" @click.away="emailModal = false" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-6xl sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="max-h-96 overflow-y-auto m-4">
                            <div class="mb-3 font-medium">
                                Sending to <span x-html="formFields.attendee_id.length"></span> attendees
                            </div>
                            <x-fields.input-text label="Subject" name="subject" x-model="formFields.subject" />
                            <x-label>Message</x-label>
                            <x-textarea class="addTinyX" rows="8" name="message" x-model="formFields.message"></x-textarea>

                        </div>

                        <div class="px-6 py-3 flex gap-3">
                            <div class="flex-1"></div>
                            <x-button type="light" @click.prevent="emailModal = false">
                                Cancel
                            </x-button>
                            <x-button @click.prevent="submitForm">
                                Send Emails
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            function formHandler() {
                return {
                    emailModal: false,
                    selectall: false,
                    formFields: {
                        attendee_id: [],
                        subject: null,
                        message: null,
                        _token: document.head.querySelector('meta[name=csrf-token]').content
                    },
                    
                    submitForm(){
                        console.log('submit');
                        console.log(this.formFields);

                        fetch('{{ route('dashboard.staff.training-course-attendees.sendEmails', $trainingCourse) }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.formFields)
                        })
                        .then(response => response.json())
                        .then((data) => {
                            // this.message = 'Form sucessfully submitted!';
                            console.log(data);

                            console.log(JSON.stringify(data));

                            this.emailModal = false;
                                
                        })
                        .catch(() => {
                            // this.message = 'Ooops! Something went wrong!'
                            console.log('error');
                        })
                        .finally(() => {
                            // this.loading = false;
                            // this.buttonLabel = 'Add Note';
                            console.log('finally');
                        });

                    }, 

                    toggleAllCheckboxes() {
                        this.formFields.attendee_id = [];
                        // this.selectall = !this.selectall

                        // checkboxes = document.querySelectorAll('input[type="checkbox"]');
                        // [...checkboxes].map((el) => {
                        //     el.checked = this.selectall;
                        // })

                        // this.attendee_id = [];
                        //     console.log(this.attendee_id);
                        // document.querySelectorAll('.oneCheck').forEach(function(button) {
                        //     console.log(button.value);
                        //     console.log(this.attendee_id);
                        //     // this.attendee_id.push(button.value);
                        // });

                        var checks = document.querySelectorAll('.oneCheck');
                        if (document.getElementById('selectAllCheck').checked) {
                            for (var i = 0; i < checks.length; i++) {
                                this.formFields.attendee_id.push(checks.item(i).value);
                                // Distribute(slides.item(i));
                            }
                        }

                    }

                }
            }
        </script>



    </div>



    <x-dashboard.table class="hidden">
        <tr class="text-sm font-medium text-white text-left bg-otgray divide-x divide-white">
            <th class="px-2 py-1">Name</th>
            <th class="px-2 py-1">Organization</th>
            <th class="px-2 py-1">Email</th>
            <th class="px-2 py-1">Phone</th>
        </tr>

        @foreach($trainingCourse->attendees as $attendee)
        <tr class="border-b border-otgray {{ $loop->index % 2 > 0 ? 'bg-otgray-100' : '' }}">
            <td class="px-2 py-1">
                <div class="flex gap-2 items-center">
                    <x-profile-image class="w-10 h-10" :profile="$attendee->user->profile" />
                    {{ $attendee->user->name }}
                </div>
            </td>
            <td class="px-2 py-1">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</td>
            <td class="px-2 py-1">{{ $attendee->user->email }}</td>
            <td class="px-2 py-1">{{ $attendee->user->profile->phone }}</td>
        </tr>
        @endforeach
    </x-dashboard.table>

</x-dashboard.layout>