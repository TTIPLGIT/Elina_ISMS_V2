<script>
    function completeCheck(session) {
        // Section 1
        const urlPattern1 = /^(https?:\/\/)?(localhost|[\w-]+(\.[\w-]+)+\/?)([^\s]*)?$/;

        var child_school_name_address = $('#child_school_name_address').val();
        child_school_name_address = removeURLs(child_school_name_address);
        $('#child_school_name_address').val(child_school_name_address);

        var child_contact_address = $('#child_contact_address').val();
        child_contact_address = removeURLs(child_contact_address);
        $('#child_contact_address').val(child_contact_address);

        var name = $('#name').val();
        name = removeURLs(name); $('#name').val(name);

        var password = $('#password').val();
        var password_confirmation = document.getElementById('password-confirm').value;
        if (urlPattern1.test(child_school_name_address)) {
            $('#child_school_name_address').val('');
            return false;
        }
        if (urlPattern1.test(child_contact_address)) {
            $('#child_contact_address').val('');
            return false;
        }
        if (urlPattern1.test(name)) {
            $('#name').val('');
            return false;
        }
        if (urlPattern1.test(password)) {
            $('#password').val('');
            return false;
        }
        if (urlPattern1.test(password_confirmation)) {
            document.getElementById('password-confirm').value = '';
            return false;
        }
        if (session == 1) {
            var child_name = $('#child_name').val();
            if (child_name == '') {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            var child_dob = $('#child_dob').val();
            if (child_dob == '') {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            if (child_school_name_address == '') {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            var child_gender = $('input[name="child_gender"]:checked').val();
            if (child_gender !== "Male" && child_gender !== "Female") {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            var child_father_guardian_name = $('#child_father_guardian_name').val();
            // if (child_father_guardian_name == '') {
            //     document.getElementById('completeCheck1').checked = false;$('.completeCheck1').hide();
            //     return false;
            // }

            var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();
            // if (child_mother_caretaker_name == '') {
            //     document.getElementById('completeCheck1').checked = false;$('.completeCheck1').hide();
            //     return false;
            // }

            var child_contact_email = $('#child_contact_email').val();
            if (child_contact_email == '') {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            let testemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!testemail.test(child_contact_email)) {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            if (child_contact_address == '') {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            var child_contact_phone = $('#child_contact_phone').val();
            if (child_contact_phone == '') {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            var p1 = window.intlTelInputGlobals.getInstance(phone_number).isValidNumber();
            if (p1 == false) {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }

            var child_alter_phone = $('#child_alter_phone').val();
            if (child_alter_phone != '') {
                var p2 = window.intlTelInputGlobals.getInstance(phone_number2).isValidNumber();
                if (p2 == false) {
                    document.getElementById('completeCheck1').checked = false;
                    $('.completeCheck1').hide();
                    return false;
                }
            }

            if (child_contact_phone == child_alter_phone) {
                document.getElementById('completeCheck1').checked = false;
                $('.completeCheck1').hide();
                return false;
            }
            $('.completeCheck1').show();
            document.getElementById('completeCheck1').checked = true;
        }
        // End Section 1
        // Section 2
        if (session == 2) {
            var featured3 = document.getElementById("featured-3");
            var featured4 = document.getElementById("featured-4");
            var featured11 = document.getElementById("featured-11");
            var featured12 = document.getElementById("featured-12");
            var featured13 = document.getElementById("featured-13");

            if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false)) {
                document.getElementById('completeCheck2').checked = false;
                $('.completeCheck2').hide();
                return false;
            }

            var featured5 = document.getElementById("featured-5");
            var featured6 = document.getElementById("featured-6");
            var featured7 = document.getElementById("featured-7");
            var featured8 = document.getElementById("featured-8");
            var featured9 = document.getElementById("featured-9");
            var featured10 = document.getElementById("featured-10");

            if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {
                document.getElementById('completeCheck2').checked = false;
                $('.completeCheck2').hide();
                return false;
            }
            $('.completeCheck2').show();
            document.getElementById('completeCheck2').checked = true;
        }
        // End Section 2
        // Session 3
        if (session == 3) {

            if (name == '') {
                document.getElementById('completeCheck3').checked = false;
                $('.completeCheck3').hide();
                return false;
            }

            if (password == '') {
                document.getElementById('completeCheck3').checked = false;
                $('.completeCheck3').hide();
                return false;
            }


            if (password_confirmation == '') {
                document.getElementById('completeCheck3').checked = false;
                $('.completeCheck3').hide();
                return false;
            }

            var pwd_validation = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
            var pwd_check = pwd_validation.test(password);
            if (pwd_check == false) {
                document.getElementById('completeCheck3').checked = false;
                $('.completeCheck3').hide();
                return false;
            }

            if (password != password_confirmation) {
                document.getElementById('completeCheck3').checked = false;
                $('.completeCheck3').hide();
                return false;
            }
            $('.completeCheck3').show();
            document.getElementById('completeCheck3').checked = true;
        }
        // End Session 3
    }
</script>