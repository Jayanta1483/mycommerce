$(document).ready(function () {

    $("#custProfile").click(() => $("#cust-image").trigger("click"))
    $("#cust-image").on("change", (e) => {
        
        let file = e.target.files[0];
        if (file) {
            $("#custProfile").attr("src", window.URL.createObjectURL(file));
           
           
}
    })


$(".p-viewer").click(()=>{
    if($("#pwd").attr("type")=="password"){
        $("#pwd").attr("type", "text");
        $("#eye").css("color", "#33ff33");
    }else{
        $("#pwd").attr("type", "password");
        $("#eye").css("color", "red");
    }
})







})