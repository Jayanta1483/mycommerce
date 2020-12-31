$(document).ready(function () {
    $("#custProfile").click(() => $("#cust-image").trigger("click"))
    $("#cust-image").on("change", (e) => {
        
        let file = e.target.files[0];
        if (file) {
            $("#custProfile").attr("src", window.URL.createObjectURL(file));
           
           
}
    })
})