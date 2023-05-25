<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('pageTitle')
        @yield('pageTitle') | OTOA
        @else
        {{ $vendorRegistrationSubmission->company_name }} | $OTOA
        @endif
    </title>

    @livewireStyles

    <link rel="shortcut icon" href="/img/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Mulish:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,400;1,500;1,700&family=Titan+One&display=swap" rel="stylesheet">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <link rel="stylesheet" href="/css/app.css">
</head>

<body>


    <div>
        <div class="flex gap-3">
            <div class="flex-1">
                <div class="font-medium text-3xl">{{ $vendorRegistrationSubmission->company_name }}</div>
                <div>
                    <a class="text-otgold font-medium" href="{{ $vendorRegistrationSubmission->company_website }}" target="_blank">{{ $vendorRegistrationSubmission->company_website }}</a>
                </div>
                <div class="font-medium text-xl mt-2">{{ $vendorRegistrationSubmission->sponsorship }} - ${{ $vendorRegistrationSubmission->sponsorship_price }}</div>
            </div>
            <div>
                @if($vendorRegistrationSubmission->image)
                <div>
                    <img class="max-h-40 max-w-xs" src="{{ Storage::disk('s3')->url('vendor-logos/' . $vendorRegistrationSubmission->image) }}" />
                </div>
                @endif
                <div>
                    {{ $vendorRegistrationSubmission->user ? $vendorRegistrationSubmission->user->name : ''}}
                </div>
            </div>
        </div>


        <table class="mt-6">
            <tr>
                <td class="font-medium text-right pr-2">Live Fire:</td>
                <td>{{ $vendorRegistrationSubmission->live_fire }} - ${{ $vendorRegistrationSubmission->live_fire_price }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Lunch:</td>
                <td>
                    @if($vendorRegistrationSubmission->lunch)
                    {{ $vendorRegistrationSubmission->lunch }} - ${{ $vendorRegistrationSubmission->lunch_price }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Power:</td>
                <td>{{ $vendorRegistrationSubmission->power }} - ${{ $vendorRegistrationSubmission->power_price }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">TV:</td>
                <td>
                    @if($vendorRegistrationSubmission->tv)
                    {{ $vendorRegistrationSubmission->tv }} - ${{ $vendorRegistrationSubmission->tv_price }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Internet:</td>
                <td>{{ $vendorRegistrationSubmission->internet }} - ${{ $vendorRegistrationSubmission->internet_price }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Tables:</td>
                <td>{{ $vendorRegistrationSubmission->tables }} - ${{ $vendorRegistrationSubmission->tables_price }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Lunch Qty:</td>
                <td>{{ $vendorRegistrationSubmission->lunch_qty }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Tables Qty:</td>
                <td>{{ $vendorRegistrationSubmission->tables_qty }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Total:</td>
                <td>${{ $vendorRegistrationSubmission->total }}</td>
            </tr>
            <tr>
                <td class="font-medium text-right pr-2">Comments:</td>
                <td>{{ $vendorRegistrationSubmission->comments }}</td>
            </tr>
        </table>

        <div class="mt-8 flex gap-6">
            <div>
                <div class="font-medium text-xl">Advertising</div>
                <div>{{ $vendorRegistrationSubmission->advertising_name }}</div>
                <div><a href="mailto:{{ $vendorRegistrationSubmission->advertising_email }}" target="_blank">{{ $vendorRegistrationSubmission->advertising_email }}</a></div>
                <div>{{ $vendorRegistrationSubmission->advertising_phone }}</div>
            </div>
            <div>
                <div class="font-medium text-xl">Live Fire</div>
                <div>{{ $vendorRegistrationSubmission->live_fire_name }}</div>
                <div><a href="mailto:{{ $vendorRegistrationSubmission->live_fire_email }}" target="_blank">{{ $vendorRegistrationSubmission->live_fire_email }}</a></div>
                <div>{{ $vendorRegistrationSubmission->live_fire_phone }}</div>
            </div>
            <div>
                <div class="font-medium text-xl">Primary</div>
                <div>{{ $vendorRegistrationSubmission->primary_name }}</div>
                <div><a href="mailto:{{ $vendorRegistrationSubmission->primary_email }}" target="_blank">{{ $vendorRegistrationSubmission->primary_email }}</a></div>
                <div>{{ $vendorRegistrationSubmission->primary_phone }}</div>
            </div>
            <div>
                <div class="font-medium text-xl">Billing</div>
                <div>{{ $vendorRegistrationSubmission->billing_name }}</div>
                <div><a href="mailto:{{ $vendorRegistrationSubmission->billing_email }}" target="_blank">{{ $vendorRegistrationSubmission->billing_email }}</a></div>
                <div>{{ $vendorRegistrationSubmission->billing_phone }}</div>
            </div>
        </div>


        <div class="mt-8 flex gap-6">
            @foreach($vendorRegistrationSubmission->attendees as $attendee)
            <div>
                <div class="font-medium text-xl">Rep {{ $loop->index + 1 }}</div>
                <div>{{ $attendee->name }}</div>
                <div><a href="mailto:{{ $attendee->email }}" target="_blank">{{ $attendee->email }}</a></div>
                <div>{{ $attendee->phone }}</div>
            </div>
            @endforeach
        </div>



    </div>






    </div>
</body>

</html>