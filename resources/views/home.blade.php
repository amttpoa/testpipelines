<x-site-layout>


    <div class="bg-black hidden">
        <img class="w-full max-w-screen-2xl mx-auto" src="/img/otoabanner-35thanniversary-protect-and-serve.jpg" />
    </div>



    @if(\Session::has('bot'))
    <div class="px-6 py-24 max-w-4xl text-2xl font-medium mx-auto text-center bg-white">
        You have not been registered.
    </div>
    @endif



    <div class="swiper w-full">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
                <div class="bg-cover bg-center h-full p-4 lg:p-8" style="background-image: url(/img/conference1.jpg)">
                    <div class="max-w-6xl mx-auto h-full content-center grid lg:grid-cols-2">
                        <div>
                        </div>
                        <div class="text-white text-center p-12" style="background-color: rgba(0,0,0,.7);">
                            <div class="font-medium text-3xl lg:text-5xl">Training Conference</div>
                            <div class="text-lg lg:text-xl mt-4">
                                Registration is now open
                            </div>
                            <div class="text-center mt-6 ">
                                <x-button-link-site class="text-lg lg:text-lg" href="{{ route('conference', $conference) }}">Register Now</x-button-link-site>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-cover bg-center h-full p-4 lg:p-8" style="background-image: url(/img/hero4.jpg)">
                    <div class="max-w-6xl mx-auto h-full content-center grid lg:grid-cols-2">
                        <div>
                        </div>
                        <div class="text-white text-center p-12" style="background-color: rgba(0,0,0,.7);">
                            <div class="font-medium text-3xl lg:text-5xl">Vendor Registration</div>
                            <div class="text-xl lg:text-2xl mt-4 font-semibold hidden">
                                New for 2023
                            </div>
                            <div class="text-lg lg:text-xl mt-4">
                                All companies are required to create a unique vendor company account with the TTPOA.
                            </div>
                            <div class="text-center mt-6 ">
                                <x-button-link-site class="text-lg lg:text-lg" href="{{ route('exhibitionRegistration', $conference) }}">Vendor Show Registration</x-button-link-site>
                            </div>
                            <div class="text-center mt-2 ">
                                <x-a href="{{ route('login') }}">I already have an account</x-a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="bg-cover bg-center h-full p-4 lg:p-8" style="background-image: url(/img/training-carousel1.jpg)">
                    <div class="max-w-6xl mx-auto h-full content-center grid lg:grid-cols-2">
                        <div>
                        </div>
                        <div class="text-white text-center p-12" style="background-color: rgba(0,0,0,.7);">
                            <div class="font-medium text-3xl lg:text-5xl">Advanced Training</div>
                            <div class="text-lg lg:text-xl mt-4">
                                Register to attended one of our advanced training courses
                            </div>
                            <div class="text-center mt-6 ">
                                <x-button-link-site class="text-lg lg:text-lg" href="{{ route('trainings') }}">Advanced Training Courses</x-button-link-site>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="swiper-slide">
                <div class="bg-cover bg-center h-full p-4 lg:p-8" style="background-image: url(/img/carousel2.jpg)">
                    <div class="max-w-6xl mx-auto h-full content-center grid lg:grid-cols-2">
                        <div class="text-white text-center p-12" style="background-color: rgba(0,0,0,.7);">
                            <div class="font-semibold text-3xl lg:text-5xl">2023 Training Conference and Vendor Show</div>
                            <div class="text-lg lg:text-xl mt-4">
                                Sign up for this years conference.
                                Maybe a <a class="text-otgold font-semibold" href="/conferences/2023-training-conference-and-vendor-show">link</a> to the conference or a button like below.
                            </div>
                            <div class="text-center mt-6 ">
                                <x-button-link-site class="text-lg lg:text-xl" href="/conferences/2023-training-conference-and-vendor-show">View Conference</x-button-link-site>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="bg-cover bg-center h-full p-4 lg:p-8" style="background-image: url(/img/otoabanner-35thanniversary-protect-and-serve.jpg)">
                    <div class="max-w-6xl mx-auto h-full content-center grid lg:grid-cols-2">
                        <div>
                        </div>
                        <div class="text-white text-center p-12" style="background-color: rgba(0,0,0,.7);">
                            <div class="font-semibold text-3xl lg:text-5xl">Vendor Exhibition Registration</div>
                            <div class="text-lg lg:text-xl mt-4">
                                This could say something about the Vendor Exhibition Registration.
                                Maybe say when they have to register by.
                                Maybe a <a class="text-otgold font-semibold" href="{{ route('exhibitionRegistration', $conference) }}">link</a> to the registration form or a button like below.
                            </div>
                            <div class="text-center mt-6 ">
                                <x-button-link-site class="text-lg lg:text-xl" href="{{ route('exhibitionRegistration', $conference) }}">Vendor Exhibition Registration</x-button-link-site>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}



        </div>
        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        {{--
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>


        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar"></div> --}}
    </div>


    <div class="bg-otdarkgray">
        <div class="px-6 py-24 max-w-4xl mx-auto text-center text-white">
            <h3 class="text-5xl uppercase font-blender font-bold mb-6">
                Our Mission
            </h3>
            <p class="leading-loose text-lg">
                The mission of the Texas Tactical Police Officer Association (TTPOA) is to provide training. Officers and Agencies decide on how to adapt or adopt it. We provide training for selected skill sets based on proven techniques and best practices. 
                <br><br>
                The burden of policy, application, and proficiency is on the agency and end user.
            </p>

        </div>
    </div>

    {{-- <div class="bg-white">
        <div class="px-6 py-24 pb-0 max-w-4xl mx-auto text-center text-white">
            <img src="/img/tactical_cartoon_2.jpg" alt="OTOA" />
        </div>
    </div> --}}

    <div class="bg-cover bg-center h-full p-4 lg:p-8" style="background-image: url(/img/terren-hurst-bl.png)">
        <div class="px-6 py-24 max-w-2xl mx-auto text-center text-white">
            <h3 class="text-5xl uppercase font-blender font-bold mb-8">
                Save the date
            </h3>
            <div class="text-3xl leading-relaxed">
                Annual TTPOA Conference
            </div>
            <div class="font-condensed text-2xl mt-4">
                April | 2024
            </div>
            <div class="mt-8">
                <x-button-link-site href="/conferences/tactical-operations-and-public-safety-conference">View Conference</x-button-link-site>
            </div>
        </div>
    </div>


    <section class="hidden">
        <div class="container max-w-5xl mx-auto m-8">

            <div class="flex flex-wrap items-center flex-col-reverse sm:flex-row">
                <div class="w-full sm:w-1/2 p-6 mt-6">
                    <img src="/img/logo-gold.png" class="w-full" />
                </div>
                <div class=" w-full sm:w-1/2 p-6 mt-6">
                    <div class="align-middle">
                        <h3 class="text-4xl text-gray-800 font-bold leading-none mb-3">
			Our Mission
		    </h3>
		    <p class="leading-loose text-lg">
			The mission of the Texas Tactical Police Officer Association (TTPOA) is to provide training. Officers and Agencies decide on how to adapt or adopt it. We provide training for selected skill sets based on proven techniques and best practices. 
			<br><br>
			The burden of policy, application, and proficiency is on the agency and end user.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="hidden bg-otsteel py-8">
        <div class="container max-w-5xl mx-auto m-8">

            <h1 class="hidden w-full my-4 text-5xl font-bold text-center">
                Upcoming Events
            </h1>

            <div class="flex flex-wrap items-center">
                <div class="w-5/6 sm:w-1/2 p-6">
                    <h3 class="text-4xl font-bold mb-2">
                        Save the date
                    </h3>
                    <p class="text-2xl font-semibold mb-4">
                        April | 2024
                    </p>
                    <p>
			Annual TTPOA Conference
                    </p>
                </div>
                <div class="w-full sm:w-1/2 p-6">
                    <img src="/img/otoa-2023-save-the-date-conference-350x350.png" class="w-full" />
                </div>
            </div>

        </div>
    </section>

    <style>
        .swiper {
            /* width: 600px; */
            height: 600px;
        }
    </style>

    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 10000,
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                // el: '.swiper-scrollbar',
                enabled: false,
            },
        });
    </script>


</x-site-layout>
