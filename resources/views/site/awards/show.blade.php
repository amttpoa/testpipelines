<x-site-layout>
    @section("pageTitle")
    {{ $award->name }}
    @endSection

    <x-banner bg="/img/conventions12.jpg">
        <div class="text-3xl lg:text-6xl"><a href="{{ route('awards.index') }}">Awards</a></div>
        <div class="text-xl lg:text-2xl">{{ $award->name }}</div>
    </x-banner>

    <div class="bg-otsteel">
        <div class="max-w-4xl p-6 bg-white mx-auto">

            <div class="mb-10">
                <div class="font-medium text-3xl">{{ $award->name }}</div>
                <div class="mb-5 text-otgray text-sm">Sponsored by <span class="font-medium">{{ $award->sponsor_name }}</span></div>

                <div class="sm:float-right sm:ml-6 mb-6 text-center">
                    <div>
                        <img class="w-60 h-60 object-contain inline" src="/img/awards/{{ $award->image }}" />
                    </div>
                    <div class="mt-4">Sponsored By</div>
                    <a href="{{ $award->sponsor_website }}" target="_blank">
                        <div>
                            <img class="w-60 inline" src="/img/awards/{{ $award->sponsor_image }}" />
                        </div>
                        <div class="font-medium text-xl">{{ $award->sponsor_name }}</div>
                        <div class="font-medium text-otgold">Visit Website</div>
                    </a>
                </div>
                <div>
                    <div class="text-lg prose max-w-full">{!! $award->description !!}</div>
                </div>
            </div>
            <div class="clear-both"></div>

            <form method="POST" id="main-form" action="{{ route('awards.store', $award) }}" enctype="multipart/form-data">
                @csrf

                <div class="font-medium text-2xl mb-2">Nominee Information</div>
                <div class="sm:grid sm:gap-4 sm:grid-cols-2">
                    <div>
                        <x-label for="name_candidate" id="name_candidate">Name</x-label>
                        <x-input name="name_candidate" x-model="name_candidate" class="mb-4" required />
                    </div>
                    <div>
                        <x-label for="agency_candidate" id="agency_candidate">Agency</x-label>
                        <x-input name="agency_candidate" x-model="agency_candidate" class="mb-4" required />
                    </div>
                </div>
                <div class="sm:grid sm:gap-4 sm:grid-cols-2">
                    <div>
                        <x-label for="image">Photo of Nominated Person(s)</x-label>
                        <div class="text-xs mb-1">Please submit a photo of the candidate suitable for publication. In uniform is preferable.</div>
                        <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg" />
                    </div>
                    <div>
                        <x-label for="logo">Agency Logo or Badge</x-label>
                        <div class="text-xs mb-1">Please provide an agency logo or badge of the candidate's organization in the highest resolution possible.</div>
                        <input id="logo" name="logo" type="file" accept="image/png, image/gif, image/jpeg" />
                    </div>
                </div>

                <div class="font-medium text-2xl mb-2 mt-8">Event Information</div>
                <div>
                    <x-label for="story" id="story">Enter a narrative detailing the facts supporting this award</x-label>
                    <x-textarea name="story" x-model="story" class="mb-4" rows="5" required></x-textarea>
                </div>
                <div>
                    <x-label for="video" id="video">Is there a video available?</x-label>
                    <div class="text-xs mb-1">Please let us know where we can find a video of the incident or you can <x-a href="https://8675309.wetransfer.com/" target="_blank">upload</x-a> one to our WeTransfer account.</div>
                    <x-input name="video" x-model="video" class="mb-4" required />
                </div>
                <div class="font-medium">
                    Video can be uploaded to the <x-a href="https://8675309.wetransfer.com/" target="_blank">OTOA WeTransfer site</x-a>.
                </div>

                <div class="font-medium text-2xl mb-2 mt-8">Your Information <span class="text-xs font-normal">(or person submitting nomination)</span></div>
                <div class="sm:grid sm:gap-4 sm:grid-cols-2">
                    <div>
                        <x-label for="name_submitter" id="name_submitter">Name </x-label>
                        <x-input name="name_submitter" x-model="name_submitter" class="mb-4" required />
                    </div>
                    <div>
                        <x-label for="agency_submitter" id="agency_submitter">Agency</x-label>
                        <x-input name="agency_submitter" x-model="agency_submitter" class="mb-4" required />
                    </div>
                </div>
                <div class="sm:grid sm:gap-4 sm:grid-cols-2">
                    <div>
                        <x-label for="email_submitter" id="email_submitter">Email</x-label>
                        <x-input name="email_submitter" x-model="email_submitter" class="mb-4" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="phone_submitter">Phone</x-label>
                        <x-input x-data="{}" x-mask="(999) 999-9999" placeholder="(216) 555-1212" type="tel" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" id="phone_submitter" name="phone_submitter" required />
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button :disabled="!buttonActive" class="inline-flex items-center px-6 py-2.5 shadow-md bg-otgold border border-otgold text-2xl text-white hover:bg-otgold-500 active:bg-otgold-600 focus:outline-none focus:ring-none disabled:opacity-25 transition ease-in-out duration-150'">
                        Submit Nomination
                    </button>
                </div>
            </form>

        </div>
    </div>


    <script type="text/javascript">
        function formHandler() {
            return {
                buttonActive: true,
            }
        }
    </script>


</x-site-layout>