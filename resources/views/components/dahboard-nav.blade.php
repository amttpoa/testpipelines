@props(['selected' => 'dashboard'])

<div class="hidden lg:block w-52 bg-otgold text-white">
    <div class="bg-otblue">
        <div class="p-6 pb-0">
            <div class="relative">
                <img src="/storage/profile/{{ auth()->user()->profile->image ? auth()->user()->profile->image : 'no-image.png' }}" class="w-40 h-40 rounded-full">
                @if(!auth()->user()->profile->image)
                <a href="{{ route('dashboard.profileImage') }}" class="absolute top-0 left-0 w-40 h-40 flex flex-col justify-center text-center text-otblue font-semibold leading-tight">
                    Add<br>Profile<br>Image
                </a>
                @endif
            </div>

        </div>
        <div class="mt-1 text-center text-xl font-medium pb-6 border-b border-white leading-5">
            {{ auth()->user()->name }}
        </div>
    </div>
    <a href="{{ route('dashboard') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'dashboard' ? 'bg-white text-black' : '' }}">Dashboard</a>
    <a href="{{ route('dashboard.trainings.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'training' ? 'bg-white text-black' : '' }}">Advanced Training</a>
    <a href="{{ route('dashboard.conferences.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'conference' ? 'bg-white text-black' : '' }}">Conferences</a>
    <a href="{{ route('dashboard.profile') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'profile' ? 'bg-white text-black' : '' }}">My Profile</a>
    <a href="{{ route('dashboard.profileImage') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'profile-image' ? 'bg-white text-black' : '' }}">Profile Image</a>
    <a href="{{ route('dashboard.changePassword') }}" class="block leading-tight py-2 px-4 font-medium {{ $selected == 'change-password' ? 'bg-white text-black' : '' }}">Change Password</a>


    @hasanyrole('Staff|Staff Instructor|Conference Instructor')
    <div class="bg-otblue font-bold text-xl leading-tight py-4 px-4">Staff Menu</div>
    <a href="{{ route('dashboard.staff.staffDirectory') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'staff-directory' ? 'bg-white text-black' : '' }}">Staff Directory</a>
    @role('Staff Instructor')
    <a href="{{ route('dashboard.staff.trainings.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'staff-training-courses' ? 'bg-white text-black' : '' }}">Advanced Training</a>
    @endrole
    @role('Conference Instructor')
    <a href="{{ route('dashboard.staff.conferences.index') }}" class="block leading-tight py-2 px-4 border-b border-white font-medium {{ $selected == 'conferences' ? 'bg-white text-black' : '' }}">Conferences</a>
    @endrole
    @endhasanyrole
</div>