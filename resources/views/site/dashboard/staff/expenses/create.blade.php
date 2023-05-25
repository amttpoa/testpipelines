<x-dashboard.layout>
    @section("pageTitle")
    Submit Expense
    @endSection

    <x-breadcrumbs.holder>
        <a class="text-black" href="{{ route('dashboard.staff.expenses.index') }}">Expenses</a>
        <x-breadcrumbs.arrow />
        Submit Expense
    </x-breadcrumbs.holder>


    <form x-data="formHandler()" x-init="addItem()" method="POST" id="main-form" action="{{ route('dashboard.staff.expenses.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="md:flex md:gap-3">

            <div class="mb-4 min-w-[50%]">
                <x-label>What is this expense for?</x-label>
                <x-input name="title" required />
            </div>
            <div class="mb-4">
                <x-label>Date</x-label>
                <x-input name="date" type="date" required />
            </div>
            <div class="mb-4 flex-1">
                <x-label>Location</x-label>
                <x-input name="location" />
            </div>


        </div>

        <div class="flex gap-3">
            <div class="mb-4">
                <x-fields.select xmodel="payer" name="payer" label="Who Paid" :selections="Config::get('site.expense_payer')" placeholder=" " required="true" />
            </div>
            <div class="mb-4" x-show="payer == 'OTOA Paid'" style="display:none;">
                <x-label>Last 4 digits of OTOA credit card used</x-label>
                <x-input name="card" />
            </div>
        </div>

        {{-- <div class="mb-4">
            <x-label>How much?</x-label>
            <div class="dollar">
                <x-input name="total" type="number" step='0.01' required />
            </div>
        </div> --}}

        <div class="text-sm mb-1">
            Please enter each item/receipt for this expense.
            Click the <strong>Add Additional Item/Receipt</strong> button to add multiple items or receipts.
            Item/Receipt examples include: Gas, Rental, Home Depot, Costco, Etc.
        </div>
        <div class="flex gap-3">
            <div class="w-1/3">
                <x-label>Item/Receipt</x-label>
            </div>
            <div class="w-40">
                <x-label>Amount</x-label>
            </div>
            <div class="flex-1">
                <x-label>Comments</x-label>
            </div>
        </div>
        <template x-for="(item, index) in items" :key="index">
            <div class="flex gap-3 mb-2">
                <div class="w-1/3">
                    <x-input name="item_name[]" />
                </div>
                <div class="w-40">
                    <div class="dollar">
                        <x-input name="item_price[]" type="number" step='0.01' />
                    </div>
                </div>
                <div class="flex-1">
                    <x-input name="item_comments[]" />
                </div>
            </div>
        </template>

        <div class="mb-4">
            <x-button-site type="light" @click.prevent="addItem();">Add Additional Item/Receipt</x-button-site>
        </div>

        <div class="mb-4">
            <x-label for="comments">Comments</x-label>
            <div class="text-sm">
                Please provide pertinent details for this expense (persons present for meals, itemized reason for expense(s), etc)
            </div>
            <x-textarea class="" rows="5" name="comments"></x-textarea>
        </div>

        <x-label>File(s)</x-label>
        <input type="file" name="files[]" multiple />

        <div class="mt-4">
            <x-button-site form="main-form">Submit Expense</x-button-site>
        </div>
    </form>

    <script type="text/javascript">
        function formHandler() {
            return {
                items: [],
                payer: null,
                addItem() {
                    console.log('adding item');
                    this.items.push({
                        
                    });
                },
            }
        }
    </script>

</x-dashboard.layout>