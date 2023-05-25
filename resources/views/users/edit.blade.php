<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.users.index') }}">Users</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</x-crumbs.a>
            Edit User
        </x-crumbs.holder>
        <x-page-menu>
            <a href="{{ route('admin.users.show', $user) }}" class="block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">View User</a>
            <form method="POST" action="{{ route('admin.users.destroy',  $user) }}">
                @csrf
                @method('DELETE')
                <button class="w-full text-left bg-white cursor-pointer block px-4 py-2 text-sm text-gray-800 border-b hover:bg-gray-200">Delete</button>
            </form>
        </x-page-menu>
        <div>
            <x-button form="main-form">Save</x-button>
        </div>
    </x-crumbs.bar>

    <x-cards.main>

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" id="main-form" enctype="multipart/form-data" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-fields.input-text label="Name" name="name" class="mb-3" value="{!! $user->name !!}" />
                    <x-fields.input-text label="Email" name="email" class="mb-3" value="{{ $user->email }}" />

                    <div class="grid grid-cols-2 gap-3">
                        <x-fields.input-text label="Password" name="password" type="password" class="mb-3" />
                        <x-fields.input-text label="Confirm Password" name="confirm-password" type="password" class="mb-3" />
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="mb-3">
                            <x-label for="phone">Phone</x-label>
                            <x-input x-data="{}" x-mask="(999) 999-9999" value="{{ $user->profile->phone }}" placeholder="(216) 555-1212" id="phone" name="phone" />
                        </div>
                        <x-fields.input-text label="Title" name="title" value="{!! $user->profile->title !!}" class="mb-3" />
                        <x-fields.input-text label="Birthday" name="birthday" type="date" value="{{ $user->profile->birthday ? $user->profile->birthday->format('Y-m-d') : '' }}" class="mb-3" />
                    </div>
                </div>

                <div>
                    <div class="font-medium text-2xl">Organization</div>

                    @if($user->organization)
                    <x-a href="{{ route('admin.organizations.show', $user->organization) }}">{{ $user->organization->name }}</x-a>
                    @else
                    <div>
                        No organization connected.
                        @if($user->profile->organization_name)
                        <span class="font-medium">{{ $user->profile->organization_name }}</span> was entered at registration.
                        @endif
                    </div>
                    @if($user->profile->organization_name)
                    <x-a href="{{ route('admin.organizations.create', ['name' => $user->profile->organization_name]) }}">Add {{ $user->profile->organization_name }} as an organization</x-a>
                    @endif
                    @endif

                    <div class="mt-2">
                        @livewire('organization-autocomplete', ['organization_id' => $user->organization ? $user->organization_id : '', 'organization_name' => $user->organization ? $user->organization->name : ''] )
                    </div>
                    <div class="mt-2">
                        @livewire('organization-autocomplete', ['ext' => 's[]', 'organization_id' => $user->organizations->count() > 0 ? $user->organizations[0]->id : '', 'organization_name' => $user->organizations->count() > 0 ? $user->organizations[0]->name : ''] )
                    </div>
                    <div class="mt-2">
                        @livewire('organization-autocomplete', ['ext' => 's[]', 'organization_id' => $user->organizations->count() > 1 ? $user->organizations[1]->id : '', 'organization_name' => $user->organizations->count() > 1 ? $user->organizations[1]->name : ''] )
                    </div>
                </div>
            </div>


            <x-fields.input-text label="Address" name="address" value="{{ $user->profile->address }}" class="mb-4" />

            <div class="grid grid-cols-4 gap-3">
                <x-fields.input-text label="City" name="city" value="{{ $user->profile->city }}" class="mb-4 col-span-2" />
                <x-fields.input-text label="State" name="state" value="{{ $user->profile->state }}" class="mb-4" />
                <x-fields.input-text label="Zip" name="zip" value="{{ $user->profile->zip }}" class="mb-4" />
            </div>

            <div class="mb-4">
                <x-label for="bio">Bio</x-label>
                <x-textarea rows="5" class="addTiny" name="bio">{{ $user->profile->bio }}</x-textarea>
            </div>

            <div class="mb-2">
                <x-label for="roles[]">Roles</x-label>
                <div class="columns-3 inline-block">
                    @foreach($roles as $key => $role)
                    <label class="flex gap-3 items-center mb-3">
                        <input type="checkbox" name="roles[]" value="{{ $key }}" {{ in_array($role, $userRole) ? 'checked' : '' }} />
                        {{ $role }}
                    </label>
                    @endforeach
                </div>
            </div>

        </form>



        <div>

            <h2 class="text-2xl mb-4">Profile Image</h2>

            <div x-data="handler()" class="mx-auto">
                <label class="relative flex items-center gap-4 cursor-pointer mx-auto">
                    <x-profile-image class="w-40 h-40 lg:w-60 lg:h-60" id="profileImage" :profile="$user->profile" />
                    <div>
                        <div class="text-2xl font-bold text-otgold">Choose new image</div>
                        <div>After selecting a new image you will be asked to crop your image into a square.</div>

                    </div>
                    <input type="file" class="sr-only" id="originalImage" name="originalImage" accept="image/*" x-on:change.debounce="setPopup()" />
                </label>

                @if($user->profile->image)
                <div class="mt-4">
                    <label class="flex gap-2 items-center">
                        <input type="checkbox" name="delete_image" value="delete" form="main-form" />
                        Check here to delete user image
                    </label>
                </div>
                @endif

                <!-- Dialog (full screen) -->
                <div class="fixed z-20 top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);display:none;" x-show="popup">

                    <div class="h-auto max-h-max p-4 mx-2 text-left bg-white rounded shadow-xl w-full md:max-w-3xl md:p-6 lg:p-8 md:mx-0" @click.away="killPopup()">
                        <div class="img-container">
                            <img id="popupImage" class="h-96 max-h-full" src="">
                        </div>
                        <div class="text-right mt-4">
                            <x-button type="button" @click="killPopup()">Cancel</x-button>
                            <x-button type="button" id="popupCrop" @click="popupCrop()">Crop</x-button>
                        </div>

                    </div>
                </div>

            </div>

            <script type="text/javascript">
                function handler() {
                        var cropper;
                        var originalFileName;
            
                        return {
                            fields: [],
                            popup: false,
                            killPopup() {
                                cropper.destroy();
                                cropper = null;
                                originalFileName = null;
                                this.popup = false;
                                document.getElementById("originalImage").value = "";
            
                            },
                            setPopup() {
                                this.popup = true;
                                var files = $("#originalImage")[0].files;
                                var image = $("#popupImage")[0];
                                // var image = document.getElementById('popupImage');
                                console.log(files);
                                console.log(files[0].name);
                                var done = function (url) {
                                    // input.value = '';
                                    image.src = url;
                                    // $alert.hide();
                                    // $modal.show();
                                };
                                var reader;
                                var file;
                                var url;
                        
                                if (files && files.length > 0) {
                                    file = files[0];
                                    originalFileName = file.name;
                            
                                    if (URL) {
                                        done(URL.createObjectURL(file));
                                    } else if (FileReader) {
                                        reader = new FileReader();
                                        reader.onload = function (e) {
                                        done(reader.result);
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                }
                                console.log(originalFileName);
                                console.log(image);
                                cropper = new Cropper(image, {
                                    aspectRatio: 1,
                                    viewMode: 2,
                                });
            
                            },
                            popupCrop() {
                                var files = $("#originalImage")[0].files;
                                console.log(files);
                                console.log(files[0].name);
                                console.log('cropping');
            
                                console.log(originalFileName);
                                // result.innerHTML = '';
                                // result.appendChild(cropper.getCroppedCanvas({
                                //     maxHeight: 1000,
                                //     maxWidth: 1000
                                // }));
            
            
                                var canvas;
                                canvas = cropper.getCroppedCanvas({
                                    height: 500,
                                    width: 500
                                });
            
                                canvas.toBlob(function (blob) {
                                    var files = $("#originalImage")[0].files;
                                    console.log(files);
                                    console.log(files[0].name);
                                    console.log('to blob');
                                    // console.log(filename);
                                    var formData = new FormData();
            
                                    // Pass the image file name as the third parameter if necessary.
                                    formData.append('image', blob, files[0].name);
                                    formData.append('user_id', {{ $user->id }});
                                    formData.append('_token', $("meta[name='csrf-token']").attr("content"));
                                    console.log(JSON.stringify(formData));
            
                                    for (var value of formData.values()) {
                                    console.log(value);
                                    }
                                    // Use `jQuery.ajax` method for example
                                    console.log(formData);
                                    $.ajax('{{ route('dashboard.profileImageUpload') }}', {
                                        method: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success(data) {
                                            console.log('Upload success');
                                            console.log(data);
                                            $('#profileImage').attr('src', data.newFile)
                                        },
                                        error(xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(xhr.responseText);
                                        },
                                        complete(){
                                            console.log('destroying');
                                            cropper.destroy();
                                            cropper = null;
                                            originalFileName = null;
                                            document.getElementById("originalImage").value = "";
                                            console.log('destroyed');
                                        }
                                    });
            
                                });
                                
                                this.popup = false;
            
            
                            },
                        }
                    }                    
            </script>


        </div>

    </x-cards.main>

    <div class="mt-6 ml-6">
        <x-button form="main-form">Save</x-button>
    </div>

</x-app-layout>