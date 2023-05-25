<x-dashboard.layout>
    @section("pageTitle")
    Survey
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.trainings.index') }}">Advanced Training</a>
        <x-breadcrumbs.arrow />
        <a class="text-black" href="{{ route('dashboard.trainings.show', $trainingCourseAttendee) }}">{{ $trainingCourseAttendee->trainingCourse->training->name }}</a>
        <x-breadcrumbs.arrow />
        Survey
    </x-breadcrumbs.holder>


    <div class="text-xl font-medium">
        {{ $trainingCourseAttendee->trainingCourse->training->name }}
    </div>
    <div class="text-sm mb-4">
        Instructor:
        <x-a href="{{ route('staffProfile', $trainingCourseAttendee->trainingCourse->user) }}">{{ $trainingCourseAttendee->trainingCourse->user->name }}</x-a>
    </div>
    <div class="hidden">
        Please tell us about your experience at {{ $trainingCourseAttendee->trainingCourse->training->name }}.
    </div>

    <form method="POST" id="main-form" action="{{ route('dashboard.trainings.surveyPost', $trainingCourseAttendee) }}">
        @csrf

        <div class="mt-8">

            @foreach(Config::get('site.conference_course_survey_questions') as $key => $question)
            <div class="border-b border-otgray-200 py-4 grid md:grid-cols-2 items-center gap-4">
                <div>
                    {{ $question }}
                </div>
                <div class="flex gap-6 text-xl font-medium">
                    <label class="flex items-center">
                        <input type="radio" class="mr-2" name="a{{ $key }}" value="1" required />
                        1
                    </label>
                    <label class="flex items-center">
                        <input type="radio" class="mr-2" name="a{{ $key }}" value="2" required />
                        2
                    </label>
                    <label class="flex items-center">
                        <input type="radio" class="mr-2" name="a{{ $key }}" value="3" required />
                        3
                    </label>
                    <label class="flex items-center">
                        <input type="radio" class="mr-2" name="a{{ $key }}" value="4" required />
                        4
                    </label>
                    <label class="flex items-center">
                        <input type="radio" class="mr-2" name="a{{ $key }}" value="5" required />
                        5
                    </label>
                    <input type="hidden" name="q{{ $key }}" value="{{ $question }}" />
                </div>
            </div>
            @endforeach


            <div class="py-4 grid md:grid-cols-2 items-center gap-4">
                <div>
                    Please help us improve this course. What was most/least useful to you and why?
                </div>

                <div class="" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                    <div class=" text-right">
                        <div class="pr-2 text-xs text-otsteel-500"><span x-html="count"></span> of <span x-html="$refs.countme.maxLength"></span> character limit</div>
                    </div>
                    <x-textarea id="comments" name="comments" rows="3" maxlength="250" x-ref="countme" x-on:keyup="count = $refs.countme.value.length" placeholder="This is optional..."></x-textarea>
                </div>


            </div>
            <div class="mt-4">
                <x-button-site>Submit Survey</x-button-site>
            </div>
        </div>
    </form>

</x-dashboard.layout>