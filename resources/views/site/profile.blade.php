<x-site-layout>

    <div class="h-48 bg-black bg-cover bg-center" style="background-image:url(/img/otoabanner-35thanniversary-protect-and-serve.jpg);">
        <div class="h-full" style="background-color: rgba(0,0,0,.7);">
            <div class="h-full flex flex-col justify-center max-w-7xl mx-auto">
                <div class="text-otgold font-blender text-6xl font-bold text-center">
                    Profile
                </div>
            </div>
        </div>
    </div>


    <div class="" x-data="{ tab: (localStorage.getItem('profile_tab') ? localStorage.getItem('profile_tab') : 'general') }">

        <div class="bg-otsteel">
            <div class="flex flex-wrap justify-items-center bg-otsteel text-center max-w-lg mx-auto">
                <div class="border-x border-white">
                    <x-tab-click item="profile_tab" tab="general">
                        <span class="text-xl font-medium">General Information</span>
                    </x-tab-click>
                </div>
                <div class="border-r border-white">
                    <x-tab-click item="profile_tab" tab="image">
                        <span class="text-xl font-medium">Image</span>
                    </x-tab-click>
                </div>
                <div class="border-r border-white">
                    <x-tab-click item="profile_tab" tab="password">
                        <span class="text-xl font-medium">Change Password</span>
                    </x-tab-click>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <form method="POST" id="main-form" enctype="multipart/form-data" action="{{ route('dashboard.profilePatch') }}">
                @csrf
                @method('PATCH')

                <x-tab-card tab="general">

                    <x-fields.input-text label="Title" name="title" value="{!! $profile->title !!}" class="mb-3" />


                    <div class="flex gap-3">
                        <div class="mb-3">
                            <x-label for="phone">Phone</x-label>
                            <x-input x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" value="{{ $profile->phone }}" id="phone" name="phone" required />
                        </div>
                        <x-fields.input-text label="Birthday" name="birthday" type="date" value="{{ $profile->birthday->format('Y-m-d') }}" class="mb-3" />
                    </div>

                    <x-fields.input-text label="Address" name="address" value="{{ $profile->address }}" class="mb-3" />


                    <div class="flex gap-3 flex-wrap md:flex-nowrap">

                        <x-fields.input-text label="City" name="city" value="{{ $profile->city }}" class="md:mb-3 md:flex-1 w-full md:w-auto" />
                        <x-fields.input-text label="State" name="state" value="{{ $profile->state }}" class="mb-3 flex-1 md:w-32" />
                        <x-fields.input-text label="Zip" name="zip" value="{{ $profile->zip }}" class="mb-3 flex-1 md:w-32" />

                    </div>

                    <div class="">
                        <x-label for="bio">Bio</x-label>
                        <x-textarea rows="5" class="addTiny" name="bio">{{ $profile->bio }}</x-textarea>
                    </div>


                    <div class="mt-6">
                        <x-button form="main-form">Update General Information</x-button>
                    </div>

                </x-tab-card>

            </form>


            <x-tab-card tab="image">


                <div x-data="handler()" class="mx-auto">
                    <label class="inline-flex items-center gap-4 cursor-pointer mx-auto" title=" Change your avatar">
                        <img class="rounded-full w-40 h-40 lg:w-60 lg:h-60" id="profileImage" src="/storage/profile/{{ $profile->image ? $profile->image : 'no-image.png' }}" alt="avatar">
                        <div class="text-2xl font-bold text-cdblue">Choose new image</div>
                        <input type="file" class="sr-only" id="originalImage" name="originalImage" accept="image/*" x-on:change.debounce="setPopup()">
                    </label>

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
                                    formData.append('_token', $("meta[name='csrf-token']").attr("content"));
                                    console.log(JSON.stringify(formData));
            
                                    for (var value of formData.values()) {
                                    console.log(value);
                                    }
                                    // Use `jQuery.ajax` method for example
                                    console.log(formData);
                                    $.ajax('{{ route('profileImageUpload') }}', {
                                        method: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success(data) {
                                            console.log('Upload success');
                                            console.log(data);
                                            $('#profileImage').attr('src', '/storage/profile/' + data.newfileName)
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


            </x-tab-card>



            <x-tab-card tab="password">

                <h2 class="text-2xl mb-4">Change Password</h2>

                <div class="mb-3 w-60">
                    <x-label for="password">Current Password</x-label>
                    <x-input id="password" name="password" type="password" />
                </div>

                <div class="mb-3 w-60">
                    <x-label for="passwordNew">New Password</x-label>
                    <x-input id="passwordNew" name="passwordNew" type="password" />
                </div>

                <div class="mb-3 w-60">
                    <x-label for="passwordNewConfirm">Confirm New Password</x-label>
                    <x-input id="passwordNewConfirm" name="passwordNewConfirm" type="password" />
                </div>

            </x-tab-card>

        </div>


    </div>

</x-site-layout>