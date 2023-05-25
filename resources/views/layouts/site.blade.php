<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Google tag (gtag.js) -->
    <!-- put here -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('pageTitle')
        @yield('pageTitle') | TTPOA
        @else
        TTPOA
        @endif
    </title>

    @livewireStyles

    <link rel="shortcut icon" href="/img/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Mulish:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Roboto+Condensed:wght@300;400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,400;1,500;1,700&family=Titan+One&display=swap" rel="stylesheet">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="/css/app.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    <script src="https://cdn.tiny.cloud/1/yrmlcmxvtq83pf7jwaox64zraw9vk2az0cg0gpgb7so3om7l/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
                selector: '.addTiny',
                // plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
                // toolbar_mode: 'floating',
                // plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                // editimage_cors_hosts: ['picsum.photos'],
                // menubar: 'file edit view insert format tools table help',
                plugins: 'advlist lists',
                toolbar: 'undo redo | bold italic underline |  numlist bullist | pastetext',
                paste_as_text: true,

                // toolbar_sticky: true,
                // toolbar_sticky_offset: 100,
                menubar: false,
                // paste_as_text: true,
                // image_advtab: true,
                // relative_urls: false,
                // convert_urls: false,
                // tools: "inserttable",
                // toolbar: "undo redo | styleselect | bold italic underline | link image | table | bullist numlist outdent indent | code | pastetext"
    
            });

    </script>

    <link rel="stylesheet" href="/css/app.css">

</head>

<body>
    <div class="font-sans text-gray-900 antialiased flex flex-col min-h-screen">

        @include('layouts.site-navigation')

        <div class="relative flex-1 flex flex-col">
            <x-messages />

            {{ $slot }}
        </div>

        <!--Footer-->
        <footer class="bg-otblue text-white">
            <div class="max-w-screen-xl mx-auto px-6 py-16">
                <div class="flex flex-wrap gap-y-16 gap-x-4 lg:gap-x-16">
                    <div class="w-full lg:w-60 flex justify-center">
                        <a class="" href="/">
                            <img src="/img/logo-white.png" class="w-60" />
                        </a>
                    </div>
                    <div class="lg:pt-0 text-center lg:text-left w-full lg:w-auto lg:flex-1">
                        Texas Tactical Police Officers Association (TTPOA)<br>
                        PO Box 304<br>
                        Burnet, Texas 78611<br>
                        (325) 455-6720
                    </div>
                    <div class="lg:pt-0 flex-1">
                        <div class="mb-4">
                            <a href="{{ route('conferences') }}" class="hover:text-otgray-200">Conferences</a>
                        </div>
                        <div class="mb-4">
                            <a href="{{ route('trainings') }}" class="hover:text-otgray-200">Advanced Training</a>
                        </div>
                        <div class="mb-4">
                            <a href="{{ route('venues') }}" class="hover:text-otgray-200">Venues</a>
                        </div>
                        <div class="mb-4">
                            <a href="{{ route('hotels') }}" class="hover:text-otgray-200">Hotels</a>
                        </div>
                    </div>
                    <div class="lg:pt-0 flex-1">
                        <div class="mb-4">
                            <a href="{{ route('faqs-site') }}" class="hover:text-otgray-200">FAQs</a>
                        </div>
                        <div class="mb-4">
                            <a href="{{ route('staff') }}" class="hover:text-otgray-200">Staff</a>
                        </div>
                        <div class="mb-4">
                            <a href="{{ route('contact') }}" class="hover:text-otgray-200">Contact Us</a>
                        </div>
                        <div>
                            <a href="http://www.facebook.com/OhioTacticalOfficersAssociation" target="_blank">
                                <x-icons.facebook class="inline h-5 w-5 hover:text-otgray-200" />
                            </a>
                            <a href="https://twitter.com/OhioTacOA" class="ml-3" target="_blank">
                                <x-icons.twitter class="inline h-5 w-5 hover:text-otgray-200" />
                            </a>
                            <a href="http://www.linkedin.com/company/otoa/" class="ml-3" target="_blank">
                                <x-icons.linkedin class="inline h-5 w-5 hover:text-otgray-200" />
                            </a>
                            <a href="http://www.youtube.com/channel/UCcy1VFpAi4U8ZVZsrjU3LyQ" class="ml-3" target="_blank">
                                <x-icons.youtube class="inline h-5 w-5 hover:text-otgray-200" />
                            </a>
                            <a href="https://www.instagram.com/ohiotacticalofficers/" class="ml-3" target="_blank">
                                <x-icons.instagram class="inline h-5 w-5 hover:text-otgray-200" />
                            </a>
                        </div>
                    </div>


                </div>
            </div>
            <div class="text-center mb-4 px-6">
                If you are looking for the old site, please visit <a class="font-bold underline" href="https://ttpoa.org" target="_blank">ttpoa.org</a>
            </div>

        </footer>

    </div>
</body>

@livewireScripts

@yield("scripts")

</html>