<div class="mt-6">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="font-family:arial;border-top:1px solid #a6b0b6;border-bottom:1px solid #a6b0b6;">
        <tr>
            <td style="background-color:#293a4e; padding:10px;">
                <a href="https://otoa.org/">
                    <img src="https://otoa.org/img/logo-vertical.png" width="150" style="width:150px;" />
                </a>
            </td>
            <td style="font-size:12px;padding:10px;">
                <div style="font-weight:700;color:#000000;" class="sig1">{{ strtoupper(auth()->user()->name) }}</div>
                <div style="font-weight:500;color:#858585;" class="sig2">{{ auth()->user()->profile->title }}</div>
                <div style="font-weight:500;color:#858585;" class="sig3">{{ auth()->user()->organization->name }}</div>
                <div style="font-weight:500;color:#000000;margin-top:10px;" class="sig4">17000 St. Clair Avenue, Suite 108</div>
                <div style="font-weight:500;color:#000000;" class="sig5">Cleveland, Ohio 44110</div>
                <div style="font-weight:500;color:#000000;" class="sig6">{{ auth()->user()->profile->phone }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border-top:1px solid #a6b0b6;padding:5px 15px 5px 15px;text-align:center;">
                <a href="http://www.facebook.com/OhioTacticalOfficersAssociation"><img src="https://otoa.org/img/email-facebook.png" width="25" style="width:25px;display:inline;" /></a>
                &nbsp;
                <a href="https://twitter.com/OhioTacOA"><img src="https://otoa.org/img/email-twitter.png" width="25" style="width:25px;display:inline;" /></a>
                &nbsp;
                <a href="http://www.youtube.com/channel/UCcy1VFpAi4U8ZVZsrjU3LyQ"><img src="https://otoa.org/img/email-youtube.png" width="25" style="width:25px;display:inline;" /></a>
                &nbsp;
                <a href="http://www.linkedin.com/company/otoa/"><img src="https://otoa.org/img/email-linkedin.png" width="25" style="width:25px;display:inline;" /></a>
                &nbsp;
                <a href="https://www.instagram.com/ohiotacticalofficers/"><img src="https://otoa.org/img/email-instagram.png" width="25" style="width:25px;display:inline;" /></a>
            </td>
        </tr>
    </table>
    @can('full-access')
    <div style="margin-top:10px;font-size:12px;font-family:arial;">
        <div style="font-size:14px;font-weight:700;">Need to schedule a meeting with Pat?</div>

        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;" href="https://calendly.com/otoa/15min">Schedule 15 Minute Meeting</a>
        </div>
        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;" href="https://calendly.com/otoa/30min">Schedule 30 Minute Meeting</a>
        </div>
        <div>
            <a style="color:#d49c6a;font-weight:700;text-decoration:none;" href="https://calendly.com/otoa/60min">Schedule 60 Minute Meeting</a>
        </div>
    </div>
    @endcan
</div>