<!DOCTYPE html>
<html>

<head>
    <title>{{ $courseAttendee->course->name }} Certifiate</title>
    <style>
        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body style="height:100vh;margin:0px;  xfont-family:Helvetica, sans-serif; box-sizing:border-box;">

    <div style="height:100vh;background-image:url({{ public_path('img/certificate-bg-2.png') }});background-size:contain;background-repeat:no-repeat;background-position: center;">
        {{-- <div style="background-color: #d49c6a; height:calc(100% - 8px); border:4px solid #293a4e; box-sizing:border-box;padding:3px;">
            <div style="background-color: #f0f0f0; height:calc(100% - 4px); border:2px solid #293a4e; box-sizing:border-box;"> --}}
                <div style="text-align:center; height:100%;box-sizing:border-box;">

                    <div style="font-size:140px;font-family:Helvetica;padding-top:630px;">
                        {{ $courseAttendee->user->name }}
                    </div>
                    <div style="font-size:50px;font-family:Helvetica;padding-top:110px">
                        {{ $courseAttendee->course->name }}
                    </div>
                    <div style="font-size:30px;font-family:Helvetica;">
                        {{ $courseAttendee->course->end_date->format('F j, Y') }}
                    </div>
                </div>
                <div style="text-align:center; height:100%;box-sizing:border-box;display:none;">
                    <div style="font-size:90px;letter-spacing:5px;padding-top:60px;font-weight:700;">
                        Certificate
                    </div>
                    <div style="font-size:24px;letter-spacing:5px;">
                        of Completion
                    </div>
                    <div style="padding:30px;">
                        This certificate is issued to
                    </div>
                    <div style="font-size:70px;font-family:Helvetica;">
                        {{ $courseAttendee->user->name }}
                    </div>
                    <div style="padding:30px;">
                        for completion of
                    </div>
                    <div style="font-size:30px;font-family:Helvetica;">
                        {{ $courseAttendee->course->name }}
                    </div>
                    <div style="padding:30px;">
                        on
                    </div>
                    <div style="font-size:24px;font-family:Helvetica;">
                        {{ $courseAttendee->course->end_date->format('F j, Y') }}
                    </div>
                </div>
                {{--
            </div>
        </div> --}}
    </div>

</body>

</html>