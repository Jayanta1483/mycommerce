$(document).ready(function () {

    $("#custProfile").click(() => $("#cust-image").trigger("click"))
    $("#cust-image").on("change", (e) => {

        let file = e.target.files[0];
        if (file) {
            $("#custProfile").attr("src", window.URL.createObjectURL(file));


        }
    })


    $(".p-viewer").click(() => {
        if ($("#pwd").attr("type") == "password") {
            $("#pwd").attr("type", "text");
            $("#eye").css("color", "#33ff33");
        } else {
            $("#pwd").attr("type", "password");
            $("#eye").css("color", "red");
        }
    })


    //For Sending Data to Database using Ajax
    console.log($('#cust-image').prop('files')[0])

    $("#submit").click(() => {
        let imageFile = $('#cust-image').prop('files')[0];

        let form_data = new FormData();
        form_data.append('file', imageFile);
        form_data.append('op', 'insert')
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
                if (response !== "error") {
                    $("#myForm")[0].reset();
                    $("#custProfile").attr("src", "customer_avatar.jpg");
                    console.log(response)
                    $('#profileAlert').toggleClass('alert-danger alert-success').html(`Welcome ${JSON.parse(response)}....You have Successfully Registered!!`).fadeIn('slow');
                    setTimeout(()=>{
                        $('#profileAlert').fadeOut();
                    }, 2500)
                    
                } else {
                    $('#profileAlert').addClass('alert-success alert-danger').html(`Ooops.!!...Some Error Occured!!`).fadeIn('slow');
                    setTimeout(()=>{
                        $('#profileAlert').fadeOut();
                        
                    }, 2500)
                    
                }
            }

        })
    })




})