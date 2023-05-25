<x-site-layout>
    <div class="bg-otgold text-white">
        <div class="px-10 py-4 max-w-7xl mx-auto">
            <div class="font-semibold text-3xl font-blender text-center">
                Dashboard
            </div>
        </div>
    </div>

    <div class="bg-otsteel flex-1">
        <div class="lg:px-4 py-6 max-w-7xl mx-auto">


            <div class="lg:flex">

                <div class="hidden lg:block w-52 bg-otgold text-white">
                    <div class="bg-otblue border-b border-white pb-6">
                        <div class="p-6 pb-2">
                            <div class="relative">
                                @can('vendor')
                                <img class="w-40 h-40 object-contain" src="{{ Storage::disk('s3')->url('organizations/' . (auth()->user()->organization && auth()->user()->organization->image ? auth()->user()->organization->image : 'no-organization.png')) }}">
                                @else
                                <x-profile-image class="w-40 h-40" id="dashboardProfileImage" :profile="auth()->user()->profile" />
                                @if(!auth()->user()->profile->image)
                                <a href="{{ route('dashboard.profileImage') }}" id="addImageLink" class="absolute top-0 left-0 w-40 h-40 flex flex-col justify-center text-center text-otblue font-semibold leading-tight">
                                    Add<br>Profile<br>Image
                                </a>
                                @endif
                                @endcan
                            </div>
                        </div>
                        <div class="px-6 mt-1 text-center text-xl font-medium leading-5">
                            {{ auth()->user()->name }}
                        </div>
                        @if(auth()->user()->organization)
                        <div class="text-center text-xs leading-5">of</div>
                        <div class="text-center text-sm font-medium leading-5 px-6">{{ auth()->user()->organization->name }}</div>
                        @endif
                    </div>
                    <a href="{{ route('dashboard') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-black' : '' }}">Dashboard</a>

                    @can('organization-admin')
                    <a href="{{ route('dashboard.organization.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.organization.*') ? 'bg-white text-black' : '' }}">My Organization</a>
                    @endcan

                    @canany(['customer', 'staff'])
                    <a href="{{ route('dashboard.trainings.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.trainings.*') ? 'bg-white text-black' : '' }}">My Advanced Training</a>
                    <a href="{{ route('dashboard.conferences.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.conferences.*') ? 'bg-white text-black' : '' }}">My Conference Training</a>
                    @endcanany

                    @can('vendor')
                    @if(auth()->user()->organization)
                    <a href="{{ route('dashboard.company.edit') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.company.*') ? 'bg-white text-black' : '' }}">My Company</a>
                    @endif
                    @endcan

                    @can('file-sharing')
                    <a href="{{ route('dashboard.upload-files.folders') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.upload-files.*') ? 'bg-white text-black' : '' }}">File Sharing</a>
                    @endcan

                    <a href="{{ route('dashboard.profile') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.profile') ? 'bg-white text-black' : '' }}">My Profile</a>
                    <a href="{{ route('dashboard.profileImage') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.profileImage') ? 'bg-white text-black' : '' }}">Profile Image</a>
                    <a href="{{ route('dashboard.changePassword') }}" class="block leading-tight py-2 px-4 font-medium {{ request()->routeIs('dashboard.changePassword') ? 'bg-white text-black' : '' }}">Change Password</a>


                    @canany(['staff','staff-instructor','conference-instructor'])
                    <div class="bg-otblue font-bold text-xl leading-tight py-4 px-4">Staff Menu</div>

                    @can('staff-instructor')
                    <a href="{{ route('dashboard.staff.trainings.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.staff.trainings.*', 'dashboard.staff.trainingCourses.*') ? 'bg-white text-black' : '' }}">Advanced Training<div class="text-xs">I'm teaching</div></a>
                    @endcan

                    @can('conference-instructor')
                    <a href="{{ route('dashboard.staff.conferences.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.staff.conferences.*', 'dashboard.staff.courses.*', 'dashboard.staff.course-attendees.*') ? 'bg-white text-black' : '' }}">Conferences<div class="text-xs">I'm teaching at</div></a>
                    @endcan

                    @can('expense-show')
                    <a href="{{ route('dashboard.staff.expenses.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.staff.expenses.*') ? 'bg-white text-black' : '' }}">Expenses</a>
                    @endcan


                    <a href="{{ route('dashboard.staff.staffDirectory') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.staff.staffDirectory') ? 'bg-white text-black' : '' }}">Staff Directory</a>
                    @can('staff')
                    {{-- <a href="{{ route('dashboard.staff.signature-generator') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('dashboard.staff.signature-generator') ? 'bg-white text-black' : '' }}">Signature Generator</a> --}}
                    @endcan

                    @can('conference-instructor')
                    {{-- <a href="{{ route('instructional-videos') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('instructional-videos') ? 'bg-white text-black' : '' }}">Instructional Videos</a> --}}
                    @foreach($activeConferences as $conference)
                    <a href="{{ route('conference.conference-instructor-information', $conference) }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ request()->routeIs('conference.conference-instructor-information') ? 'bg-white text-black' : '' }}">Conference Instructor Information</a>
                    @endforeach
                    @endcan

                    @endcanany
                </div>

                <div {{ $attributes->merge(['class' => 'lg:flex-1 bg-white p-4 sm:p-6']) }}>

                    {{ $slot }}


                </div>

            </div>
        </div>
    </div>
</x-site-layout>