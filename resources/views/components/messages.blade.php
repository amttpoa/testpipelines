@if (\Session::has('success') and 1===2)
<div x-data="{ show: true }" x-show.transition.origin.top="show" x-transition.duration.500ms="transform scale-y-0 duration-1000" x-init="setTimeout(() => show = false, 3000)" class="px-6 py-4 mb-3 font-semibold text-green-600 border border-green-600 bg-green-100 shadow-md">
    {!! \Session::get('success') !!}
</div>
@endif

@if (\Session::has('success') and 1===2)
<div class="relative w-full">
    <div class="absolute left-0 right-0 w-96 mx-auto ">
        <div class="messageBox px-6 py-3 font-semibold text-green-600 border-b border-l border-r border-green-600 bg-green-100 shadow-md">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".messageBox").delay(3000).slideUp(400).fadeOut(300);
    });
</script>
@endif

@if (\Session::has('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="transform opacity-100" x-transition:leave-end="transform opacity-0 -translate-y-2" class="absolute left-1 right-1 md:left-1/3 md:right-1/3 top-2 px-6 py-2 font-semibold text-center text-green-600 border border-green-600 bg-green-100 shadow-md">
    {!! \Session::get('success') !!}
</div>
@endif

@if (\Session::has('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="transform opacity-100" x-transition:leave-end="transform opacity-0 -translate-y-2" class="absolute left-1 right-1 md:left-1/3 md:right-1/3 top-2 px-6 py-2 font-semibold text-center text-red-600 border border-red-600 bg-red-100 shadow-md">
    {!! \Session::get('error') !!}
</div>
@endif