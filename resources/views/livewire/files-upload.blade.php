<form wire:submit.prevent="submit" enctype="multipart/form-data">

    <div>
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <div x-data="uploadHandler{{ $uploadNum ? $uploadNum : '' }}()" x-init="initStatus()" class="max-w-xl">

        <template x-for="(field, index) in fields" :key="index">
            <div class="flex items-center" :class="{ 'border-t border-cdblue-500' : index > 0 }">
                <div class="py-2 flex-1">
                    <a :href="field.fileLink" x-text="field.original_file" target="_blank" download :download="field.original_file"></a>
                </div>
                <div>
                    <i class="fa-solid fa-trash cursor-pointer text-cdblue hover:text-cdblue-500" @click="confirm('Are you sure you want to delete this upload?') ? $wire.delete(index,field.id) : false"></i>
                </div>
            </div>
        </template>

        <div class="mt-3" wire:livewire-upload-finish="submit" x-on:livewire-upload-finish="state='saving'" x-on:livewire-upload-start="state='loading'" x-on:livewire-upload-error="state='error'" x-on:livewire-upload-progress="progress = $event.detail.progress, progress2 = {width: $event.detail.progress}">

            <div :class="(dragOn ? 'bg-cdblue-200' : 'bg-cdblue-100 border-dashed')" class="relative rounded-lg border-2 border-cdblue-500">

                <div class="h-16 px-5 flex flex-col items-center justify-center">

                    <div class="flex items-center gap-3" x-show="state=='input'">
                        <x-icons.files class="w-6 h-6 text-cdblue" />
                        <span class="block text-cdblue font-normal">Drop files here or click to browse</span>
                    </div>

                    <div x-show="state=='loading'" class="h-3 w-full h-full bg-cdblue-200 max-w-xl rounded-full ">
                        <div id="bar" class="h-full bg-cdblue relative w-0 rounded-full" :style="`width: ${progress}%;`"></div>
                    </div>

                    <div x-show="state=='saving'" class="text-cdblue-500 font-light text-xl">
                        Saving
                    </div>

                </div>

                <input type="file" x-on:dragover="dragOn = true" x-on:dragleave="dragOn = false" x-on:drop="dragOn = false" class="top-0 absolute h-full w-full opacity-0 cursor-pointer" wire:model="files" name="" multiple />
            </div>

        </div>

    </div>

    <script type="text/javascript">
        function uploadHandler{{ $uploadNum ? $uploadNum : '' }}() {
            return {
                state: "input",
                progress: 0,
                dragOn: false,
                fields: [],
                initStatus() {                       
                    Livewire.on('gotcomment{{ $uploadNum ? $uploadNum : '' }}', (el, component) => { 
                        console.log(el);
                    });
                },                 
                removeField(index) {
                    console.log(this.fields);
                    console.log(this.fields[index].id);
                    // $wire.delete(this.fields[index].id);
                    // this.fields.splice(index, 1);
                },
            }
        }
        
        
    </script>

</form>