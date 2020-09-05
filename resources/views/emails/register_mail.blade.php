<div><br>
    <div style="padding:0 10px">
        <table style="background-color:#fff;border:1px solid #efefef;max-width:600px;border-radius:5px 5px 5px 5px"
               valign="middle" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
            <tr>
                <td style="border-bottom:1px solid #efefef; background-color: #25aeeb; " width="100%" valign="top"
                    bgcolor="#FFFFFF" align="center"><img style="max-width: 200px; height: auto; padding: 25px;"
                                                          src="http://app.textowners.com/themes/current/images/logo.png" alt="ownerchat.com/" class="CToWUd"
                                                          width="199" height="86"></td>
            </tr>
            <tr>
                <td style="padding-left:10px;padding-right:10px" valign="top" height="110" bgcolor="#FFFFFF">
                    <p style="font-weight:normal;font-size:16px"><u></u><br>

                        Hi {{$user->first_name}} {{$user->last_name}},
                        <br></p>
                    <p>Below is your email and password login.</p>
                    <p style="margin-bottom:25px;margin-top:25px;text-align:center">
                        <a href="javascript:void(0)" target="_blank" style="display: block; color: #000000; font-weight: 500; padding: 13px 5px; letter-spacing: 0.1rem; width: 100%;  text-align: center; max-width: 300px; margin: 0 auto; text-decoration: none ">
                           Your email is: {{$user->email}}
                        </a>
                        {{-- <a href="javascript:void(0)" target="_blank" style="display: block; color: #000000; font-weight: 500; padding: 13px 5px; letter-spacing: 0.1rem; width: 100%;  text-align: center; max-width: 300px; margin: 0 auto; text-decoration: none ">
                            Your password is: {{$user->password}}
                        </a> --}}
                        <a href="{{$url}}" target="_blank" style="display: block; color: #000000; font-weight: 500; padding: 13px 5px; letter-spacing: 0.1rem; width: 100%;  text-align: center; max-width: 300px; margin: 0 auto; text-decoration: none ">
                            URL to login: {{$url}}
                        </a>
                    </p>
                    <u></u>
                    <p></p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style=" margin:0px;padding:20px; font-size: 18px; border-top:1px solid #efefef" align="center">
                    textowners.com
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
