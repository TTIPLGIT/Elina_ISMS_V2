<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Reflection Form</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f6f9; padding:20px;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; padding:25px; border-radius:8px;">
                    
                    <tr>
                        <td style="color:#333; font-size:14px; line-height:1.6;">

                            <p>Dear Parent,</p>

                            <p>
                                Thank you so much for taking the time to connect with us. We’re truly looking forward to getting to know you and your child, 
                                <strong>{{$data['child_name']}}</strong>.
                            </p>

                            <p>
                                As a prelude to our upcoming discussion on 
                                <strong>{{$data['meeting_startdate']}}</strong>, we have put together a short reflection form. 
                                This is a gentle way for us to understand your child a little better and make our conversation more meaningful for you.
                            </p>

                            <!-- Button -->
                            <p style="text-align:center; margin:25px 0;">
                                <a href="{{$data['g2form_url']}}" 
                                   style="background-color:#1a73e8; color:#ffffff; padding:12px 20px; text-decoration:none; border-radius:5px; font-weight:bold; display:inline-block;">
                                   Access the Reflection Form
                                </a>
                            </p>

                            <p>
                                Please feel free to respond in a way that feels comfortable to you. You can keep your responses brief, 
                                skip anything you’re unsure about, and there are no right or wrong answers here.
                            </p>

                            <p>
                                More than anything, this is just a starting point for us to listen and understand your journey. 
                                Your genuine responses will help us make the most of our time together and ensure a more insightful and productive session.
                            </p>

                            <p>
                                We truly appreciate you sharing this with us, and we look forward to speaking with you on 
                                <strong>{{$data['meeting_startdate']}}</strong>.
                            </p>

                            <p>
                                With care,<br>
                                <strong>Team Elina</strong>
                            </p>

                        </td>
                    </tr>

                </table>
                <!-- End Container -->

            </td>
        </tr>
    </table>

</body>
</html>