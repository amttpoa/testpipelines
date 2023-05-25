<x-site-layout>
    @section("pageTitle")
    Instructional Videos
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl">Instructional Videos</div>
    </x-banner>

    <div class="bg-otsteel flex-1 flex flex-col">
        <div class="max-w-4xl p-6 sm:px-10 flex-1 w-full bg-white mx-auto">

            @guest
            <div class="text-center">
                <div class="font-medium text-xl">
                    This page is for conference instructors only. Please login to view instructional videos.
                </div>
                <div class="mt-5">
                    <x-button-link-site href="{{ route('login') }}" class="text-xl">Login</x-button-link-site>
                </div>
            </div>
            @endguest

            @auth

            @can('conference-instructor')
            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    User Accounts &amp; Password Reset
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/jWPyYDgveN4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    How to Update Your Profile
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/zYAL0Mv04vw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    Update Profile Image
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/VNppRKfPEOw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    Hotel Room Reservation Guide
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/vNFLvwaymww" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    Courses Instructing
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/l_bKLbFSuiA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    Lead and Assistant Instructors
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/qB0MAhrE-L0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mb-8">
                <div class="text-center font-medium mb-2 text-lg md:text-2xl">
                    Expense Reimbursement Guide
                </div>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/QANGxeS-oVM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            @else
            <div class="font-medium text-xl text-center">
                This page is for conference instructors only.
            </div>
            @endcan

            @endauth

        </div>
    </div>


</x-site-layout>