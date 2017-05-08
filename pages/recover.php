<?php if (isLoggedIn()) {
    include 'alreadyin.php';
} else {
    $i = isset($_GET["code"]);
    $text = $i ? "Type here your new password" : "We will send you instructions to reset your password";
    $type = $i ? "password" : "text";
    $placeholder = $i ? "New password" : "Username or email";
    $submit = $i ? "Change" : "Send";
    $fa = $i ? "fa-lock" : "fa-envelope";
    $success = $i ? "Password changed, redirecting in 3 seconds." : "Email sent, can't read? Check in your spam folder.";
    $error = $i ? "There was an error while checking your account, please request another reset." : "No account found with these info, check your username/email.";
?>
<div class="panel-heading text-center">
    <img src="/images/logo-blue.png" alt="Image" class="center-block img-rounded" />
</div>
<div class="panel-body">
    <p class="text-center pv text-bold">RESET PASSWORD</p>
    <div class="alert alert-danger" style="display: none" id="error"><strong>Error</strong> <?php echo $error ?></div>
    <div class="alert alert-danger" style="display: none" id="s-error"><strong>Error</strong> Your password is too short</div>
    <div class="alert alert-danger" style="display: none" id="l-error"><strong>Error</strong> Your password is too long</div>
    <div class="alert alert-danger" style="display: none" id="d-error"><strong>Error</strong> Please retry.</div>
    <div class="alert alert-success" style="display: none" id="success"><strong>Success</strong> <?php echo $success ?></div>
    <div class="alert alert-danger" style="display: none" id="net-error"><strong>Error</strong> An error occured while cheking your info, please retry.</div>
    <form role="form">
        <p class="text-center"><?php echo $text ?></p>
        <div class="form-group has-feedback">
            <input id="resetInput" type="<?php echo $type ?>" placeholder="<?php echo $placeholder ?>" autocomplete="off" class="form-control" />
            <span class="fa <?php echo $fa ?> form-control-feedback text-muted"></span>
        </div>
        <button type="submit" onclick="recover()" class="btn btn-danger btn-block"><?php echo $submit ?></button>
    </form>
</div>
<script>
function sAlert(name, val) {
    if (val) {
        $(name).fadeIn("fast", function() {$(name).show()});
    } else {
        $(name).fadeOut("fast", function() {$(name).hide()});
    }
}
$(function(){$("form").submit(function(e){e.preventDefault();});});
function recover() {
    sAlert("#error", false);
    sAlert("#net-error", false);
    sAlert("#d-error", false);
    sAlert("#success", false);
    sAlert("#s-error", false);
    sAlert("#l-error", false);
    $.ajax({
        url: "/session.php",
        type: "POST",
        dataType: "json",
<?php if ($i) { ?>
        data: {code: "<?= $_GET['code'] ?>", type: "recover", password: $("#resetInput").val()},
<?php } else { ?>
        data: {type: "recover", username: $("#resetInput").val()},
<?php } ?>
        success: function(data) {
            switch (data.CODE) {
                case 703:
                    //error: no account found
                    sAlert("#error", true);
                    break;
                case 704:
                    //error: db error
                    sAlert("#d-error", true);
                    break;
                case 702:
                    //password too short
                    sAlert("#s-error", true);
                    break;
                case 701:
                    //password too long
                    sAlert("#l-error", true);
                    break;
                case 706:
                    //success
                    sAlert("#success", true);
<?php if ($i) { ?>
                    setTimeout(function(){window.location.href = "/page/login"},3e3);
<?php } else { ?>
                    setTimeout(function(){$("#success").text("Email sent, can't read? Check in your spam folder. Redirecting in 3...");setTimeout(function(){$("#success").text("Email sent, can't read? Check in your spam folder. Redirecting in 2...");setTimeout(function(){$("#success").text("Email sent, can't read? Check in your spam folder. Redirecting in 1...");setTimeout(function(){window.location.href="/"},1e3)},1e3)},1e3)},1e3);
<?php } ?>
            }
        },
        error: function(data) {sAlert("#net-error", true);}
    });
}
</script>
<?php } ?>