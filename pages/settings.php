<?php
$active = array('basic' => "", 'password' => "", 'notifications' => "");

function getActiveClass($name, $active) {
    if (array_key_exists($name, $active) && !empty($active[$name])) return " active"; 
    else return "";
}

if (isset(Shared::get("path")[1])) {
    if (array_key_exists(Shared::get("path")[1], $active)) {
        $active[Shared::get("path")[1]] = " active";
    }
?>
<div class="col-md-2">
    <div class="list-group">
        <a href="https://tras.pw/settings/basic/" class="list-group-item<?= getActiveClass("basic", $active) ?>">Basic Info</a>
 		<a href="https://tras.pw/settings/password/" class="list-group-item<?= getActiveClass("password", $active) ?>">Password</a>
 		<a href="https://tras.pw/settings/notifications/" class="list-group-item<?= getActiveClass("notifications", $active) ?>">Notifications</a>
    </div>
</div>
<div class="col-md-10">
<?php
switch (Shared::get("path")[1]) {
    case "basic":
?>
    <h4>Basic Info</h4>
    <p>Avatar</p>
    <img style="border-radius: 4px;" class="mb img-responsive thumb64" src="<?= Shared::$USERDATA['info']['avatar'] ?>">
    <div class="alert alert-danger" style="display: none" id="uploaderror"><strong>Error</strong> <p id="p-u-e">An error occurred, try again.</p></div>
    <div class="alert alert-info" style="display: none" id="image-uploading"><strong>Uploading</strong><div class="progress progress-striped active"><div class="progress-bar progress-bar-danger" id="upload-progress-bar" style="width: 100%"></div></div></div>
    <div id="image-resize-container" class="col-md-12" style="display:none; width:300px; height:300px; margin-bottom:76px; padding:0 0;"><a id="image-upload-button" style="margin-bottom: 6px;" class="btn btn-primary">Upload</a><div id="image-resize"></div></div>
    <button class="btn btn-info" data-toggle="collapse" data-target="#upload-avatar-collapse">Change avatar</button>
    <div id="upload-avatar-collapse" class="collapse col-lg-12">
        <p class="lead">.png .jpg .jpeg .gif are supported: your image will automatically convert into .png</p>
        <div class="alert alert-info" style="display: none" id="uploaded"><p class="lead"><strong>Info</strong> Avatar uploaded. <a class="btn btn-primary" onclick="window.location.reload(true)">Reload and see changes</a></p></div>
        <form id="image-upload-form" enctype="multipart/form-data">
            <input type="file" name="image" id="image-input">
        </form>
        <link type="text/css" rel="stylesheet" href="https://tras.pw/assets/styles/fileinput.min.css">
        <link type="text/css" rel="stylesheet" href="https://tras.pw/assets/styles/croppie.css">
        <script src="https://tras.pw/assets/js/croppie.min.js"></script>
        <script src="https://tras.pw/assets/js/fileinput.min.js"></script>
        <script>
        function build() {
            $("#image-input").fileinput({
                showUpload: true,
                previewFileType: "image",
                //uploadUrl: "https://tras.pw/upload.php",
                allowedFileExtensions: ["png", "jpeg", "jpg", "gif"],
                uploadClass: "btn btn-success",
                removeClass: "btn btn-danger",
                allowedPreviewTypes: "image"
            });
            $("#image-input").fileinput("enable");
        }
        build();
        $("#image-upload-form").submit(function(e) {
            e.preventDefault();
            var output = $("#image-resize");
            $("#image-resize-container").show();
            output.croppie({
                url: $(".kv-preview-data").attr("src"),
            });
            $("#image-input").fileinput('destroy');
            build();
        });

        function l(t) { console.log(t) }

        $("#image-upload-button").on('click', function() {
            $("#image-resize").croppie('result', 'rawcanvas').then(function(canvas) {
                var dataUrl = canvas.toDataURL();
                var sId = getCookie("TrasID");
                var uId = getCookie("userID");
                $("#image-resize").croppie('destroy');
                $("#image-resize-container").hide();
                $("#image-uploading").fadeIn();
                $.ajax({
                    url: "https://images.tras.pw/upload/avatar/upload.php",
                    type: "POST",
                    data: {image: dataUrl, sessionId: sId, userId: uId},
                    dataType: "json",
                    xhr: function () {
                        var nxhr = new window.XMLHttpRequest();
                        nxhr.upload.addEventListener("progress", function (event) {
                            if (event.lengthComputable) {
                                var pc = event.loaded / event.total;
                                $("#upload-progress-bar").css("width", Math.round(pc * 100) + "%");
                            }
                        }, false);
                        return nxhr;
                    },
                    success: function(data) {
                        $("#image-uploading").fadeOut();
                        if (data.status == 200) {          
                            $("#uploaded").fadeIn("fast", function() { $("#uploaded").show() });
                        } else {
                            var ue = $("#uploaderror");
                            $("#p-u-e").text(data.error);
                            ue.fadeIn('slow', function() {setTimeout(function() { ue.fadeOut() }, 2000) })
                        }
                    },
                    error: function() { l("error") }
                });
            });
        });

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        </script>
    </div>
<?php
        break;
    case "password":
?>
    <h4>Change password</h4>
    <div class="well bs-component">
        <div class="alert alert-success" style="display: none" id="password-success"><strong>Success</strong> The password has been changed.</div>
        <div class="alert alert-danger" style="display: none" id="password-error"><strong>Error</strong> The new password should be longer, 8 character password is good.</div>
        <div class="alert alert-danger" style="display: none" id="wrong-password-error"><strong>Error</strong> The old password is not correct.</div>
        <div class="alert alert-danger" style="display: none" id="match-password-error"><strong>Error</strong> The passwords don't match.</div>
        <div class="alert alert-danger" style="display: none" id="net-error"><strong>Error</strong> There was a problem, please retry.</div>
        <form id="pass-form" action="javascript:void(0);">
            <div class="form-group">
                <label for="opass">Old password</label>
                <input type="password" class="form-control" id="opass">
            </div>
            <div class="form-group">
                <label for="newpass">New password</label>
                <input type="password" class="form-control" id="newpass">
            </div>
            <div class="form-group">
                <label for="repeatpass">Repeat password</label>
                <input type="password" class="form-control" id="repeatpass">
            </div>
            <button type="submit" onclick="changePassword()" class="btn btn-block btn-info mt-lg">Change</button>
        </form>
    </div>
    <script>
    function changePassword() {
        sAlert("#password-error", false);
        sAlert("#match-password-error", false);
        sAlert("#wrong-password-error", false);
        sAlert("#net-error", false);
        sAlert("#password-success", false);
        var opass = $("#opass").val();
        var newpass = $("#newpass").val();
        var repeatpass = $("#repeatpass").val();
        if (newpass == repeatpass) {
            $.ajax({
                url: "/session.php",
                type: "POST",
                dataType: "json",
                data: {
                    type: "changePassword",
                    password: opass,
                    newpassword: newpass
                },
                success: function(data) {
                    switch (data.CODE) {
                        case 702:
                            sAlert("#password-error", true);
                            break;
                        case 703:
                            sAlert("#wrong-password-error", true);
                            break;
                        case 700:
                            sAlert("#password-success", true);
                            $("#pass-form")[0].reset();
                            break;
                    }
                },
                error: function() {
                    sAlert("#net-error", true);
                }
            });
        } else sAlert("#match-password-error", true);
    }
    </script>
<?php
        break;
    case "notifications":
?>
    <h4>Notifications Settings</h4>
<?php
        break;
}
?>
</div>
<?php
} else {
?>
<script>
window.location.href = "https://tras.pw/settings/basic";
</script>
<?php
}
?>
