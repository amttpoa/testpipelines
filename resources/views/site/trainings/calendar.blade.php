<x-site-layout>
    @section("pageTitle")
    Advanced Training
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-3xl lg:text-6xl">Advanced Training</div>
    </x-banner>

    <div class="flex flex-1 bg-otsteel">
        <div class="flex-1 max-w-6xl bg-white mx-auto p-6 py-12">


            <div class="border-t border-otgray mb-2 bg-otgray-50 bg-otgray-50">
                @foreach($trainingCourses as $trainingCourse)
                <a href="{{ route('trainingCourse', [$trainingCourse->training, $trainingCourse]) }}" class="block border-b border-otgray py-4 px-4 hover:bg-otgray-100">
                    <div class="lg:flex lg:gap-3 lg:items-center">
                        <div class="lg:flex-1">
                            <div class="font-medium text-2xl">
                                {{ $trainingCourse->training->name }}
                            </div>
                            <div class="lg:flex lg:gap-4 lg:items-center">
                                <div class="text-lg">
                                    {{ $trainingCourse->start_date->format('m/d/Y') }} -
                                    {{ $trainingCourse->end_date->format('m/d/Y') }}
                                </div>
                                <div class="text-otgray text-sm">
                                    {{ $trainingCourse->start_date->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="font-medium">
                            <div>{{ $trainingCourse->venue ? $trainingCourse->venue->name : ''}}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>



        </div>
    </div>




</x-site-layout>