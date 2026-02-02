<!DOCTYPE html>
<html>
<head>
</head>

<body>
    Dear {{$data['name']}},<br><br>

    I hope this message finds you well. We are pleased to inform you that we have received a new inquiry form via our "Contact Us" form. Please review the form details at your earliest convenience.<br>
    This email serves as an official notification to prompt our team to take the necessary steps as per our standard procedures.
    <br><br>

    Name of the Person : {{$data['name']}}<br>
    Comment : {{$data['comments']}}<br>
    Phone Number : {{$data['phonenumber']}}<br>
    <br><br>

    Yours sincerely,<br>
    Web Administrator,<br>
    ELiNA
</body>
</html>
