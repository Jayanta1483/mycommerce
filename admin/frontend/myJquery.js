$(document).ready(function () {

    $("#custProfile").click(() => $("#cust-image").trigger("click"))
    $("#cust-image").on("change", (e) => {

        let file = e.target.files[0];
        if (file) {
            $("#custProfile").attr("src", window.URL.createObjectURL(file));


        }
    })

    // FOR REGISTRSTION PAGE
    $(".p-viewer").click(() => {
        if ($("#pwd").attr("type") == "password") {
            $("#pwd").attr("type", "text");
            $("#eye").css("color", "#33ff33");
        } else {
            $("#pwd").attr("type", "password");
            $("#eye").css("color", "red");
        }
    })

    //FOR LOGIN MODAL
    $('.p-viewer-log').click(() => {
        ($('#log-pwd').attr('type') == "password") ? $('#log-pwd').attr('type', 'text') : $('#log-pwd').attr('type', 'password');
        $('#log-eye').toggleClass('fa-eye fa-eye-slash');
    })

    //For Sending Data to Database using Ajax
    console.log($('#cust-image').prop('files')[0])

    $("#submit").click(() => {
        let imageFile = $('#cust-image').prop('files')[0];

        let form_data = new FormData();
        form_data.append('file', imageFile);
        form_data.append('op', 'insert')
        form_data.append('csrf', $('#csrf').val());
        form_data.append('fname', $("#fname").val());
        form_data.append('lname', $("#lname").val());
        form_data.append('email', $("#email").val());
        form_data.append('mobile', $("#mobile").val());
        form_data.append('logid', $("#logid").val());
        form_data.append('pwd', $("#pwd").val());
        form_data.append('adr', $("#adr").val());




        $.ajax({
            type: "POST",
            url: "backend.php",
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                console.log(response)
                let res = JSON.parse(response);
                console.log(res.type, res.msg);
                if (res.type == 'emp') {
                    $('#empMsg').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#empMsg').fadeOut();

                    }, 2500)
                }
                else if (res.type == 'image') {
                    $('#imageError').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#imageError').fadeOut();

                    }, 2500)

                }
                else if (res.type == 'fn') {
                    $('#fnMsg').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#fnMsg').fadeOut();

                    }, 2500)
                }
                else if (res.type == 'ln') {
                    $('#lnMsg').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#lnMsg').fadeOut();

                    }, 2500)
                }
                else if (res.type == 'em') {
                    $('#emMsg').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#emMsg').fadeOut();

                    }, 2500)
                }
                else if (res.type == 'mb') {
                    $('#mbMsg').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#mbMsg').fadeOut();

                    }, 2500)
                }
                else if (res.type == 'pw') {
                    $('#pwMsg').html(res.msg).fadeIn('slow');
                    setTimeout(() => {
                        $('#pwMsg').fadeOut();

                    }, 2500)
                }
                else if (res.type == 'tk') {
                    $('#profileAlert').html(`<h5 class="alert alert-danger" role="alert">${res.msg}</h5>`).fadeIn('slow');
                    setTimeout(() => {
                        $('#profileAlert').fadeOut();

                    }, 2500)

                }
                else if (response == "error") {
                    $('#profileAlert').html(`<h5 class="alert alert-danger" role="alert">Ooops.!!...Some Error Occured!!</h5>`).fadeIn('slow');
                    setTimeout(() => {
                        $('#profileAlert').fadeOut();

                    }, 2500)
                }
                else {

                    $("#myForm")[0].reset();
                    $("#custProfile").attr("src", "customer_avatar.jpg");
                    console.log(response)
                    $('#profileAlert').html(`<h5 class="alert alert-success" role="alert">Congrats ${JSON.parse(response)}....You have Successfully Registered!!</h5>`).fadeIn('slow');
                    setTimeout(() => {
                        $('#profileAlert').fadeOut();
                    }, 2500)

                }
            }

        })
    })



    // For Checking User Id Availability
    $('#logid').on('focus', () => alert("minmum 4 and maximum 8 charactres, can be all alphabetic or alphanumeric, can't have special characters"))
    $('#logid').on('blur', function () {

        let val = $('#logid').val();
        if (val !== "") {
            $.post(
                "backend.php",
                { ui: val },
                function (response) {

                    $('#idMsg').html(response).fadeIn();
                    setTimeout(() => {
                        $('#idMsg').fadeOut('slow');
                    }, 2500)

                }
            )
        }
    })


    //FOR LOGIN AJAX 
    $('#log-sub').click(() => {

        $.post(
            "backend.php",
            $('#logForm').serialize(),
            function (response) {
                switch (response) {
                    case "tk":
                        alert("Invalid Token!!");
                        break;
                    case "id":
                        alert("Invalid User Id...Please try again!!");
                        break;
                    case "pw":
                        alert("Invalid Password...Please try again!!");
                        break;
                    default:
                        $('#logForm')[0].reset();
                        alert(`Welcome ${response} You have successfully logged in!!`);

                }
            }

        )
    })























})