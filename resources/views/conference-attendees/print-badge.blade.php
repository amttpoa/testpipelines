<!DOCTYPE html>
<html>

<head>
    <title>Badges</title>

    <style type="text/css">
        body,
        html {
            font-family: 'Helvetica';
            font-size: 12px;
            margin: 0px;
        }

        table {
            border-spacing: 0px;
            border-collapse: collapse;
            width: 100%;
        }

        td {
            vertical-align: top;
            padding: 5px 0px;
            page-break-inside: avoid;
        }

        .lines {
            border-bottom: 1px solid #888;
        }

        .lines td {
            border-top: 1px solid #888;
        }

        h2 {
            margin-bottom: 5px;
        }

        h2~p {
            margin-top: 0px;
        }

        .user {
            font-size: 16px;
            font-weight: bold;
        }
    </style>

</head>

<body style="margin:0px; box-sizing:border-box;">

    @foreach($badges as $badge)
    <div style="padding:10px;text-align:center;{{ $loop->index > 0 ? 'page-break-before: always;' : '' }}">
        <div style="height:212px;">
            @if($badge->card_type == 'Exhibitor' && $badge->vendorRegistrationSubmission)
            <table>
                <tr>
                    <td style="vertical-align: middle;height:200px;text-align:center;">
                        <img src="{{ Storage::disk('s3')->url('organizations/' . $badge->vendorRegistrationSubmission->organization->image) }}" style="display:inline-block;max-height:200px;max-width:280px;" />
                    </td>
                </tr>
            </table>
            @else

            @if($view == 'html')
            <img src="/img/badge-logo1.png" style="height:200px;" />
            @else
            <img src="{{ public_path('img/badge-logo1.png') }}" style="height:200px;" />
            @endif

            @endif
        </div>

        <div style="height:80px;font-size:24px;line-height:30px;">
            OTOA {{ $conference->name }}
        </div>

        <div style="height:135px;">
            <div style="font-size:50px;font-weight:bold;">{{ $badge->card_first_name }}</div>
            @if(strlen($badge->card_last_name) > 15)
            <div style="font-size:24px;font-weight:bold;line-height:28px;">{{ $badge->card_last_name }}</div>
            @else
            <div style="font-size:36px;font-weight:bold;line-height:40px;">{{ $badge->card_last_name }}</div>
            @endif
        </div>

        <div style="height:45px;font-weight:bold;font-size:16px;">
            {{ $badge->vendorRegistrationSubmission ? $badge->vendorRegistrationSubmission->organization->name : '' }}
            {{ $badge->user ? ($badge->user->organization ? $badge->user->organization->name : '') : '' }}
            {{ $badge->card_organization ? $badge->card_organization : '' }}
        </div>

        <div style="font-size:16px; height:27px;font-weight:bold;">
            {{ $badge->vendorRegistrationSubmission ? $badge->vendorRegistrationSubmission->sponsorship : '' }}
            {{ $badge->package ? $badge->package : '' }}
            {{ $badge->card_package ? $badge->card_package : '' }}
        </div>

        @php
        $color = '293a4e';
        if($badge->card_type == 'Staff') {
        $color = '991b1b';
        }
        if($badge->card_type == 'Instructor') {
        $color = '991b1b';
        }
        if($badge->card_type == 'Exhibitor') {
        $color = 'd49c6a';
        }

        @endphp
        <div style="background-color:#{{ $color }}; color:#fff; padding:10px; font-weight:bold; font-size:30px;">
            {{ $badge->card_type }}
        </div>
    </div>
    @endforeach

</body>

</html>