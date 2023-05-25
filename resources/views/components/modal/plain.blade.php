@props(['xshow'])

<div x-show="{{ $xshow }}" style="display:none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div x-show="{{ $xshow }}" class="fixed inset-0 bg-black bg-opacity-30 transition-opacity" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center sm:items-center justify-center min-h-full p-4 text-center sm:p-0">

            <div x-show="{{ $xshow }}" @click.away="{{ $xshow }} = false" class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="max-h-[70vh] sm:max-h-96 overflow-y-auto p-2 m-4 border border-otgray-300 rounded">
                    {{ $slot }}
                </div>

                <div class="px-6 py-3 flex gap-3">
                    <div class="flex-1"></div>
                    <x-button @click.prevent="{{ $xshow }} = false">
                        Close
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>