{{-- @if (session()->has('organizations'))
@if (session()->get('organizations') != null) --}}
{{-- @if (count(session()->get('organizations')) > 1 ) --}}
@if (count(auth()->user()->allOrganizations()) > 1 )
<div x-data="{organization_id: {{session()->get('organization_id') }}}" class="mb-4">
    <div class="lg:flex lg:gap-2 lg:items-center text-sm">
        <div class="font-medium">Organization:</div>
        <div>
            <form method="POST" id="org-form" action="{{ route('dashboard.organization.change-organization') }}" @change="document.getElementById('org-form').submit()">
                @csrf
                <x-select class="text-sm" name="organization_id" x-model="organization_id" :selections="auth()->user()->allOrganizations()->pluck('name', 'id')" :selected="session()->get('organization_id')" />
            </form>
        </div>
    </div>
</div>
@endif
{{-- @endif
@endif --}}