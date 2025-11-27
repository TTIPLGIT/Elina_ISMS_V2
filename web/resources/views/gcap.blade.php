<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Google reCAPTCHA</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h1>Form with Google reCAPTCHA</h1>
    <form id="myForm" onsubmit="return handleSubmit(event)">
        <div class="g-recaptcha" data-sitekey="6LcfLFUoAAAAACno3hdClnckkDsl4ERrkfhX7Alr"></div><br>
        <button type="submit">Submit</button>
        <p id="response"></p>
    </form>
    <script>
        function handleSubmit(event) {
            event.preventDefault();
            var response = grecaptcha.getResponse();
            // alert("reCAPTCHA response: " + response);
            document.getElementById('response').textContent = response;
            if (response.length === 0) {
                alert("Please complete the reCAPTCHA.");
                return false;
            }
            return false;
        }
    </script>
</body>
</html>