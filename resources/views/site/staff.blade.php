<x-site-layout>
    @section("pageTitle")
    Staff
    @endSection

    <x-banner bg="/img/training1.jpg">
        <div class="text-3xl lg:text-6xl">Staff</div>
    </x-banner>


    @foreach($sections as $section)

    <section class="{{ $loop->index % 2 ? 'bg-otsteel' : 'bg-white' }} py-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl lg:text-3xl lg:text-5xl font-bold font-blender text-center mb-4">{{ $section->name }}</h2>

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($section->staffs as $staff)
                <div class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 p-6 text-center font-medium text-2xl">
                    <a href="{{ route('staffProfile', $staff->user) }}">
                        <div>
                            <x-profile-image class="w-full" :profile="$staff->user->profile" />
                        </div>
                        <div class="mt-2">{{ $staff->user->name }}</div>
                        <div class="text-lg text-otgray">{{ $staff->title }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @endforeach
    {{--
    <section class="bg-otsteel py-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl lg:text-3xl lg:text-5xl font-bold font-blender text-center mb-4">Red Team</h2>

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($red as $staff)
                <div class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 p-6 text-center font-medium text-2xl">
                    <a href="{{ route('staffProfile', $staff->user) }}">
                        <div>
                            <x-profile-image class="w-full" :profile="$staff->user->profile" />
                        </div>
                        <div>{{ $staff->user->name }}</div>
                        <div class="text-lg text-otgray">{{ $staff->user->profile->title }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    {{--
    <section class="bg-otsteel py-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl lg:text-5xl font-bold font-blender text-center mb-4">Conference Instructors</h2>

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($conferenceInstructors as $user)
                <div class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 p-6 text-center font-medium text-2xl">
                    <a href="{{ route('staffProfile', $user) }}">
                        <div>
                            <x-profile-image class="w-full" :profile="$user->profile" />
                        </div>
                        <div>{{ $user->name }}</div>
                        <div class="text-lg text-otgray">{{ $user->profile->title }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl lg:text-5xl font-bold font-blender text-center mb-4">Advanced Training Instructors</h2>

            <div class="flex flex-wrap place-content-center mx-auto">
                @foreach($staffInstructors as $user)
                <div class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 p-6 text-center font-medium text-2xl">
                    <a href="{{ route('staffProfile', $user) }}">
                        <div>
                            <x-profile-image class="w-full" :profile="$user->profile" />
                        </div>
                        <div>{{ $user->name }}</div>
                        <div class="text-lg text-otgray">{{ $user->profile->title }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section> --}}



    <section class="bg-white border-b py-8 flex-1 hidden">

        <div class="">


            <section class="py-8">
                <h2 class="text-3xl lg:text-5xl font-bold font-blender text-center mb-4">Board of Directors</h2>

                <div class="container max-w-5xl mx-auto">

                    <div class="flex gap-8 flex-wrap items-center border-b border-otsteel py-8">
                        <div class="w-full sm:w-72">
                            <img src="/img/noimg.png" class="w-full rounded-full" />
                        </div>
                        <div class="w-full flex-1 sm:w-auto">
                            <div class="align-middle">
                                <h3 class="text-3xl font-semibold">
                                    Pat Fiorilli
                                </h3>
                                <div class="text-otsteel mb-4">
                                    Executive Director
                                </div>

                                <p class="">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti consequatur, temporibus libero optio, earum neque fugiat, sed amet inventore quam cum. Ipsum est consectetur molestiae quia provident aut, et tenetur!
                                    <br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio debitis repudiandae facere eum veritatis excepturi quaerat esse soluta, labore cumque. Iste reprehenderit alias earum eos illo consequuntur inventore porro illum?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-8 flex-wrap items-center py-8">
                        <div class="w-full sm:w-72">
                            <img src="/img/noimg.png" class="w-full rounded-full" />
                        </div>
                        <div class="w-full flex-1 sm:w-auto">
                            <div class="align-middle">
                                <h3 class="text-3xl font-semibold">
                                    Terry Graham
                                </h3>
                                <div class="text-otsteel mb-4">
                                    President / Director of Exhibitions
                                </div>

                                <p class="">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti consequatur, temporibus libero optio, earum neque fugiat, sed amet inventore quam cum. Ipsum est consectetur molestiae quia provident aut, et tenetur!
                                    <br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio debitis repudiandae facere eum veritatis excepturi quaerat esse soluta, labore cumque. Iste reprehenderit alias earum eos illo consequuntur inventore porro illum?
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section class="bg-otsteel py-8">
                <h2 class="text-5xl font-bold font-blender text-center mb-4">Advisory Council</h2>

                <div class="container max-w-5xl mx-auto">

                    <div class="flex gap-8 flex-wrap items-center border-b border-white py-8">
                        <div class="w-full sm:w-72">
                            <img src="/img/noimg.png" class="w-full rounded-full" />
                        </div>
                        <div class="w-full flex-1 sm:w-auto">
                            <div class="align-middle">
                                <h3 class="text-3xl font-semibold">
                                    Pat Fiorilli
                                </h3>
                                <div class="text-otsteel mb-4">
                                    Executive Director
                                </div>

                                <p class="">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti consequatur, temporibus libero optio, earum neque fugiat, sed amet inventore quam cum. Ipsum est consectetur molestiae quia provident aut, et tenetur!
                                    <br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio debitis repudiandae facere eum veritatis excepturi quaerat esse soluta, labore cumque. Iste reprehenderit alias earum eos illo consequuntur inventore porro illum?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-8 flex-wrap items-center py-8">
                        <div class="w-full sm:w-72">
                            <img src="/img/noimg.png" class="w-full rounded-full" />
                        </div>
                        <div class="w-full flex-1 sm:w-auto">
                            <div class="align-middle">
                                <h3 class="text-3xl font-semibold">
                                    Terry Graham
                                </h3>
                                <div class="text-otsteel mb-4">
                                    President / Director of Exhibitions
                                </div>

                                <p class="">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti consequatur, temporibus libero optio, earum neque fugiat, sed amet inventore quam cum. Ipsum est consectetur molestiae quia provident aut, et tenetur!
                                    <br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio debitis repudiandae facere eum veritatis excepturi quaerat esse soluta, labore cumque. Iste reprehenderit alias earum eos illo consequuntur inventore porro illum?
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>


            {{--

            <h2 class="text-2xl font-medium mb-4"></h2>
            <h2 class="text-2xl font-medium mb-4">Regional Directors</h2>
            <h2 class="text-2xl font-medium mb-4">County Representatives</h2>
            <h2 class="text-2xl font-medium mb-4">Training Administration &amp; Support</h2> --}}


        </div>
    </section>

</x-site-layout>