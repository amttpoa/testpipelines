<x-dashboard.layout>
    @section("pageTitle")
    Signature Generator
    @endSection

    <x-breadcrumbs.holder>
        Signature Generator
    </x-breadcrumbs.holder>

    <x-label>Name</x-label>
    <x-input id="field1" name="field1" class="mb-4" value="{{ strtoupper(auth()->user()->name) }}" />
    <x-label>Title</x-label>
    <x-input id="field2" name="field2" class="mb-4" value="{{ auth()->user()->profile->title }}" />
    <x-label>Company</x-label>
    <x-input id="field3" name="field3" class="mb-4" value="{{ auth()->user()->organization->name }}" />
    <x-label>Address Line 1</x-label>
    <x-input id="field4" name="field4" class="mb-4" value="17000 St. Clair Avenue, Suite 108" />
    <x-label>Address Line 2</x-label>
    <x-input id="field5" name="field5" class="mb-4" value="Cleveland, Ohio 44110" />
    <x-label>Phone</x-label>
    <x-input id="field6" name="field6" class="mb-4" value="{{ auth()->user()->profile->phone }}" />

    <iframe id="theframe" src="{{ route('dashboard.staff.signature-generator-frame') }}" class="w-full h-72">
    </iframe>


    <script type="text/javascript">
        $(document).ready(function() {
			$("#field1").keyup(function() {
				// $(".sig1").html($("#field1").val());
                $('#theframe').contents().find('.sig1').html($("#field1").val());
			});	
			$("#field2").keyup(function() {
                $('#theframe').contents().find('.sig2').html($("#field2").val());
			});	
			$("#field3").keyup(function() {
                $('#theframe').contents().find('.sig3').html($("#field3").val());
			});	
			$("#field4").keyup(function() {
                $('#theframe').contents().find('.sig4').html($("#field4").val());
			});	
			$("#field5").keyup(function() {
                $('#theframe').contents().find('.sig5').html($("#field5").val());
			});	
			$("#field6").keyup(function() {
                $('#theframe').contents().find('.sig6').html($("#field6").val());
			});	
		});

    </script>


</x-dashboard.layout>