<?php if (isLoggedIn()) {
    include 'alreadyin.php';
} else { ?>
<div class="panel-heading text-center">
    <img src="/images/logo-blue.png" alt="Image" class="center-block img-rounded" />
</div>
<div class="panel-body">
    <p class="text-center pv text-bold">REGISTER NEW ACCOUNT</p>
    <div class="alert alert-danger" style="display: none" id="error"><strong>Error</strong> An account with this Username or Email already exists.</div>
    <div class="alert alert-danger" style="display: none" id="char-error"><strong>Error</strong> Only letters, numbers and '_' for the nickname.</div>
    <div class="alert alert-danger" style="display: none" id="len-error"><strong>Error</strong> Username, email and password must be at least 4 characters.</div>
    <div class="alert alert-danger" style="display: none" id="net-error"><strong>Error</strong> An error occured while cheking your info, please retry.</div>
    <div class="alert alert-danger" style="display: none" id="terms-error"><strong>Error</strong> You mush agree to the terms, please check and retry.</div>
    <div class="alert alert-danger" style="display: none" id="pass-error"><strong>Error</strong> These passwords don't match, Try again.</div>
    <form role="form" class="mb-lg">
        <div class="form-group has-feedback">
            <input id="inputUsername" type="text" placeholder="Username" autocomplete="off" class="form-control" />
            <span class="fa fa-sign-in form-control-feedback text-muted"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="inputEmail" type="email" placeholder="Email" autocomplete="off" class="form-control" />
            <span class="fa fa-envelope form-control-feedback text-muted"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="inputPassword" type="password" placeholder="Password" autocomplete="off" class="form-control" />
            <span class="fa fa-lock form-control-feedback text-muted"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="inputRePassword" type="password" placeholder="Type again your password" autocomplete="off" class="form-control" />
            <span class="fa fa-lock form-control-feedback text-muted"></span>
        </div>
        <div class="clearfix">
            <div class="checkbox c-checkbox pull-left mt0">
                <label>
                    <input type="checkbox" id="terms" value="" />
                    <span class="fa fa-check"></span>I agree with the <a href="https://tras.pw/tos" target="_blank">terms</a>
                </label>
            </div>
        </div>
        <button type="submit" onclick="register()" class="btn btn-block btn-primary mt-lg">Create account</button>
    </form>
    <p class="pt-lg text-center">Already registered?</p>
    <a href="/page/login" class="btn btn-block btn-default">
        <strong>Login</strong>
    </a>
    <script>
        function sAlert(name, val) {
            if (val) {
                $(name).fadeIn("fast", function() {
                    $(name).show()
                });
            } else {
                $(name).fadeOut("fast", function() {
                    $(name).hide()
                });
            }
        }

        $(function(){$("form").submit(function(e){e.preventDefault();});});

        function register() {
            sAlert("#pass-error", false);
            sAlert("#net-error", false);
            sAlert("#len-error", false);
            sAlert("#terms-error", false);
            sAlert("#char-error", false);
            sAlert("#error", false);
            var us = $("#inputUsername").val();
            var em = $("#inputEmail").val();
            var ps = $("#inputPassword").val();
            var rps = $("#inputRePassword").val();
            if (ps == rps) {
                if (us.length > 3 && em.length > 4 && ps.length > 3) {
                    if ($("#terms").is(":checked")) {
                        $.ajax({
                            url: "/session.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                type: "register",
                                username: us,
                                password: ps,
                                email: em
                            },
                            success: function(data) {
                                if (data.CODE == 700) {
                                    window.location.href = "/page/confirm-email";
                                } else if (data.CODE == 604) {
                                    sAlert("#char-error", true);
                                } else sAlert("#error", true);
                            },
                            error: function() {
                                sAlert("#net-error", true);
                            }
                        });
                    } else sAlert("#terms-error", true);
                } else sAlert("#len-error", true);
            } else sAlert("#pass-error", true);
        }
    </script>
</div>
<?php } ?>