<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.users.index') }}">Users</x-crumbs.a>
            {{ $user->name }}
        </x-crumbs.holder>
        <div>
            <x-button-link href="{{ route('admin.users.edit', $user) }}">Edit User</x-button-link>
        </div>
    </x-crumbs.bar>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div>

            <x-cards.user :user="$user" class="mb-6" />


            <x-cards.main>
                <x-a href="{{ route('admin.users.login-as', $user) }}" class="text-sm float-right">Login As</x-a>

                @if($user->subscription())

                <div class="grid grid-cols-2 gap-3">
                    <div>

                        <div class="text-2xl font-medium ">
                            {{ $user->subscribed() ? '' : 'Not' }} Subscribed
                        </div>
                        @if($user->subscription()->authorize_id)
                        <div class="text-sm">
                            Authorize.net Subscription ID:
                            <span class="font-medium">{{ $user->subscription()->authorize_id }}</span>
                        </div>
                        @endif
                        <div class="font-medium mt-2">
                            {{ $user->subscription()->authorize_plan }}
                        </div>

                        @if($user->subscription()->parent)
                        <div class="mt-2 text-sm">
                            Membership of
                            <x-a href="{{ route('admin.organizations.show', $user->subscription()->parent->organization) }}">
                                {{ $user->subscription()->parent->organization->name }}
                            </x-a> by
                            <x-a href="{{ route('admin.users.show', $user->subscription()->parent->user) }}">
                                {{ $user->subscription()->parent->user->name }}
                            </x-a>
                        </div>
                        @endif

                        @foreach($user->subscription()->children as $child)
                        <div>
                            <x-a href="{{ route('admin.users.show', $child->user) }}">
                                {{ $child->user->name }}
                            </x-a>
                        </div>
                        @endforeach




                        {{-- <table>
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    Start:
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromTimeStamp($sub->current_period_start)->format('m/d/Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    End:
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromTimeStamp($sub->current_period_end)->format('m/d/Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    Method:
                                </td>
                                <td>
                                    {{ $sub->collection_method }}
                                </td>
                            </tr>

                            @if($user->subscribes->whereNotNull('email')->isNotEmpty())
                            @foreach($user->subscribes->whereNotNull('email') as $subscribe)
                            <tr class="">
                                <td class="pr-2 font-medium text-right">Invoice:</td>
                                <td>{{ $subscribe->email }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </table> --}}

                        {{-- <div>
                            Status:
                            <x-stripe-status status="{{ $sub->status }}" />
                        </div> --}}



                        {{-- <div class="font-medium">
                            @foreach ($user->subscriptions->where('stripe_status', 'active') as $subscription)
                            {{ $subscription->stripe_price == 'price_1LPgSzCh7AUlZv8XR90BuZVa' ? 'Standard' : '' }}
                            {{ $subscription->stripe_price == 'price_1LPgTiCh7AUlZv8XtAuLMZa5' ? 'Retired' : '' }}
                            {{ $subscription->stripe_price == 'price_1LQ0SCCh7AUlZv8XTPDswVcm' ? 'Civilian' : '' }}
                            {{ $subscription->stripe_price == 'price_1LQ0T7Ch7AUlZv8X4sCAagQj' ? 'Corporate' : '' }}
                            @endforeach
                        </div> --}}

                        {{-- <div>
                            Start: {{ \Carbon\Carbon::createFromTimeStamp($sub->current_period_start)->format('m/d/Y') }}
                        </div>
                        <div>
                            Ends: {{ \Carbon\Carbon::createFromTimeStamp($sub->current_period_end)->format('m/d/Y') }}
                        </div>
                        <div>
                            Method: {{ $sub->collection_method }}
                        </div>
                        <div>
                            Latest Invoice: {{ $sub->latest_invoice }}
                        </div> --}}
                        {{-- @if($free)
                        <div class="text-red-500">
                            Old user {{ $free->used_at ? $free->used_at->format('m/d/Y H:i') : 'found - not used' }}
                        </div>
                        @endif --}}

                    </div>

                    <div>

                        {{-- @php
                        $invoice = $user->findInvoice($sub->latest_invoice);
                        // dd($invoice)
                        @endphp

                        <div class="text-2xl font-medium flex gap-4 items-center">
                            <div>
                                Invoice
                            </div>
                            <x-stripe-status status="{{ $invoice->status }}" />
                            <div class="text-sm">
                                <a href="https://dashboard.stripe.com/invoices/{{ $invoice->id }}" target="_blank">
                                    <i class="fa-solid fa-arrow-up-right-from-square "></i>
                                </a>
                            </div>
                        </div>


                        <table>
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    Due:
                                </td>
                                <td>
                                    ${{ $invoice->amount_due / 100 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    Paid:
                                </td>
                                <td>
                                    ${{ $invoice->amount_paid / 100 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    Remaining:
                                </td>
                                <td>
                                    ${{ $invoice->amount_remaining / 100 }}
                                </td>
                            </tr>
                            @if($invoice->due_date)
                            <tr>
                                <td class="pr-2 font-medium text-right">
                                    Due Date:
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromTimeStamp($invoice->due_date)->format('m/d/Y') }}
                                </td>
                            </tr>
                            @endif
                        </table>

                        @if($invoice->status == 'open')
                        <form method="POST" action="{{ route('admin.users.mark-paid',  [$user, $invoice->id]) }}" class="mt-4" onsubmit="return confirm('Are you sure you want to mark this invoice as paid?')">
                            @csrf
                            <x-button type="small">Mark Paid</x-button>
                        </form>
                        @endif

                        @if($invoice->paid_out_of_band)
                        <div class="text-red-500">
                            Payment collected outside of Stripe
                        </div>
                        @endif

                        @php
                        $upcoming_invoice = $user->subscription('default')->upcomingInvoice();
                        @endphp

                        @if($upcoming_invoice && 1==2)
                        <div class="text-xl font-medium mt-4">Upcoming Invoice</div>
                        <div>
                            Amount Due: ${{ $upcoming_invoice->amount_due / 100 }}
                        </div>
                        <div>
                            Amount Paid: ${{ $upcoming_invoice->amount_paid / 100 }}
                        </div>
                        <div>
                            Amount Remaining: ${{ $upcoming_invoice->amount_remaining / 100 }}
                        </div>

                        @endif --}}

                    </div>
                </div>

                @else
                <div class="text-2xl font-medium">No Subscription Information</div>
                @endif


                {{-- <div class="hidden">
                    <div>{{ $user->balance() }}</div>
                    <div>{{ $user->paymentMethods() }}</div>
                    <div>{{ $user->hasDefaultPaymentMethod() }}</div>
                    <div>{{ $user->subscription('default') }}</div>
                    <div>{{ $user->subscriptions }}</div>
                    <br><br>-------------
                    <div>{{ $user->subscribed() }}</div>
                    <div>{{ $user->subscriptions }}</div>
                    <br><br>-------------
                    <div>{{ $sub }}</div>
                </div> --}}

                @if($user->subscribed())
                @if(!$user->subscription()->authorize_id)
                <form method="POST" action="{{ route('admin.users.cancel',  $user) }}" class="mt-4" onsubmit="return confirm('Are you sure you want to cancel this subscription?')">
                    @csrf
                    <x-button>Cancel Subscription</x-button>
                </form>
                @endif
                @else
                <form method="POST" action="{{ route('admin.users.subscribe',  $user) }}" class="mt-4">
                    @csrf
                    <x-button>Give Subscription</x-button>
                </form>
                @endif

            </x-cards.main>
        </div>


        <x-cards.main>
            @livewire('notes', ['subject_type' => 'App\Models\User', 'subject_id' => $user->id])
        </x-cards.main>

    </div>


    @if($user->can('conference-instructor') && $user->coursesTeaching()->isNotEmpty())
    <x-cards.plain class="mb-6">
        <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
            Instructor for Conference Courses
        </div>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Course</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($user->coursesTeaching() as $course)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1 w-0 whitespace-nowrap">
                        <a class="" href="{{ route('admin.courses.show', [$course->conference, $course]) }}">
                            {{ $course->start_date->format('m/d/Y H:i') }} - {{ $course->end_date->format('H:i') }}
                        </a>
                    </td>
                    <td class="px-4 py-1 font-medium">
                        <a class="" href="{{ route('admin.courses.show', [$course->conference, $course]) }}">
                            {{ $course->name }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>
    @endif


    @if($user->can('staff-instructor') && $user->trainingCoursesTeaching()->isNotEmpty())
    <x-cards.plain class="mb-6">
        <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
            Instructor for Advance Training Courses
        </div>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Course</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($user->trainingCoursesTeaching() as $course)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1 w-0 whitespace-nowrap">
                        <a class="" href="{{ route('admin.training-courses.show', [$course->training, $course]) }}">
                            {{ $course->start_date->format('m/d/Y') }} - {{ $course->end_date->format('m/d/Y') }}
                        </a>
                    </td>
                    <td class="px-4 py-1 font-medium">
                        <a class="" href="{{ route('admin.training-courses.show', [$course->training, $course]) }}">
                            {{ $course->training->name }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>
    @endif


    @if($user->conferenceAttendees->isNotEmpty())
    <x-cards.plain class="mb-6">
        <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
            Conferences Attending
        </div>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Conference</th>
                    <th class="px-4 py-3">Courses</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($user->conferenceAttendees->sortByDesc('conference.start_date') as $attendee)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1 w-0 whitespace-nowrap">
                        <a class="" href="{{ route('admin.conference-attendees.show', [$attendee->conference, $attendee]) }}">
                            {{ $attendee->conference->start_date->format('m/d/Y') }} - {{ $attendee->conference->end_date->format('m/d/Y') }}
                        </a>
                    </td>
                    <td class="px-4 py-1 font-medium">
                        <a class="" href="{{ route('admin.conference-attendees.show', [$attendee->conference, $attendee]) }}">
                            {{ $attendee->conference->name }}
                        </a>
                    </td>
                    <td class="px-4 py-1 font-medium">
                        <a class="" href="{{ route('admin.conference-attendees.show', [$attendee->conference, $attendee]) }}">
                            {{ $attendee->courseAttendees->count() }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>
    @endif


    @if($user->trainingCourseAttendees->isNotEmpty())
    <x-cards.plain class="mb-6">
        <div class="font-medium text-xl py-2 px-4 bg-otsteel-500 text-white">
            Advanced Training Courses Attending
        </div>
        <x-admin.table>
            <thead class="">
                <tr class="text-sm text-white text-left bg-otsteel divide-x divide-white">
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Course</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-ot-steel">
                @foreach($user->trainingCourseAttendees->sortByDesc('start_date') as $attendee)
                @if($attendee->trainingCourse)
                <tr class="{{ $loop->index > 0 ? 'border-t border-otsteel' : '' }} {{ $loop->index % 2 > 0 ? 'bg-gray-50' : '' }} ">
                    <td class="px-4 py-1 w-0 whitespace-nowrap">
                        <a class="" href="{{ route('admin.training-course-attendees.show', [$attendee->trainingCourse->training, $attendee->trainingCourse, $attendee]) }}">
                            {{ $attendee->trainingCourse->start_date->format('m/d/Y') }} - {{ $attendee->trainingCourse->end_date->format('m/d/Y') }}
                        </a>
                    </td>
                    <td class="px-4 py-1 font-medium">
                        <a class="" href="{{ route('admin.training-course-attendees.show', [$attendee->trainingCourse->training, $attendee->trainingCourse, $attendee]) }}">
                            {{ $attendee->trainingCourse->training->name }}
                        </a>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </x-admin.table>
    </x-cards.plain>
    @endif



    <x-cards.main class="mb-6">
        <h2 class="font-medium text-2xl mb-4">Send {{ $user->name }} an email</h2>
        <form method="POST" id="main-form" action="{{ route('admin.users.sendEmail', $user) }}">
            @csrf
            <x-fields.input-text label="Subject" name="subject" class="mb-3" />
            <x-label>Message</x-label>
            <x-textarea name="content" class="addTiny"></x-textarea>

            <div>
                <label class="flex gap-3 items-center mt-4">
                    <input type="checkbox" name="sig" value="yes" />
                    Include signature
                </label>
            </div>

        </form>
    </x-cards.main>
    <div class="mt-6 ml-6">
        <x-button form="main-form">Send Email</x-button>
    </div>


    <x-cards.main class="mt-6" x-data="{showLog:false}">
        <div class="cursor-pointer font-medium" @click="showLog=!showLog">View Activity Log</div>
        <table class="mt-6 w-full" x-show="showLog">
            <tbody class="divide-y divide-cdblue-500 align-top">
                @foreach($activities as $activity)
                <tr>
                    <td class="whitespace-nowrap">{{ $activity->created_at->format('F jS Y h:i A') }}</td>
                    <td>
                        {{ $activity->description }}
                    </td>
                    <td>
                        {{ str_replace('App\Models\\', '', $activity->subject_type) }}
                    </td>
                    <td>{{ $activity->causer ? $activity->causer->name : '' }}</td>
                    <td class="textLeft">
                        @if($activity->description == 'updated')
                        @if($activity->properties->isNotEmpty())
                        @foreach($activity->properties['attributes'] as $key => $val)
                        <div>
                            {{ $key }} From
                            @if(isset($activity->properties['old'][$key]))
                            <span class="font-semibold">{{ $activity->properties['old'][$key] }}</span>
                            @else
                            <span class="font-semibold text-red-700 text-sm">null</span>
                            @endif
                            to
                            @if(isset($activity->properties['attributes'][$key]))
                            <span class="font-semibold">{{ $activity->properties['attributes'][$key] }}</span>
                            @else
                            <span class="font-semibold text-red-700 text-sm">null</span>
                            @endif
                        </div>
                        @endforeach
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </x-cards.main>


</x-app-layout>