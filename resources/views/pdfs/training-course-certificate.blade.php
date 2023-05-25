<!DOCTYPE html>
<html>

<head>
    <title>{{ $trainingCourseAttendee->trainingCourse->training->name }} Certifiate</title>
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
                        {{ $trainingCourseAttendee->user->name }}
                    </div>
                    <div style="font-size:50px;font-family:Helvetica;padding-top:110px">
                        {{ $trainingCourseAttendee->trainingCourse->training->name }}
                    </div>
                    <div style="font-size:30px;font-family:Helvetica;">
                        {{ $trainingCourseAttendee->trainingCourse->end_date->format('F j, Y') }}
                    </div>
                </div>

                {{--
            </div>
        </div> --}}
    </div>

</body>

</html>