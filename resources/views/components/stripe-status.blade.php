@props(['status'])

@if($status == 'active')
<div style="color:#006908; background-color:#d7f7c2;" class="rounded inline-block text-xs font-medium px-2 py-0.5">
    Active
</div>
@elseif($status == 'paid')
<div style="color:#006908; background-color:#d7f7c2;" class="rounded inline-block text-xs font-medium px-2 py-0.5">
    Paid
</div>
@elseif($status == 'open')
<div style="color:#0055bc; background-color:#cff5f6;" class="rounded inline-block text-xs font-medium px-2 py-0.5">
    Open
</div>
@elseif($status == 'past_due')
<div style="color:#b3093c; background-color:#ffe7f2;" class="rounded inline-block text-xs font-medium px-2 py-0.5 whitespace-nowrap">
    Past Due
</div>
@elseif($status == 'canceled')
<div style="color:#545969; background-color:#ebeef1;" class="rounded inline-block text-xs font-medium px-2 py-0.5">
    Canceled
</div>
@elseif($status == 'draft')
<div style="color:#545969; background-color:#ebeef1;" class="rounded inline-block text-xs font-medium px-2 py-0.5">
    Draft
</div>

@else
{{ $status }}
@endif