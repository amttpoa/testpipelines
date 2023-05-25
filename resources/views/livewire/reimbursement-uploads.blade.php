<div class="max-w-xl">
    <div>
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>

    @if($uploads->isEmpty())
    <div class="font-medium text-red-600">Please upload images of your receipts</div>
    @endif
    @foreach($uploads as $upload)
    <div class="flex gap-3 p-2 items-center rounded-lg border border-otgray mb-2">
        <div class="flex-1">
            <a href="{{ Storage::disk('s3')->url('reimbursements/' . $upload->file_name) }}" target="_blank" download>
                <div class="">
                    {{ $upload->file_original }}
                </div>
                <div class="text-xs text-otgray">
                    {{ $upload->user ? $upload->user->name : 'Missing user ' . $upload->user_id }} on {{ $upload->created_at->format('m/d/Y H:i') }}
                </div>
            </a>
        </div>
        <div>
            <i class="fa-solid fa-trash cursor-pointer text-otgray hover:text-otgray-500" onclick="confirm('Are you sure you want to delete this upload?') || event.stopImmediatePropagation()" wire:click="delete({{ $upload->id }})"></i>
        </div>
    </div>
    @endforeach

    <form wire:submit.prevent="submit" enctype="multipart/form-data" x-data="{state: 'input', progress: 0, dragOn: false}">
        <div class="" wire:livewire-upload-finish="submit" x-on:livewire-upload-finish="state='input'" x-on:livewire-upload-start="state='loading'" x-on:livewire-upload-error="state='error'" x-on:livewire-upload-progress="progress = $event.detail.progress, progress2 = {width: $event.detail.progress}">

            <div :class="(dragOn ? 'relative rounded-lg border-2 border-otgray-500 bg-otgray-200' : 'relative rounded-lg border-2 border-otgray-500 bg-otgray-50 border-dashed')" class="">

                <div class="h-16 px-5 flex flex-col items-center justify-center">

                    <div class="flex items-center gap-3" x-show="state=='input'">
                        <x-icons.files class="w-6 h-6 text-otgray" />
                        <span class="block text-otgray font-normal">Drop files here or click to browse</span>
                    </div>

                    <div x-show="state=='loading'" class="h-3 w-full h-full bg-otgray-200 max-w-xl rounded-full ">
                        <div id="bar" class="h-full bg-otgray relative w-0 rounded-full" :style="`width: ${progress}%;`"></div>
                    </div>

                    <div x-show="state=='saving'" class="text-otgray-500 font-light text-xl">
                        Saving
                    </div>

                </div>

                <input type="file" x-on:dragover="dragOn = true" x-on:dragleave="dragOn = false" x-on:drop="dragOn = false" class="top-0 absolute h-full w-full opacity-0 cursor-pointer" wire:model="files" name="" multiple />
            </div>

        </div>
    </form>

</div>