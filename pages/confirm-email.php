<div class="panel-body">
    <p class="text-center pv text-bold">LATEST STEP</p>
    <div class="row">
        <div class="col-lg-12">
            <p id="first-p" class="lead text-center">Hi there, thanks for registering</p>
            <p id="second-p" class="lead text-center">We sent you an email with the confirm link</p>
            <a type="submit" href="/" class="btn btn-block btn-primary mt-lg">Go back</a>
        </div>
    </div>
</div>
<script>
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return "";
}
function checkCookie() {
    var confirm = getCookie("Confirm");
    var f = $("#first-p");
    var s = $("#second-p");
    if (confirm != "") {
        switch (confirm) {
            case "600":
                f.text("You successfully confirmed your email");
                s.remove();
                break;
            case "602":
                f.text("You already confirmed your email");
                s.remove();
                break;
            case "603":
                f.text("Email not found or already confirmed");
                s.remove();
                break;
            case "604":
                f.text("An error occured");
                s.text("Please, try again.");
                break;
        }
    }
}
$(function(){checkCookie()});
</script>