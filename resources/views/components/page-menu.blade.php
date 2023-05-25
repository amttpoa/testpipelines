<div x-data="{ pageDropDownOpen: false }" class="relative">
    <button @click="pageDropDownOpen = !pageDropDownOpen" class="inline-flex items-center px-2 py-1 shadow-md bg-white border border-otgold rounded-md text-sm text-otgold hover:bg-white active:bg-white focus:outline-none focus:border-otgold focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
        <svg class="h-6 w-6 text-otgold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
        </svg>
    </button>

    <div x-show="pageDropDownOpen" @click="pageDropDownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

    <div x-show="pageDropDownOpen" style="display:none;" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-20">
        {{ $slot }}
    </div>
</div>