<x-dashboard.layout>
    @section("pageTitle")
    Profile Image
    @endSection

    <x-breadcrumbs.holder>
        Profile Image
    </x-breadcrumbs.holder>

    <div x-data="handler()" class="mx-auto">
        <label class="inline-flex items-center gap-4 cursor-pointer mx-auto" title=" Change your avatar">
            <x-profile-image class="w-40 h-40 lg:w-60 lg:h-60" id="profileImage" :profile="$profile" />
            <div>
                <div class="text-2xl font-bold text-otgold">Choose a new image</div>
                <div>After selecting a new image you will be asked to crop your image into a square.</div>
            </div>
            <input type="file" class="sr-only" id="originalImage" name="originalImage" accept="image/*" x-on:change.debounce="setPopup()">
        </label>

        <!-- Dialog (full screen) -->
        <div class="fixed z-20 top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);display:none;" x-show="popup">

            <div class="h-auto max-h-max p-4 mx-2 text-left bg-white rounded shadow-xl w-full md:max-w-3xl md:p-6 lg:p-8 md:mx-0" @click.away="killPopup()">
                <div class="h-96 img-container">
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
                        $.ajax('{{ route('dashboard.profileImageUpload') }}', {
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success(data) {
                                console.log('Upload success');
                                console.log(data);
                                $('#profileImage').attr('src', data.newFile);
                                $('#dashboardProfileImage').attr('src', data.newFile);        
                                $('#addImageLink').hide();
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

</x-dashboard.layout>