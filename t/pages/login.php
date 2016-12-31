<?php
require_once '../../session.php';
if(isLoggedIn()) {
    include 'alreadyin.php';
} else { ?>
<div class="center-block mt-xl wd-xl">
   <!-- START panel-->
   <div class="panel panel-inverse">
      <div class="panel-heading text-center">
         <img src="images/logo-blue.png" alt="Image" class="center-block img-rounded" />
      </div>
      <div class="panel-body">
         <p class="text-center pv text-bold">LOGIN</p>
         <div class="alert alert-danger" style="display: none" id="error"><strong>Error</strong> No account found with these info, check your password.</div>
         <div class="alert alert-danger" style="display: none" id="net-error"><strong>Error</strong> An error occured while cheking your info, please retry.</div>
         <form role="form" class="mb-lg">
            <div class="form-group has-feedback">
               <input id="inputEmail" type="text" name="username" required placeholder="Username or email" autocomplete="off" class="form-control" />
               <span class="fa fa-sign-in form-control-feedback text-muted"></span>
            </div>
            <div class="form-group has-feedback">
               <input id="inputPassword" type="password" name="password" required placeholder="Password" class="form-control" />
               <span class="fa fa-lock form-control-feedback text-muted"></span>
            </div>
            <div class="checkbox c-checkbox pull-left mt0">
               <label>
                  <input type="checkbox" value=""/>
                  <span class="fa fa-check"></span>Remember me</label>
            </div>
            <br/>
            <button type="submit" onclick="login()" class="btn btn-block btn-info mt-lg">Login</button>
         </form>
         <p class="text-center text-muted">Or</p>
         <a ui-sref="page.register" class="btn btn-block btn-default">
            <strong>Register an Account</strong>
         </a>
      </div>
   </div>
   <script>
   function sAlert(name, val) {
        if (val) {
            $(name).fadeIn("fast", function() {$(name).show()});
        } else {
            $(name).fadeOut("fast", function() {$(name).hide()});
        }
    }
    function login() {
        sAlert("#error", false);
        sAlert("#net-error", false);
        $.ajax({
            url: "/session.php",
            type: "POST",
            dataType: "json",
            data: {type: "login", username: $("#inputEmail").val(), password: $("#inputPassword").val()},
            success: function(data) {
                if (data.CODE == 700) {
                    window.location.href = "/";
                } else sAlert("#error", true);
            },
            error: function() {sAlert("#net-error", true);}
        });
    }
    </script>
   <div class="text-center mt"><a ui-sref="page.recover" class="text-muted">Forgot your password?</a>
   </div>
   <!-- END panel-->
   <div data-ng-include="'t/pages/page-footer.html'" class="p-lg text-center"></div>
</div>
<?php } ?>