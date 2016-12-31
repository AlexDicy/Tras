<?php
require_once '../../session.php';
if (isLoggedIn()) {?>
<div class="center-block mt-xl wd-xl">
    <!-- START panel-->
    <div class="panel panel-inverse">
        <div class="panel-body">
            <p class="text-center pv text-bold">LOGOUT</p>
            <div class="alert alert-danger" style="display: none" id="error"><strong>Error</strong> You could be not logged in.</div>
            <div class="alert alert-danger" style="display: none" id="net-error"><strong>Error</strong> Internet error, try again.</div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="lead text-center">Are you sure?</p>
                    <button type="submit" onclick="logout();" class="btn btn-block btn-primary mt-lg">Logout</button>
                    <a ui-sref="app.dashboard" id="go-back" class="btn btn-block btn-default">
                        <strong>Keep me logged in</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
    function logout() {
        $.ajax({
            url: "/session.php",
            type: "POST",
            dataType: "json",
            data: {type: "logout"},
            success: function(data) {
                if (data.CODE == 500) {
                    window.location.href = "/";
                } else $("#error").fadeIn("fast", function() {$("#error").show();});
            },
            error: function() {$("#net-error").fadeIn("fast", function() {$("#net-error").show()});}
        });
    }
    </script>
    <!-- END panel-->
    <div data-ng-include="'t/pages/page-footer.html'" class="p-lg text-center"></div>
</div>
<?php } else {?>
<div class="center-block mt-xl wd-xl">
    <!-- START panel-->
    <div class="panel panel-inverse">
        <div class="panel-body">
            <p class="text-center pv text-bold">NOT LOGGED IN</p>
            <div class="row">
                <div class="col-lg-12">
                    <p class="lead text-center" id="redir-text">Redirecting in 2...</p>
                    <a ui-sref="page.login" id="login" class="btn btn-block btn-default">
                        <strong>Not working? click me.</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
    setTimeout(function(){$("#redir-text").text("Redirecting in 1...");}, 1000);
    setTimeout(function(){$("#login").trigger("click");}, 2000);
    </script>
    <!-- END panel-->
    <div data-ng-include="'t/pages/page-footer.html'" class="p-lg text-center"></div>
</div>
<?php } ?>