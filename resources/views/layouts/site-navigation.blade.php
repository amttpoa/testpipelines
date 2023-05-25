<div class="relative">
    <div x-data="{ open: false }" class="bg-white">
        <nav class=" max-w-screen-2xl mx-auto flex items-center justify-between py-6 px-4 sm:px-6">
            <div class="flex justify-between items-center flex-1">

                <div class="flex items-center justify-between w-full lg:w-auto">
                    <a href="/">
                        <img class="h-12 lg:h-24" src="/img/logo-new.png" alt="TTPOA">
                    </a>
                    <div :class="{'block': !open, 'hidden': open}">
                        <div class="-mr-2 flex items-center lg:hidden">
                            <button @click="open = true" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div :class="{'block': open, 'hidden': !open}">
                        <div class="-mr-2 lg:hidden">
                            <button @click="open = false" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block md:ml-8 xl:ml-32 flex-1">

                    <div class="mx-auto">
                        <div class="flex items-center mx-auto">

                            <a href="/" class="px-4 flex items-center font-medium  focus:outline-none transition duration-150 ease-in-out text-sm xl:text-base">
                                <span>Home</span>
                            </a>

                            <div class="inline-block text-left" x-data="{ openDropdown: false }">
                                <div class="text-sm xl:text-base">
                                    <button @click="openDropdown = true" class=" px-4  flex items-center font-medium  focus:outline-none transition duration-150 ease-in-out">
                                        <span class="mr-2">Training</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div x-show="openDropdown" @click.away="openDropdown = false" x-transition:enter="duration-100 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-75 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="pt-6 origin-top absolute z-10 right-0 left-0 mt-14 w-full shadow-lg bg-otsteel-200 ring-1 ring-gray-500 ring-opacity-50" style="display: none;">
                                    <div class="grid grid-cols-3 max-w-screen-xl mx-auto">
                                        <div class="p-4 border-r border-otsteel">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Annual Training Conference</div>
                                            @foreach($activeConferences as $conference)
                                            <a href="{{ route('conference', $conference) }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                {{ $conference->name }}
                                            </a>
                                            <a href="{{ route('conference.vendors', $conference) }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Companies Registered to Exhibit
                                            </a>
                                            @endforeach
                                            <a href="{{ route('conference-hotels') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Conference Hotels
                                            </a>
                                            <a href="{{ route('conference-agenda-attendee') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Conference Agenda for Attendees
                                            </a>
                                            <a href="{{ route('conferences') }}" class="hidden block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Conferences
                                            </a>
                                        </div>

                                        <div class="p-4 border-r border-otsteel">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Advanced Training</div>

                                            <a href="{{ route('trainings') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Advanced Training Courses
                                            </a>
                                            <a href="{{ route('partners') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Training Partners
                                            </a>
                                            <a href="{{ route('host') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Host a TTPOA Training Class
                                            </a>
                                            <a href="{{ route('events.index') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Regional Leadership Luncheon
                                            </a>
                                        </div>

                                        <div class="p-4">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Training Resources</div>
                                            <a href="{{ route('venues') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Venues
                                            </a>
                                            <a href="{{ route('hotels') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Hotels
                                            </a>
                                            <a href="{{ route('faqs-site') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Frequently Asked Questions
                                            </a>
                                        </div>
                                    </div>
                                    <div class="h-12 mt-6 bg-otblue"></div>
                                </div>
                            </div>



                            <div class="inline-block text-left" x-data="{ openDropdown: false }">
                                <div class="text-sm xl:text-base">
                                    <button @click="openDropdown = true" class=" px-4  flex items-center font-medium  focus:outline-none transition duration-150 ease-in-out">
                                        <span class="mr-2">Vendors</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div x-show="openDropdown" @click.away="openDropdown = false" x-transition:enter="duration-100 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-75 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="pt-6 origin-top absolute z-10 right-0 left-0 mt-14 w-full shadow-lg bg-otsteel-200 ring-1 ring-gray-500 ring-opacity-50" style="display: none;">
                                    <div class="grid grid-cols-3 max-w-screen-xl mx-auto">
                                        <div class="p-4 border-r border-otsteel">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Vendor Resources</div>

                                            <a href="{{ route('vendors') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Preferred Vendors Directory
                                            </a>
                                            <a href="{{ route('w9') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                OTOA W-9 Form
                                            </a>
                                            <a href="{{ route('media-kit') }}" class="hidden Xblock px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Media Kit
                                            </a>
                                            <a href="{{ route('faqs-site') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Frequently Asked Questions
                                            </a>
                                        </div>

                                        <div class="p-4 border-r border-otsteel">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Conference Vendors</div>

                                            @foreach($activeConferences as $conference)
                                            <a href="{{ route('conference.vendors', $conference) }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Companies Registered to Exhibit
                                            </a>
                                            <a href="{{ route('conference.sponsorships', $conference) }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Booth Options &amp; Sponsorships
                                            </a>
                                            <a href="{{ route('conference.vendor-information', $conference) }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Exhibitor Information
                                            </a>
                                            @endforeach
                                            <a href="{{ route('ad-specs') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Conference Brochure Ad Specs
                                            </a>
                                            <a href="{{ route('conference-hotels') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Conference Hotels
                                            </a>
                                        </div>

                                        <div class="p-4">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Premier Corporate Sponsor</div>

                                        </div>

                                    </div>
                                    <div class="h-12 mt-6 bg-otblue"></div>
                                </div>
                            </div>


                            <div class="inline-block text-left" x-data="{ openDropdown: false }">
                                <div class="text-sm xl:text-base">
                                    <button @click="openDropdown = true" class=" px-4  flex items-center font-medium  focus:outline-none transition duration-150 ease-in-out">
                                        <span class="mr-2">About Us</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div x-show="openDropdown" @click.away="openDropdown = false" x-transition:enter="duration-100 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-75 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="pt-6 origin-top absolute z-10 right-0 left-0 mt-14 w-full shadow-lg bg-otsteel-200 ring-1 ring-gray-500 ring-opacity-50" style="display: none;">
                                    <div class="grid grid-cols-3 max-w-screen-xl mx-auto">
                                        <div class="p-4 border-r border-otsteel">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">TTPOA Resources</div>

                                            <a href="{{ route('staff') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                TTPOA Staff
                                            </a>
                                            <a href="{{ route('w9') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                TTPOA W-9 Form
                                            </a>
                                            <a href="{{ route('media-kit') }}" class="hidden Xblock px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Media Kit
                                            </a>
                                            <a href="{{ route('faqs-site') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Frequently Asked Questions
                                            </a>
                                        </div>

                                        <div class="p-4 border-r border-otsteel">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Awards</div>

                                            <a href="{{ route('awards.index') }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                Awards
                                            </a>
                                            <div class="">
                                                @foreach($navAwards as $award)
                                                <a href="{{ route('awards.show', $award) }}" class="block px-4 py-2 hover:text-otblue hover:bg-otblue-50">
                                                    {{ $award->name }}
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="p-4">
                                            <div class="text-3xl font-blender font-bold px-4 pb-2">Contact</div>
                                            <div class="px-4 pb-2">
                                                <a href="{{ route('contact') }}">
                                                    <div>

                                                        Texas Tactical Police Officers Association (TTPOA)<br>
                                                        PO Box 304<br>
                                                        Burnet, Texas 78611
                                                    </div>

                                                </a>
                                                <div class="mt-4">
                                                    <a href="mailto:office@ttpoa.org" class="font-medium hover:text-otgold">office@ttpoa.org</a><br>
                                                    <a href="tel:3254556720">(325) 455-6720</a>
                                                </div>
                                                <div class="mt-4">
                                                    {{-- <a class="text-xl inline-flex items-center font-medium text-otblue" href="/contact">
                                                        Contact Us <i class="fas fa-angle-right ml-2"></i>
                                                    </a> --}}
                                                    <x-button-link-site href="{{ route('contact') }}">Contact Us</x-button-link-site>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-12 mt-6 bg-otblue"></div>
                                </div>
                            </div>

                            <a href="https://ttpoastore.org/" class="px-4 flex items-center font-medium  focus:outline-none transition duration-150 ease-in-out text-sm xl:text-base" target="_blank">
                                <span>Shop</span>
                            </a>


                        </div>
                    </div>

                </div>
                <div class="hidden lg:block md:ml-10 font-medium text-sm xl:text-base">

                    <div class="inline-block text-left relative" x-data="{ openUserMenu: false }">
                        @auth
                        <div class="text-sm xl:text-base">
                            <button @click="openUserMenu = true" class="flex items-center font-medium  focus:outline-none transition duration-150 ease-in-out">

                                <x-profile-image class="w-12 h-12 mr-2" :profile="auth()->user()->profile" />

                                <span class="mr-2">{{ auth()->user()->name }}</span>

                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>

                        <div x-show="openUserMenu" @click.away="openUserMenu = false" x-transition:enter="duration-100 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-75 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="w-60 origin-top-right absolute z-10 right-0 mt-6 shadow-lg bg-white ring-1 ring-gray-500 ring-opacity-50" style="display: none;">

                            <div class="px-4 py-2 border-b border-black bg-otsteel-200">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="p-2">
                                @can('admin-dashboard')
                                <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap block p-2 hover:bg-otsteel-100">Admin Dashboard</a>
                                @endcan

                                <a href="{{ route('dashboard') }}" class="whitespace-nowrap block p-2 hover:bg-otsteel-100">Dashboard</a>
                                <a href="{{ route('dashboard.profile') }}" class="whitespace-nowrap block p-2 hover:bg-otsteel-100">My Profile</a>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <a onclick="event.preventDefault();this.closest('form').submit();" class="flex gap-2 items-center whitespace-nowrap block p-2 hover:bg-otsteel-100" href="{{ route('logout') }}">
                                        <svg class="w-4 h-4 hidden" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Logout</span>
                                    </a>
                                </form>

                                @if(session()->has('backto'))
                                <form method="POST" action="{{ route('users.back-to-me') }}" class="w-full">
                                    @csrf
                                    <a onclick="event.preventDefault();this.closest('form').submit();" class="flex gap-2 items-center whitespace-nowrap block p-2 hover:bg-otsteel-100" href="{{ route('users.back-to-me') }}">
                                        <span>Back to me</span>
                                    </a>
                                </form>
                                @endif


                            </div>
                        </div>
                        @endauth

                    </div>

                    @guest
                    <a href="{{ route('login') }}" class="mr-4">Login</a>
                    {{-- <a class="ml-4 inline-flex items-center h-10 px-6 transition-colors duration-150 bg-otgold rounded-full border border-otgold focus:shadow-outline hover:bg-otgold-400" href="{{ route('register') }}">Join</a> --}}
                    <x-button-link-site href="{{ route('register') }}">Sign Up</x-button-link-site>
                    @endguest
                </div>
            </div>
        </nav>


        {{-- Mobile Nav --}}
        <div class="absolute z-50  inset-x-0  lg:hidden">
            <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100 scale-y-100" x-transition:leave-end="opacity-0 scale-y-0" class="rounded-lg shadow-md transition transform origin-top" style="display: none;">
                <div class="bg-otblue shadow-xs overflow-hidden border-y border-white">

                    <div class="text-white" x-data="{selected:null}">

                        <div class="w-full font-medium">
                            <a href="/" class="block p-4 px-6">Home</a>
                        </div>

                        @can('admin-dashboard')
                        <div class="w-full font-medium border-t border-white">
                            <a href="{{ route('admin.dashboard') }}" class="block p-4 px-6">Admin Dashboard</a>
                        </div>
                        @endcan

                        <x-nav.mobile-main @click="selected = (selected !== 'Training' ? 'Training' : null)">Training</x-nav.mobile-main>
                        <div class="relative overflow-hidden transition-all max-h-0 duration-400 bg-otblue-700" x-ref="containerTraining" x-bind:style="selected == 'Training' ? 'max-height: ' + $refs.containerTraining.scrollHeight + 'px' : ''" style="">
                            @foreach($activeConferences as $conference)
                            <x-nav.mobile-sub href="{{ route('conference', $conference) }}">{{ $conference->name }}</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('conference.vendors', $conference) }}">Companies Registered to Exhibit</x-nav.mobile-sub>
                            @endforeach
                            <x-nav.mobile-sub href="{{ route('conference-hotels') }}">Conference Hotels</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('conference-agenda-attendee') }}">Conference Agenda for Attendees</x-nav.mobile-sub>


                            <x-nav.mobile-sub href="{{ route('trainings') }}">Advanced Training Courses</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('partners') }}">Training Partners</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('host') }}">Host a TTPOA Training Class</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('events.index') }}">Regional Leadership Luncheon</x-nav.mobile-sub>


                            <x-nav.mobile-sub href="{{ route('venues') }}">Venues</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('hotels') }}">Hotels</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('faqs-site') }}">Frequently Asked Questions</x-nav.mobile-sub>
                        </div>

                        <x-nav.mobile-main @click="selected = (selected !== 'Vendors' ? 'Vendors' : null)">Vendors</x-nav.mobile-main>
                        <div class="relative overflow-hidden transition-all max-h-0 duration-400 bg-otblue-700" x-ref="containerVendors" x-bind:style="selected == 'Vendors' ? 'max-height: ' + $refs.containerVendors.scrollHeight + 'px' : ''" style="">
                            <x-nav.mobile-sub href="{{ route('vendors') }}">Preferred Vendors Directory</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('w9') }}">TTPOA W-9 Form</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('faqs-site') }}">Frequently Asked Questions</x-nav.mobile-sub>

                            @foreach($activeConferences as $conference)
                            <x-nav.mobile-sub href="{{ route('conference.vendors', $conference) }}">Companies Registered to Exhibit</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('conference.sponsorships', $conference) }}">Booth Options &amp; Sponsorships</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('conference.vendor-information', $conference) }}">Exhibitor Information</x-nav.mobile-sub>
                            @endforeach
                            <x-nav.mobile-sub href="{{ route('ad-specs') }}">Conference Brochure Ad Specs</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('conference-hotels') }}">Conference Hotels</x-nav.mobile-sub>
                        </div>


                        <x-nav.mobile-main @click="selected = (selected !== 'About' ? 'About' : null)">About Us</x-nav.mobile-main>
                        <div class="relative overflow-hidden transition-all max-h-0 duration-400 bg-otblue-700" x-ref="containerAbout" x-bind:style="selected == 'About' ? 'max-height: ' + $refs.containerAbout.scrollHeight + 'px' : ''" style="">
                            <x-nav.mobile-sub href="{{ route('staff') }}">TTPOA Staff</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('w9') }}">TTPOA W-9 Form</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('faqs-site') }}">Frequently Asked Questions</x-nav.mobile-sub>

                            <x-nav.mobile-sub href="{{ route('awards.index') }}">Awards</x-nav.mobile-sub>
                            @foreach($navAwards as $award)
                            <x-nav.mobile-sub href="{{ route('awards.show', $award) }}">{{ $award->name }}</x-nav.mobile-sub>
                            @endforeach

                            <x-nav.mobile-sub href="{{ route('contact') }}">Contact Us</x-nav.mobile-sub>
                        </div>
                        <div class="w-full font-medium border-t border-white">
                            <a href="https://ttpoastore.org/" class="block p-4 px-6" target="_blank">Shop</a>
                        </div>

                        @auth
                        <x-nav.mobile-main class="bg-otgold" @click="selected = (selected !== 'Member' ? 'Member' : null)">Member Dashboard</x-nav.mobile-main>
                        <div class="relative overflow-hidden transition-all max-h-0 duration-400 bg-otgold-500" x-ref="containerMember" x-bind:style="selected == 'Member' ? 'max-height: ' + $refs.containerMember.scrollHeight + 'px' : ''" style="">
                            <x-nav.mobile-sub href="{{ route('dashboard') }}">Dashboard</x-nav.mobile-sub>

                            @can('organization-admin')
                            <x-nav.mobile-sub href="{{ route('dashboard.organization.index') }}"> My Organization</x-nav.mobile-sub>
                            @endcan

                            @canany(['customer', 'staff'])
                            <x-nav.mobile-sub href="{{ route('dashboard.trainings.index') }}">My Advanced Training</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('dashboard.conferences.index') }}">My Conference Training</x-nav.mobile-sub>
                            @endcanany

                            @can('vendor')
                            @if(auth()->user()->organization)
                            <x-nav.mobile-sub href="{{ route('dashboard.company.edit') }}">My Company</x-nav.mobile-sub>
                            @endif
                            @endcan

                            <x-nav.mobile-sub href="{{ route('dashboard.upload-files.folders') }}">File Sharing</x-nav.mobile-sub>

                            <x-nav.mobile-sub href="{{ route('dashboard.profile') }}">My Profile</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('dashboard.profileImage') }}">Profile Image</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('dashboard.changePassword') }}">Change Password</x-nav.mobile-sub>
                        </div>

                        @canany(['staff','staff-instructor','conference-instructor'])
                        <x-nav.mobile-main class="bg-otgold" @click="selected = (selected !== 'Staff' ? 'Staff' : null)">Staff Menu</x-nav.mobile-main>
                        <div class="relative overflow-hidden transition-all max-h-0 duration-400 bg-otgold-500" x-ref="containerStaff" x-bind:style="selected == 'Staff' ? 'max-height: ' + $refs.containerStaff.scrollHeight + 'px' : ''" style="">
                            @can('staff-instructor')
                            <x-nav.mobile-sub href="{{ route('dashboard.staff.trainings.index') }}">Advanced Training <span class="text-xs">I'm teaching</span></x-nav.mobile-sub>
                            @endcan
                            @can('conference-instructor')
                            <x-nav.mobile-sub href="{{ route('dashboard.staff.conferences.index') }}">Conferences <span class="text-xs">I'm teaching at</span></x-nav.mobile-sub>
                            @endcan
                            <x-nav.mobile-sub href="{{ route('dashboard.staff.expenses.index') }}">Expenses</x-nav.mobile-sub>
                            <x-nav.mobile-sub href="{{ route('dashboard.staff.staffDirectory') }}">Staff Directory</x-nav.mobile-sub>
                            @can('staff')
                            <x-nav.mobile-sub href="{{ route('dashboard.staff.signature-generator') }}">Signature Generator</x-nav.mobile-sub>
                            @endcan
                            @can('conference-instructor')
                            <x-nav.mobile-sub href="{{ route('instructional-videos') }}">Instructional Videos</x-nav.mobile-sub>
                            @endcan
                        </div>
                        @endcanany
                        @endauth


                        <div class="bg-otsteel-200">

                            @auth
                            <div class="flex items-center font-medium p-4">

                                <a class="flex-1 flex items-center" href="{{ route('dashboard') }}">
                                    <x-profile-image class="w-8 h-8 mr-2" :profile="auth()->user()->profile" />
                                    <span class="text-otblue flex-1">{{ auth()->user()->name }}</span>
                                </a>
                                <div>
                                    <form method="POST" action="{{ route('logout') }}" class="">
                                        @csrf
                                        <a class="text-otgold font-semibold" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
                                    </form>
                                    @if(session()->has('backto'))
                                    <form method="POST" action="{{ route('users.back-to-me') }}" class="">
                                        @csrf
                                        <a class="text-otgold font-semibold" href="{{ route('users.back-to-me') }}" onclick="event.preventDefault();this.closest('form').submit();">Back to me</a>
                                    </form>
                                    @endif
                                </div>

                            </div>
                            @endauth
                            @guest
                            <div class="p-4 text-otblue">
                                <a class="text-otgold font-semibold" href="{{ route('login') }}">Login</a> or
                                <a class="text-otgold font-semibold" href="{{ route('register') }}">Sign Up</a>
                            </div>
                            @endguest
                        </div>




                    </div>

                </div>
            </div>
        </div>
    </div>
</div>