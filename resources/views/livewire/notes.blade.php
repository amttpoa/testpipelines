<div>
    <h2 class="text-2xl mb-2">Notes</h2>


    <form wire:submit.prevent="formSubmit" action="/" method="POST" class="w-full mb-2">
        @csrf

        @error('note')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
        <div class="flex gap-3 mt-2">
            <div class="flex-1">
                <x-input wire:model="note" name="note" type="text" maxlength="250" placeholder="Add Note" />
            </div>
            <div>
                <x-button>Add Note</x-button>
            </div>
        </div>

    </form>
    <div class="flex flex-col divide-y divide-otgray max-h-72 overflow-auto">

        @foreach($notes as $note)
        <div class=" {{ $loop->index % 2 ? 'bg-otgray-50' : '' }}">
            <div class="p-1.5">
                <div class="flex gap-3">
                    <div class="w-8">
                        <x-profile-image class="w-8 h-8" :profile="$note->user->profile" />
                    </div>
                    <div class="flex-1">
                        <div class="text-sm text-gray-400 leading-4">
                            <span>{{ $note->user->name }}</span> &bull;
                            <span>{{ $note->created_at->format('F jS Y h:i A') }} ({{ $note->created_at->diffForHumans() }})</span>

                        </div>
                        <div class="text-sm">{{ $note->note }}</div>
                    </div>
                    <div>
                        <i class="fa-solid fa-trash cursor-pointer text-otgray hover:text-otgray-500" onclick="confirm('Are you sure you want to delete this note?') || event.stopImmediatePropagation()" wire:click="delete({{ $note->id }})"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

</div>