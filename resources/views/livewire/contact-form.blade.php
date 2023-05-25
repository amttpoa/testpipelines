<div class="p-6 bg-otblue rounded-xl">
    <div class="mb-4 text-white text-3xl font-bold text-center leading-none">Contact Our<br>Executive Director</div>

    @if ($success)
    <div class="text-white">
        Your message has been sent to the Exective Director of the Ohio Tactical Officers Association. You will get a response soon.
    </div>
    @else
    <div class="mb-4 text-white text-center font-medium">Please fill out the form below to reach out to Pat Fiorilli, our Executive Director.</div>
    <div class="">
        <div class="">
            <form wire:submit.prevent="contactFormSubmit" action="/contact" method="POST" class="w-full">
                @csrf
                <div class="mb-3">
                    @error('name')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <x-input wire:model="name" class="" type="text" placeholder="Name" name="name" value="{{ old('name') }}" />
                </div>
                <div class="mb-3">
                    @error('email')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <x-input wire:model="email" class="" type="text" placeholder="Email Address" name="email" value="{{ old('email') }}" />
                </div>
                <div class="mb-3">
                    @error('subject')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <x-input wire:model="subject" class="" type="text" placeholder="Subject" name="subject" value="{{ old('subject') }}" />
                </div>
                <div class="mb-3">
                    @error('message')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <x-textarea wire:model="message" rows="5" class="" name="message" placeholder="Your message here...">{{ old('message') }}</x-textarea>
                </div>
                <div>
                    <x-button class="w-full justify-center font-semibold text-xl">Submit</x-button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>