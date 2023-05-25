<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="data()">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TTPOA') }}</title>

    @livewireStyles

    <link rel="shortcut icon" href="/img/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Mulish:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,400;1,500;1,700&family=Titan+One&display=swap" rel="stylesheet">

    <!-- Styles -->
    {{-- dropbox CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">



    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    {{-- dropbox CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/yrmlcmxvtq83pf7jwaox64zraw9vk2az0cg0gpgb7so3om7l/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.proto.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Production -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>



    <link rel="stylesheet" href="/css/app.css">

    <script src="/js/init-alpine.js"></script>


    <script>
        tinymce.init({
                selector: '.addTiny',
                // plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
                // toolbar_mode: 'floating',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                // editimage_cors_hosts: ['picsum.photos'],
                // menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline | blocks link | alignleft aligncenter alignright alignjustify | outdent indent | image table numlist bullist | code',
                toolbar_sticky: true,
                toolbar_sticky_offset: 100,

                // toolbar_sticky: true,
                // toolbar_sticky_offset: 100,
                menubar: false,
                // paste_as_text: true,
                // image_advtab: true,
                relative_urls: false,
                convert_urls: false,
                // tools: "inserttable",
                // toolbar: "undo redo | styleselect | bold italic underline | link image | table | bullist numlist outdent indent | code | pastetext"
    
            });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
                $(".addDatePicker").flatpickr({
                    dateFormat: "m/d/Y",
                    disableMobile: "true"
                });
            });
    </script>


</head>

<body>
    <div class="flex h-screen bg-otsteel-100" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        <aside class="z-20 hidden w-64 overflow-y-auto bg-otblue md:block flex-shrink-0">
            <div class="py-4">
                <div class="px-4 text-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-center inline-flex items-center gap-2">
                        <img src="/img/logo-white.png" class="w-60" />
                    </a>
                </div>
                <ul class="mt-6">

                    <x-nav-main-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <x-icons.home class="w-5 h-5" />
                        <span class="ml-4">Dashboard</span>
                    </x-nav-main-link>


                    @can('full-access')
                    <x-nav-main-link :href="route('admin.users.index')" :active="request()->routeIs(['admin.users.*', 'admin.profiles.*'])">
                        <x-icons.users class="w-5 h-5" />
                        <span class="ml-4">Users</span>
                    </x-nav-main-link>

                    <x-nav-main-link :href="route('admin.organizations.index')" :active="request()->routeIs('admin.organizations.*')">
                        <x-icons.organization class="w-5 h-5" />
                        <span class="ml-4">Organizations</span>
                    </x-nav-main-link>
                    @endcan

                    @canany(['full-access', 'vendor-registrations', 'live-fire', 'hotel-requests'])
                    <x-nav-main-link :href="route('admin.conferences.index')" :active="request()->routeIs('admin.conferences.*', 'admin.vendor-registration-submissions.*', 'admin.conference-attendees.*', 'admin.courses.*', 'admin.course-attendees.*')">
                        <x-icons.conference class="w-5 h-5" />
                        <span class="ml-4">Conferences</span>
                    </x-nav-main-link>
                    @endcanany

                    @can('full-access')
                    <x-nav-main-link :href="route('admin.trainings.index')" :active="request()->routeIs('admin.trainings.*', 'admin.training-courses.*', 'admin.training-course-attendees.*')">
                        <x-icons.gun class="w-5 h-5" />
                        <span class="ml-4">Trainings</span>
                    </x-nav-main-link>
                    @endcan

                    @can('full-access')
                    <x-nav-main-link :href="route('admin.expenses.index')" :active="request()->routeIs('admin.expenses.*')">
                        <x-icons.money class="w-5 h-5" />
                        <span class="ml-4">Expenses</span>
                    </x-nav-main-link>
                    @endcan

                    @role('Super Admin')
                    <x-nav-main-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        <x-icons.roles class="w-5 h-5" />
                        <span class="ml-4">Roles</span>
                    </x-nav-main-link>
                    @endrole

                    @role('Awards Coordinator')
                    <x-nav-main-link :href="route('admin.award-submissions.index')" :active="request()->routeIs('admin.award-submissions.*')">
                        <x-icons.roles class="w-5 h-5" />
                        <span class="ml-4">Award Submissions</span>
                    </x-nav-main-link>
                    @endrole

                    @can('full-access')
                    <li class="relative">
                        <button class="px-5 py-3 flex items-center w-full text-sm font-semibold text-white transition-colors duration-150 hover:opacity-90 bg-otblue-900" @click="togglePagesMenu" aria-haspopup="true">
                            <span class="inline-flex items-center flex-1">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                </svg>
                                <span class="ml-4">Other Pages</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <template x-if="isPagesMenuOpen">
                            <ul class="overflow-hidden rounded m-4 p-1 bg-otblue-600 x-transition:enter=" transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" aria-label="submenu">
                                <x-nav-sub-link :href="route('admin.subscribes.index')" :active="request()->routeIs('admin.subscribes.*')">
                                    Subscribes
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                                    Events
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.faqs.index')" :active="request()->routeIs('admin.faqs.*')">
                                    Faqs
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.faqCategories.index')" :active="request()->routeIs('admin.faqCategories.*')">
                                    Faq Categories
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.vendors.index')" :active="request()->routeIs('admin.vendors.*')">
                                    Vendors
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.venues.index')" :active="request()->routeIs('admin.venues.*')">
                                    Venues
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.hotels.index')" :active="request()->routeIs('admin.hotels.*')">
                                    Hotels
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.staffs.index')" :active="request()->routeIs('admin.staffs.*')">
                                    Staff
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.email-templates.index')" :active="request()->routeIs('admin.email-templates.*')">
                                    Email Templates
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                                    Pages
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.awards.index')" :active="request()->routeIs('admin.awards.*')">
                                    Awards
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.award-submissions.index')" :active="request()->routeIs('admin.award-submissions.*')">
                                    Award Submissions
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.upload-folders.index')" :active="request()->routeIs('admin.upload-folders.*')">
                                    Upload Folders
                                </x-nav-sub-link>
                                <x-nav-sub-link :href="route('admin.upload-files.index')" :active="request()->routeIs('admin.upload-files.*')">
                                    Upload Files
                                </x-nav-sub-link>
                            </ul>
                        </template>

                    </li>
                    @endcan


                </ul>

                @canany(['full-access', 'vendor-registrations', 'live-fire', 'hotel-requests'])
                <div class="px-6 my-6">
                    @foreach($activeConferences as $conference)
                    <x-button-link class="text-center" href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-button-link>
                    @endforeach
                </div>
                @endcanany

            </div>
        </aside>
        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <div style="display:none;" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-gray-900 bg-opacity-50 sm:items-center sm:justify-center"></div>
        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-0 overflow-y-auto bg-gray-900 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
            <div class="py-4">
                <div class="px-4 text-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-center inline-flex items-center gap-2">
                        <img src="/img/logo-gold.png" class="w-16" />
                        <div class="text-6xl font-blender font-black text-white">OTOA</div>
                    </a>
                </div>
                <ul class="mt-6">

                    <x-nav-main-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <x-icons.home class="w-5 h-5" />
                        <span class="ml-4">Dashboard</span>
                    </x-nav-main-link>


                    @can('full-access')
                    <x-nav-main-link :href="route('admin.users.index')" :active="request()->routeIs(['admin.users.*', 'admin.profiles.*'])">
                        <x-icons.users class="w-5 h-5" />
                        <span class="ml-4">Users</span>
                    </x-nav-main-link>

                    <x-nav-main-link :href="route('admin.organizations.index')" :active="request()->routeIs('admin.organizations.*')">
                        <x-icons.organization class="w-5 h-5" />
                        <span class="ml-4">Organizations</span>
                    </x-nav-main-link>
                    @endcan

                    @canany(['full-access', 'vendor-registrations', 'live-fire', 'hotel-requests'])
                    <x-nav-main-link :href="route('admin.conferences.index')" :active="request()->routeIs('admin.conferences.*', 'admin.vendor-registration-submissions.*', 'admin.conference-attendees.*', 'admin.courses.*', 'admin.course-attendees.*')">
                        <x-icons.conference class="w-5 h-5" />
                        <span class="ml-4">Conferences</span>
                    </x-nav-main-link>
                    @endcanany

                    @can('full-access')
                    <x-nav-main-link :href="route('admin.trainings.index')" :active="request()->routeIs('admin.trainings.*', 'admin.training-courses.*', 'admin.training-course-attendees.*')">
                        <x-icons.gun class="w-5 h-5" />
                        <span class="ml-4">Trainings</span>
                    </x-nav-main-link>
                    @endcan


                    @role('Super Admin')
                    <x-nav-main-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        <x-icons.roles class="w-5 h-5" />
                        <span class="ml-4">Roles</span>
                    </x-nav-main-link>
                    @endrole

                    @role('Awards Coordinator')
                    <x-nav-main-link :href="route('admin.award-submissions.index')" :active="request()->routeIs('admin.award-submissions.*')">
                        <x-icons.roles class="w-5 h-5" />
                        <span class="ml-4">Award Submissions</span>
                    </x-nav-main-link>
                    @endrole

                    @can('full-access')
                    <li class="relative">
                        <button class="px-5 py-3 flex items-center w-full text-sm font-semibold text-white transition-colors duration-150 hover:opacity-90 bg-otblue-900" @click="togglePagesMenu" aria-haspopup="true">
                            <span class="inline-flex items-center flex-1">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                </svg>
                                <span class="ml-4">Other Pages</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <template x-if="isPagesMenuOpen">
                            <ul class="overflow-hidden rounded m-4 p-1 bg-otblue-600 x-transition:enter=" transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" aria-label="submenu">
                                <x-nav-sub-link :href="route('admin.faqs.index')" :active="request()->routeIs('admin.faqs.*')">
                                    Faqs
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.faqCategories.index')" :active="request()->routeIs('admin.faqCategories.*')">
                                    Faq Categories
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.vendors.index')" :active="request()->routeIs('admin.vendors.*')">
                                    Vendors
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.venues.index')" :active="request()->routeIs('admin.venues.*')">
                                    Venues
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.hotels.index')" :active="request()->routeIs('admin.hotels.*')">
                                    Hotels
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.staffs.index')" :active="request()->routeIs('admin.staffs.*')">
                                    Staff
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.email-templates.index')" :active="request()->routeIs('admin.email-templates.*')">
                                    Email Templates
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.pages.index')" :active="request()->routeIs('admin.pages.*')">
                                    Pages
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.awards.index')" :active="request()->routeIs('admin.awards.*')">
                                    Awards
                                </x-nav-sub-link>

                                <x-nav-sub-link :href="route('admin.award-submissions.index')" :active="request()->routeIs('admin.award-submissions.*')">
                                    Award Submissions
                                </x-nav-sub-link>
                            </ul>
                        </template>

                    </li>
                    @endcan


                </ul>

                @canany(['full-access', 'vendor-registrations', 'live-fire', 'hotel-requests'])
                <div class="px-6 my-6">
                    @foreach($activeConferences as $conference)
                    <x-button-link class="text-center" href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-button-link>
                    @endforeach
                </div>
                @endcanany

            </div>
        </aside>
        <div class="flex flex-col flex-1 w-full">
            <header class="relative z-10 py-2 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between h-full px-6 mx-auto text-aqua">
                    <!-- Mobile hamburger -->
                    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-aqua" @click="toggleSideMenu" aria-label="Menu">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    @role('AdminXX')

                    <div class="flex justify-center flex-1 lg:mr-32">

                    </div>

                    {{-- <div class="flex-1"></div> --}}
                    <!-- Search input -->
                    {{-- <div class="flex justify-center flex-1 lg:mr-32">
                        <div class="relative w-full max-w-xl mr-6 focus-within:text-aqua">
                            <div class="absolute inset-y-0 flex items-center pl-2">
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <form action="{{ route('users.index') }}" method="GET" id="serachForm">
                                <input id="autocomplete" class="w-full pl-8 pr-2 text-sm text-aqua placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-aqua focus:outline-none focus:shadow-outline-aqua form-input" type="text" placeholder="Search users" aria-label="Search" />
                                <input type="hidden" name="user_id" id="user_id">
                            </form>
                        </div>
                    </div>
                    <script>
                        $( function() {
                          
                            var availableTags = [
                               
                            ];
                            $( "#autocomplete" ).autocomplete({
                            source: availableTags,
                            focus: function( event, ui ) {
                                $( "#autocomplete" ).val( ui.item.label );
                                return false;
                            },
                            select: function( event, ui ) {
                                $( "#autocomplete" ).val( ui.item.label );
                                $( "#user_id" ).val( ui.item.value );
                                $( "#serachForm" ).submit();
                                return false;
                            }
                            });
                        } );
                    </script> --}}

                    @else
                    <div class="flex-1">

                        <div>
                            <x-messages />
                        </div>
                    </div>
                    @endrole
                    <ul class="flex items-center flex-shrink-0 space-x-6">

                        <!-- Notifications menu -->
                        <li class="relative">
                            <button class="hidden relative text-aqua align-middle rounded-md focus:outline-none focus:shadow-outline-aqua" @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu" aria-label="Notifications" aria-haspopup="true">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                                <!-- Notification badge -->
                                <span aria-hidden="true" class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
                            </button>
                            <ul style="display:none;" x-show="isNotificationsMenuOpen" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
                                <li class="flex">
                                    <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                                        <span>Messages</span>
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                            13
                                        </span>
                                    </a>
                                </li>
                                <li class="flex">
                                    <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                                        <span>Sales</span>
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                            2
                                        </span>
                                    </a>
                                </li>
                                <li class="flex">
                                    <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                                        <span>Alerts</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Profile menu -->
                        <li class="relative">
                            <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true">
                                <x-profile-image class="w-8 h-8" :profile="auth()->user()->profile" />
                            </button>
                            <ul style="display:none;" x-show="isProfileMenuOpen" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                                <li class="border-b border-gray-400 pb-2 mb-2">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                </li>

                                {{-- <li class="flex">
                                    <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="/">
                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>My Profile</span>
                                    </a>
                                </li> --}}
                                <li class="flex">
                                    <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="{{ route('dashboard') }}">
                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Site Dashboard</span>
                                    </a>
                                </li>
                                {{-- <li class="flex">
                                    <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Settings</span>
                                    </a>
                                </li> --}}
                                <li class="flex">
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <a onclick="event.preventDefault();this.closest('form').submit();" class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="{{ route('logout') }}">
                                            <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Log out</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </header>
            <main class="h-full overflow-y-auto">

                <div class="py-4 px-2 sm:px-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

@livewireScripts

</html>