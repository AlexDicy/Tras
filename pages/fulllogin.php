<?php if (isLoggedIn()) {
    include 'alreadyin.php';
} else { ?>
<div class="container-fluid">
    <div class="text-center panel-heading">
        <img src="/images/logo-blue.png" alt="Image" class="center-block img-rounded" />
    </div>
    <div class="col-md-6">
        <div class="panel-body">
            <p class="text-center pv text-bold">LOGIN</p>
            <div class="alert alert-danger" style="display: none" id="login-error"><strong>Error</strong> No account found with these info, check your password.</div>
            <div class="alert alert-danger" style="display: none" id="login-net-error"><strong>Error</strong> An error occured while cheking your info, please retry.</div>
            <form class="mb-lg">
                <div class="form-group has-feedback">
                    <input id="login-inputEmail" type="text" name="username" required placeholder="Username or email" autocomplete="off" class="form-control" />
                    <span class="fa fa-sign-in form-control-feedback text-muted"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="login-inputPassword" type="password" name="password" required placeholder="Password" class="form-control" />
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                </div>
                <div class="checkbox c-checkbox pull-left mt0">
                    <label>
                        <input id="login-remember-me" type="checkbox" value="" checked/>
                        <span class="fa fa-check"></span>Remember me</label>
                </div>
                <br/>
                <button type="submit" onclick="login()" class="btn btn-block btn-info mt-lg">Login</button>
            </form>
            <p class="text-center text-muted">Or</p>
            <div class="text-center mt"><a href="/page/recover/" class="text-muted">Forgot your password?</a></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel-body">
            <p class="text-center pv text-bold">REGISTER NEW ACCOUNT</p>
            <div class="alert alert-danger" style="display: none" id="register-error"><strong>Error</strong> An account with this Username or Email already exists.</div>
            <div class="alert alert-danger" style="display: none" id="register-char-error"><strong>Error</strong> Only letters, numbers and '_' for the nickname.</div>
            <div class="alert alert-danger" style="display: none" id="register-len-error"><strong>Error</strong> Username, email and password must be at least 4 characters.</div>
            <div class="alert alert-danger" style="display: none" id="register-net-error"><strong>Error</strong> An error occured while cheking your info, please retry.</div>
            <div class="alert alert-danger" style="display: none" id="register-terms-error"><strong>Error</strong> You mush agree to the terms, please check and retry.</div>
            <div class="alert alert-danger" style="display: none" id="register-pass-error"><strong>Error</strong> These passwords don't match, Try again.</div>
            <form class="mb-lg">
                <div class="form-group has-feedback">
                    <input id="register-inputUsername" type="text" placeholder="Username" autocomplete="off" class="form-control" />
                    <span class="fa fa-sign-in form-control-feedback text-muted"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="register-inputEmail" type="email" placeholder="Email" autocomplete="off" class="form-control" />
                    <span class="fa fa-envelope form-control-feedback text-muted"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="register-inputPassword" type="password" placeholder="Password" autocomplete="off" class="form-control" />
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="register-inputRePassword" type="password" placeholder="Type again your password" autocomplete="off" class="form-control" />
                    <span class="fa fa-lock form-control-feedback text-muted"></span>
                </div>
                <div class="clearfix">
                    <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                            <input type="checkbox" id="register-terms" value="" />
                            <span class="fa fa-check"></span>I agree with the <a href="https://tras.pw/tos/" target="_blank">terms</a>
                        </label>
                    </div>
                </div>
                <button type="submit" onclick="register()" class="btn btn-block btn-primary mt-lg">Create account</button>
            </form>
            <script>
            $(function() {
                $("form").submit(function(e) {
                    e.preventDefault();
                });
            });

            function alertReset() {
                sAlert("#login-error", false);
                sAlert("#login-net-error", false);
                sAlert("#register-pass-error", false);
                sAlert("#register-net-error", false);
                sAlert("#register-len-error", false);
                sAlert("#register-terms-error", false);
                sAlert("#register-char-error", false);
                sAlert("#register-error", false);
            }

            function login() {
                alertReset();
                $.ajax({
                    url: "/session.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        type: "login",
                        username: $("#login-inputEmail").val(),
                        password: $("#login-inputPassword").val(),
                        remember: $("#login-remember-me").is(":checked")
                    },
                    success: function(data) {
                        if (data.CODE == 700) {
                            <?php
                            if (isset($_COOKIE['Redirect'])) echo "window.location.href = '".$_COOKIE['Redirect']."';";
                            else echo "window.location.href = '/';";
                            ?>
                        } else sAlert("#login-error", true);
                    },
                    error: function() {
                        sAlert("#login-net-error", true);
                    }
                });
            }

            function register() {
                alertReset();
                var us = $("#register-inputUsername").val();
                var em = $("#register-inputEmail").val();
                var ps = $("#register-inputPassword").val();
                var rps = $("#register-inputRePassword").val();
                if (ps == rps) {
                    if (us.length > 3 && em.length > 4 && ps.length > 3) {
                        if ($("#register-terms").is(":checked")) {
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
                                        window.location.href = "/page/confirm-email/";
                                    } else if (data.CODE == 604) {
                                        sAlert("#register-char-error", true);
                                    } else sAlert("#register-error", true);
                                },
                                error: function() {
                                    sAlert("#register-net-error", true);
                                }
                            });
                        } else sAlert("#register-terms-error", true);
                    } else sAlert("#register-len-error", true);
                } else sAlert("#register-pass-error", true);
            }
            </script>
        </div>
    </div>
</div>
<?php
    if ($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] == "tras.pw/") {
?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "https://tras.pw/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://tras.pw/search?query={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "https://tras.pw",
  "logo": "https://tras.pw/images/logo-min-hires.png"
}
</script>
<?php
    }
}
?>
