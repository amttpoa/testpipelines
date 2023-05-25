<x-email-layout>

    <x-slot name="name">
        {{ $user->name }}
    </x-slot>

    <div>
        {!! $content !!}
    </div>

    @isset($sig)
    @if($sig)
    <table width="100%" style="margin-top:60px;">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="font-family:arial;border-top:1px solid #a6b0b6;border-bottom:1px solid #a6b0b6;">
                    <tr>
                        <td style="background-color:#293a4e; padding:10px;">
                            <a href="https://otoa.org/">
                                <img src="https://otoa.org/img/logo-vertical.png" width="150" style="width:150px;" />
                            </a>
                        </td>
                        <td style="font-size:12px;padding:10px;">
                            <div style="font-weight:700;color:#000000;">{{ strtoupper($sig_user->name) }}</div>
                            <div style="font-weight:500;color:#858585;">{{ $sig_user->profile->title }}</div>
                            <div style="font-weight:500;color:#858585;">{{ $sig_user->organization->name }}</div>
                            <div style="font-weight:500;color:#000000;margin-top:10px;">17000 St. Clair Avenue, Suite 108</div>
                            <div style="font-weight:500;color:#000000;">Cleveland, Ohio 44110</div>
                            <div style="font-weight:500;color:#000000;">{{ $sig_user->profile->phone }}</div>
                            <div style="font-weight:500;color:#000000;"><a href="mailto:{{ $sig_user->email }}" style="color:#d49c6a;font-weight:700;text-decoration:none;">{{ $sig_user->email }}</a></div>
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
            </td>
        </tr>
    </table>
    @endif
    @endisset

</x-email-layout>