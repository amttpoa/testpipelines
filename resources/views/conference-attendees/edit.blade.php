<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conferenceAttendee->conference) }}">{{ $conferenceAttendee->conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-attendees.index', $conferenceAttendee->conference) }}">Attendees</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conference-attendees.show', [$conferenceAttendee->conference, $conferenceAttendee]) }}">{{ $conferenceAttendee->user->name }}</x-crumbs.a>
            Edit Attendee
        </x-crumbs.holder>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <form method="POST" id="main-form" action="{{ route('admin.conference-attendees.update', [$conferenceAttendee->conference, $conferenceAttendee]) }}">
        @csrf
        @method('PATCH')
        <div class="flex gap-6 mb-6">
            <x-cards.user :user="$conferenceAttendee->user" type="Conference Attendee" class="flex-1" />
            <x-cards.main class="w-80">
                <div class="font-medium text-xl mb-3">Badge Info</div>
                <x-fields.input-text label="First Name" name="card_first_name" value="{!! $conferenceAttendee->card_first_name !!}" class="mb-3" />
                <x-fields.input-text label="Last Name" name="card_last_name" value="{!! $conferenceAttendee->card_last_name !!}" class="mb-3" />
                <x-fields.input-text label="Type" name="card_type" value="{!! $conferenceAttendee->card_type !!}" class="mb-3" />
            </x-cards.main>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <x-cards.main>
                <div class="flex gap-6">
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="comp" value="1" {{ $conferenceAttendee->comp ? 'checked' : '' }} />
                        Full Comp
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="invoiced" value="1" {{ $conferenceAttendee->invoiced ? 'checked' : '' }} />
                        Invoiced
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="paid" value="1" {{ $conferenceAttendee->paid ? 'checked' : '' }} />
                        Paid
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="checked_in" value="1" {{ $conferenceAttendee->checked_in ? 'checked' : '' }} />
                        Checked In
                    </label>
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="completed" value="1" {{ $conferenceAttendee->completed ? 'checked' : '' }} />
                        Completed
                    </label>
                </div>
                <h2 class="text-2xl mb-2">Payment Info</h2>
                <div class="font-medium">
                    {{ $conferenceAttendee->package }} - ${{ $conferenceAttendee->total }}
                </div>
                <div>
                    {{ $conferenceAttendee->pay_type }}
                </div>
                <div>
                    {{ $conferenceAttendee->name }}
                </div>
                <div>
                    {{ $conferenceAttendee->email }}
                </div>
                <div>
                    {{ $conferenceAttendee->purchase_order }}
                </div>
                <div>
                    {{ $conferenceAttendee->stripe_status }}
                </div>
                <div>
                    Registered {{ $conferenceAttendee->created_at->format('m/d/Y') }}
                    @if($conferenceAttendee->registered_by_user_id)
                    @if($conferenceAttendee->user_id != $conferenceAttendee->registered_by_user_id)
                    by
                    <x-a href="{{ route('admin.users.show', $conferenceAttendee->registeredByUser) }}">
                        {{ $conferenceAttendee->registeredByUser->name }}
                    </x-a>
                    @endif
                    @endif
                </div>
            </x-cards.main>
            <x-cards.main>
                <div class="flex gap-3">
                    <x-fields.input-text label="Package" name="package" value="{!! $conferenceAttendee->package !!}" class="mb-3 flex-1" />
                    <x-fields.input-text label="Total" name="total" value="{{ $conferenceAttendee->total }}" class="mb-3 w-32" />
                </div>
                <x-fields.input-text label="Name" name="name" value="{!! $conferenceAttendee->name !!}" class="mb-3" />
                <x-fields.input-text label="Email" name="email" value="{{ $conferenceAttendee->email }}" class="mb-3" />

            </x-cards.main>
        </div>

        <x-cards.main x-data="formHandler()">
            <div class="mb-6">
                <template x-for="(day, index) in courses" :key="index">
                    <div>
                        <div class="mt-6 mb-2 text-2xl font-medium" x-html="index"></div>
                        <template x-for="(course, index2) in day">
                            <label :class="{'bg-otgray-100 text-otgray': course.disabled, 'border-t': index2 ==0 }" class="py-1 px-3 flex gap-3 items-center border-b border-otblue-300">
                                <input type="checkbox" class="disabled:bg-otgray-100 disabled:border-otgray-300" x-model="course_ids" name="course_ids[]" :disabled="course.disabled == true" :value="course.id" @change="chooseCourse(course)" />
                                <div class="flex-1">
                                    <div x-html="course.name"></div>
                                    <div x-show="course.parent" class="text-xs text-otsteel font-medium">
                                        Linked to: <span x-html="course.parent ? course.parent.name : ''"></span>
                                    </div>
                                    <template x-for="child in course.children">
                                        <div class="text-xs text-otsteel font-medium">Linked to: <span x-html="child.name"></span></div>
                                    </template>
                                </div>
                                <div x-show="course.closed" class="font-bold text-otgray">
                                    FULL
                                </div>
                                <div class="text-xs text-otgray">
                                    <span x-html="course.filled"></span>/<span x-html="course.capacity"></span>
                                </div>
                                <div class="text-xs text-otgray">
                                    <span x-html="course.start_time"></span> -
                                    <span x-html="course.end_time"></span>
                                </div>
                                <div>
                                    <a href="" class="text-otgold" @click.prevent="showCourse(course)"><i class="fa-solid fa-circle-info" title="Course Description"></i></a>

                                </div>
                                {{-- <div class="font-semibold text-xl text-right" x-html="course.capacity"></div> --}}
                            </label>
                        </template>
                    </div>
                </template>
            </div>
        </x-cards.main>
    </form>

    <script type="text/javascript">
        function formHandler() {
            return {
                
                
                courses: {!! $courses !!},
                courses_all: {!! $conference->courses !!},
                courses_chosen: [],
                course_ids: {!! $conferenceAttendee->courseAttendees->pluck('course_id') !!},

                daysSelected: 0,
                daysSelectedArray: [],
                total: 0,
                package: null,

                company_name: null,
                company_website: null,

                termsModal: false,
                courseModal: false,
                errorModal: false,
                errorMessage: null,

                buttonActive: false,
                courseDisplay: {
                    'description': null,
                    'user_id': null,
                    'profile': null
                },
                init() {
                    console.log('init');
                    // $nextTick(() => { this.checkComplete(); });
                    this.markDisabled();
                },
                showCourse(course) {
                    console.log(course);
                    this.courseModal = true;
                    this.courseDisplay = course;
                },

                checkComplete() {
                    this.buttonActive = true;
                    // console.log(Object.keys(this.course_ids).length);
                    if (!Object.keys(this.course_ids).length) {
                        this.buttonActive = false;
                    }
                    // if (this.pay_type == null) {
                    //     this.buttonActive = false;
                    // }
                    // if (this.pay_type == 'invoice') {
                        if (this.name == null) {
                            this.buttonActive = false;
                        }
                        if (this.email == null) {
                            this.buttonActive = false;
                        }
                    // }
                    @can('organization-admin')
                    if (this.user_id == null) {
                        this.buttonActive = false;
                    }
                    @endcan
                    this.checkDaysSelected();
                },

                
                checkDaysSelected() {
                    console.log('check days selected');
                    this.daysSelected = 0;
                    Object.values(this.courses).forEach((day, index) => {
                        // day.selected = 0;
                        // console.log(this.courses);
                        this.daysSelectedArray[index] = 0;
                        Object.values(day).forEach(course => {
                            // console.log(course.id);
                            if (Object.values(this.course_ids).includes(course.id.toString())) {
                                this.daysSelected++;
                                this.daysSelectedArray[index]++;
                            }
                            
                        });
                    });

                    this.total = 0;
                    this.package = null;

                    if (this.daysSelectedArray[0] > 0 || this.daysSelectedArray[1] > 0 || this.daysSelectedArray[2] > 0 || this.daysSelectedArray[3] > 0 || this.daysSelectedArray[4] > 0) {
                        this.total = 350;
                        this.package = "Full Conference";
                    }
                    if ((this.daysSelectedArray[0] > 0 || this.daysSelectedArray[1] > 0) && this.daysSelectedArray[2] == 0 && this.daysSelectedArray[3] == 0 && this.daysSelectedArray[4] == 0) {
                        this.total = 150;
                        this.package = "Monday & Tuesday Package";
                    }
                    if ((this.daysSelectedArray[2] > 0 || this.daysSelectedArray[3] > 0) && this.daysSelectedArray[0] == 0 && this.daysSelectedArray[1] == 0 && this.daysSelectedArray[4] == 0) {
                        this.total = 300;
                        this.package = "Wednesday & Thursday Package";
                    }

                    console.log(this.daysSelectedArray);
                },

                formData: {
                    course_ids: [],
                    _token: document.head.querySelector('meta[name=csrf-token]').content
                },
                submitData() {
                    
                    console.log('submitData');

                    this.formData.course_ids = this.course_ids;
                               
                    
                    fetch('{{ route('checkCourses') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.formData)
                    })
                    .then(response => response.json())
                    .then((data) => {
                        // this.message = 'Form sucessfully submitted!';
                        // console.log(data);

                        // console.log(JSON.stringify(data));

                        // if (!data.length) {
                        //     window.dispatchEvent(new Event('processRegistration'));
                        // } else {

                        //     badCourses = "";
                        //     data.forEach(obj => {
                        //         // Object.entries(obj).forEach(([key, value]) => {
                        //         //     console.log(`${key} ${value}`);
                        //         // });
                        //         console.log(obj.id);
                        //         console.log('-------------------');

                        //         Object.values(this.courses).forEach((day, index) => {
                        //             // day.selected = 0;
                        //             // console.log(this.courses);
                        //             this.daysSelectedArray[index] = 0;
                        //             Object.values(day).forEach(course => {
                        //                 // console.log(course.id);
                        //                 if (course.id == obj.id) {
                        //                     this.course_ids.splice(Object.keys(this.course_ids).find(key => this.course_ids[key] === course.id.toString()), 1);
                        //                     course.filled = obj.filled;
                        //                     course.capacity = obj.capacity;
                        //                     course.closed = true;
                        //                     course.disabled = true;
                        //                     badCourses = badCourses + obj.name + "<br>";
                        //                 }
                                        
                        //             });
                        //         });

                        //         this.errorMessage = "<p><strong>The following courses you selected have been filled:</strong><br>" + badCourses + "</p>"
                        //             + "<p>These courses have been deselected. Please choose another course.</p>";
                        //         this.errorModal = true;



                        //     // });
                        //     // console.log(data.fileName);
                        //     // this.fields.push(data);
                        //     // this.fields.push({
                        //     //     details: 'details line',
                        //     //     note: this.formData.new_note,
                        //     //     image: '<span class="text-red-900">hello</span>'
                        //     });

                        //     this.markDisabled();
                        //     // this.formData.new_note = '';
                        // }
                            
                    })
                    .catch(() => {
                        // this.message = 'Ooops! Something went wrong!'
                    })
                    .finally(() => {
                        // this.loading = false;
                        // this.buttonLabel = 'Add Note';
                    });

                    // window.dispatchEvent(new Event('processRegistration'));
                },

                chooseCourse(checked_course) {
                    this.courses_chosen = [];
                    

                    if (Object.values(this.course_ids).includes(checked_course.id.toString())) {
                        // checked box on

                        if (checked_course.link_id != null) {
                            // if checked box is the child element
                            this.course_ids.push(checked_course.link_id.toString());
                        } else {
                            // if checked box is the parent element
                            Object.values(this.courses).forEach(day => {
                                Object.values(day).forEach(course => {
                                    if (course.link_id == checked_course.id) {
                                        this.course_ids.push(course.id.toString());
                                    }
                                });
                            });
                        }
                    } else {
                        // checked box off

                        if (checked_course.link_id != null) {
                            // if checked box is the child element

                            this.course_ids.splice(Object.keys(this.course_ids).find(key => this.course_ids[key] === checked_course.link_id.toString()), 1);
                        } else {
                            // if checked box is the parent element

                            Object.values(this.courses).forEach(day => {
                                Object.values(day).forEach(course => {
                                    if (course.link_id == checked_course.id) {
                                        this.course_ids.splice(Object.keys(this.course_ids).find(key => this.course_ids[key] === course.id.toString()), 1);
                                    }
                                });
                            });
                        }

                    }
                    console.log(this.course_ids);
                    this.markDisabled();
                },

                markDisabled() {
                    console.log('marking disabled');

                    // reset all disabled fields
                    Object.values(this.courses).forEach(day => {
                        Object.values(day).forEach(course => {
                            course.disabled = false;
                        });
                    });

                    this.course_ids.forEach((element) => {
                        obj = this.courses_all.find(data => data.id == element);
                        this.courses_chosen.push(obj);

                        Object.values(this.courses).forEach(day => {
                            Object.values(day).forEach(course => {
                                if (course.id != obj.id) {
                                    if (obj.start_date <= course.start_date && obj.end_date > course.start_date) {
                                        course.disabled = true;
                                    } // b starts in a
                                    if (obj.start_date < course.end_date   && obj.end_date >= course.end_date ) {
                                        course.disabled = true;
                                    } // b ends in a
                                    if (obj.start_date > course.start_date && obj.end_date < course.end_date) {
                                        course.disabled = true;
                                    } // a in b
                                }
                            });
                        });
                    });

                    Object.values(this.courses).forEach(day => {
                        Object.values(day).forEach(course => {
                            // console.log('disabled loop');
                            // console.log('course disabled' + course.disabled);
                            if (course.disabled == true) {
                                if (course.link_id != null) {
                                    console.log('FOUND' + course.link_id);
                                    Object.values(this.courses).forEach(day2 => {
                                        Object.values(day2).forEach(course2 => {
                                            if (course2.id == course.link_id) {
                                                course2.disabled = true;
                                            }
                                        });
                                    });
                                } else {
                                    Object.values(this.courses).forEach(day2 => {
                                        Object.values(day2).forEach(course2 => {
                                            if (course2.link_id == course.id) {
                                                course2.disabled = true;
                                            }
                                        });
                                    });

                                }
                            }

                        });
                    });

                    // Object.values(this.courses).forEach(day => {
                    //     Object.values(day).forEach(course => {
                    //         if (course.closed == true) {
                    //             course.disabled = true;
                    //         }

                    //     });
                    // });

                    this.checkComplete();

                    


                },
            }
        }
    </script>
    <script>
        // var stripe = Stripe('{{ Config::get('site.stripe_key') }}');
    // var elements = stripe.elements();
    // var style = {
    //     base: {
    //         color: '#32325d',
    //         fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    //         fontSmoothing: 'antialiased',
    //         fontSize: '16px',
    //         '::placeholder': {
    //             color: '#aab7c4'
    //         }
    //     },
    //     invalid: {
    //         color: '#fa755a',
    //         iconColor: '#fa755a'
    //     }
    // };
    // var card = elements.create('card', {hidePostalCode: true,
    //     style: style});
    // card.mount('#card-element');
    // card.addEventListener('change', function(event) {
    //     var displayError = document.getElementById('card-errors');
    //     if (event.error) {
    //         displayError.textContent = event.error.message;
    //     } else {
    //         displayError.textContent = '';
    //     }
    // });
    // const invoiceEmail = document.getElementById('email');

    // const cardButton = document.getElementById('card-button');
    // const cardHolderName = document.getElementById('card-holder-name');
    // const clientSecret = cardButton.dataset.secret;

    // cardButton.addEventListener('click', async (e) => {
    window.addEventListener('processRegistration', async (e) => {
    // function processRegistration() {
        console.log("attempting");
        // alert("here");
        // payType = document.querySelector('input[name="pay_type"]:checked').value;
        payType = null;
        // alert(payType);
        // alert("here2");
        var form = document.getElementById('main-form');
        form.submit();
    });
    </script>
</x-app-layout>