@props(['user'])

@if(!empty($user->getRoleNames()))
@foreach($user->getRoleNames() as $v)
@php
$classes = 'bg-otgold text-white';
if($v == 'Admin') {$classes = 'bg-otblue text-white';}
if($v == 'Super Admin') {$classes = 'bg-black text-white';}
if($v == 'Hotel Coordinator') {$classes = 'bg-otblue text-white';}
if($v == 'Live Fire Coordinator') {$classes = 'bg-otblue text-white';}
if($v == 'Awards Coordinator') {$classes = 'bg-otblue text-white';}
if($v == 'Vendor Management') {$classes = 'bg-otblue text-white';}
if($v == 'Board of Directors') {$classes = 'bg-otblue text-white';}

if($v == 'Organization Admin') {$classes = 'bg-otsteel text-white';}
if($v == 'Staff') {$classes = 'bg-red-800 text-white';}
if($v == 'Conference Instructor') {$classes = 'bg-red-800 text-white';}
if($v == 'Staff Instructor') {$classes = 'bg-red-800 text-white';}
if($v == 'Vendor') {$classes = 'bg-green-800 text-white';}
if($v == 'VIP') {$classes = 'bg-otblue-400 text-white';}
if($v == 'Medic') {$classes = 'bg-pink-400 text-white';}
@endphp
<div class="px-3 inline-block text-sm rounded-full {{ $classes }}">{{ $v }}</div>
@endforeach
@endif