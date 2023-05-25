<x-app-layout>

    <x-crumbs.bar>
        <x-crumbs.holder>
            <x-crumbs.a href="{{ route('admin.conferences.index') }}">Conferences</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.conferences.show', $conference) }}">{{ $conference->name }}</x-crumbs.a>
            <x-crumbs.a href="{{ route('admin.reimbursements.index', $conference) }}">Reimbursements</x-crumbs.a>
            {{ $reimbursement->user->name }}
        </x-crumbs.holder>
    </x-crumbs.bar>

    <div class="xl:flex xl:gap-6">
        <div class="xl:flex-1">
            <x-cards.user class="mb-6" :user="$reimbursement->user" />

            <x-cards.main class="mb-6">
                <div class="mb-4 text-xl">
                    Status: <span class="font-medium">{{ $reimbursement->status }}</span>
                </div>

                <div class="text-xl">{{$reimbursement->name }}</div>
                <div>{{$reimbursement->address }}</div>
                <div>{{$reimbursement->city }}{{$reimbursement->city ? "," : '' }} {{$reimbursement->state }} {{$reimbursement->zip }}</div>
                <div>{{$reimbursement->comments }}</div>


                <div class="text-2xl font-medium mt-4">Meals</div>

                @php
                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                @endphp

                <table class="">
                    <tr class="font-medium">
                        <td></td>
                        <td class="text-right pl-8">Breakfast</td>
                        <td class="text-right pl-8">Lunch</td>
                        <td class="text-right pl-8">Dinner</td>
                    </tr>

                    @foreach($days as $key => $day)
                    <tr>
                        <td>{{ $day }}</td>
                        <td class="text-right pl-8">{{ $reimbursement->reimbursementMeals->where('day', $key + 1)->where('meal', 1)->first() ? '$' . number_format($reimbursement->reimbursementMeals->where('day', $key + 1)->where('meal', 1)->first()->price, 2) : '' }}</td>
                        <td class="text-right pl-8">{{ $reimbursement->reimbursementMeals->where('day', $key + 1)->where('meal', 2)->first() ? '$' . number_format($reimbursement->reimbursementMeals->where('day', $key + 1)->where('meal', 2)->first()->price, 2) : '' }}</td>
                        <td class="text-right pl-8">{{ $reimbursement->reimbursementMeals->where('day', $key + 1)->where('meal', 3)->first() ? '$' . number_format($reimbursement->reimbursementMeals->where('day', $key + 1)->where('meal', 3)->first()->price, 2) : '' }}</td>
                    </tr>
                    @endforeach
                </table>
                <div class="text-xl mt-2">
                    Meals Total: <span class="font-medium">${{ number_format($reimbursement->total_meals, 2) }}</span>
                </div>


                <div class="text-2xl font-medium mt-4">Items</div>
                <table class="">
                    <tr class="font-medium">
                        <td></td>
                    </tr>

                    @foreach($reimbursement->reimbursementItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-right pl-8">{{ $item->price ? '$' . number_format($item->price, 2) : '' }}</td>
                        <td class="pl-8">{{ $item->comments }}</td>
                    </tr>
                    @endforeach
                </table>
                <div class="text-xl mt-2">
                    Items Total: <span class="font-medium">${{ number_format($reimbursement->total_items, 2) }}</span>
                </div>

                <div class="text-2xl mt-2">
                    Total: <span class="font-medium">${{ number_format($reimbursement->total, 2) }}</span>
                </div>

                <div class="text-2xl mt-2">
                    {{ $reimbursement->on_duty ? 'On duty' : '' }}
                    {{ $reimbursement->on_duty === 0 ? 'Off duty' : '' }}
                </div>

                <div class="text-2xl font-medium mt-4">Uploads</div>
                <div>
                    @foreach($reimbursement->reimbursementUploads as $upload)
                    <div>
                        <x-a href="{{ Storage::disk('s3')->url('reimbursements/' . $upload->file_name) }}" target="_blank">{{ $upload->file_original }}</x-a>
                    </div>
                    @endforeach
                </div>

            </x-cards.main>
        </div>

        <div class="xl:w-1/3">
            <x-cards.main class="mb-6">

                <form method="POST" id="main-form" action="{{ route('admin.reimbursements.update', [$reimbursement->conference, $reimbursement]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-6 items-center">
                        <label class="flex gap-3 items-center">
                            <input type="checkbox" name="paid" value="1" {{ $reimbursement->paid ? 'checked' : '' }} />
                            Paid
                        </label>
                        <div class="flex-1">
                            <x-select name="status" :selections="$statuses" :selected="$reimbursement->status" />
                        </div>
                        <x-button>Save</x-button>
                    </div>
                </form>
            </x-cards.main>
            <x-cards.main class="mb-6">

                @livewire('notes', ['subject_type' => 'App\Models\Reimbursement', 'subject_id' => $reimbursement->id])
            </x-cards.main>
        </div>

    </div>


</x-app-layout>