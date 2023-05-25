<!DOCTYPE html>
<html>

<head>
    <title>Roster</title>

    <style type="text/css">
        body {
            font-family: 'Helvetica';
            font-size: 12px;
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

<body>

    @foreach($courses as $course)
    <div style="{{ $loop->index > 0 ? 'page-break-before: always;' : '' }}">
        <h1 style="margin-bottom:5px;">{{ $course->name }}</h1>
        <table style="margin-bottom:20px;">
            <tr>
                <td>
                    <div style="margin-bottom:5px;">
                        <span style="font-weight:bold; padding-right:10px; font-size:14px;">{{ $course->start_date->format('m/d/Y')}}</span>
                        {{ $course->start_date->format('H:i') }}-{{ $course->end_date->format('H:i') }}
                    </div>
                    <div style="font-weight: bold;">
                        {{ $course->venue ? $course->venue->name : '' }}
                    </div>
                    <div>
                        {{ $course->location }}
                    </div>
                    <div style="margin-top:5px; font-weight:bold;">
                        {{ $course->courseAttendees->count() }} Attendees
                    </div>
                </td>
                <td>
                    <div style="font-weight:bold; font-size:14px;">Instructors</div>
                    <div>
                        {{ $course->user ? $course->user->name : '' }}
                        {{ $course->user ? ($course->user->profile->phone ? ' - ' . $course->user->profile->phone : '') : '' }}
                    </div>
                    @foreach($course->users as $user)
                    <div>
                        {{ $user->name }}
                        {{ $user->profile->phone ? ' - ' . $user->profile->phone : '' }}
                    </div>
                    @endforeach
                </td>
            </tr>
        </table>

        <table class="lines">
            @foreach($course->courseAttendees->sortBy('user.name') as $attendee)
            <tr>
                <td style="width:35%;">
                    <div class="user">{{ $attendee->user->name }}</div>
                    <div>{{ $attendee->user->profile->phone }}</div>
                    <div>{{ $attendee->user->email }}</div>
                </td>
                <td>
                    <div style="font-weight:bold;">{{ $attendee->user->organization ? $attendee->user->organization->name : '' }}</div>
                    <div>
                        @foreach($attendee->user->organizations as $organization)
                        <div>{{ $organization->name }}</div>
                        @endforeach
                    </div>
                </td>
                <td style="width:20%;">

                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endforeach

</body>

</html>