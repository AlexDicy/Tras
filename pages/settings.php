<?php
$active = array('basic', 'password', 'notifications');
if (isset($path[1])) {
    if (in_array($path[1], $active)) {
        $active[$path[1]] = " active";
?>
<div class="col-md-2">
    <div class="list-group">
        <a href="https://tras.pw/settings/basic" class="list-group-item<?php echo $active['basic'] ?>">Basic Info</a>
 		<a href="https://tras.pw/settings/password" class="list-group-item<?php echo $active['password'] ?>">Password</a>
 		<a href="https://tras.pw/settings/notifications" class="list-group-item<?php echo $active['notifications'] ?>">Notifications</a>
    </div>
</div>
<div class="col-md-10">
<?php
switch ($path[1]) {
    case "basic":
?>
    <h4>Basic Info</h4>
    <p>Avatar</p>
    <img style="border-radius: 4px;" class="mb img-responsive thumb64" src="<?php echo $_SESSION['info']['Avatar'] ?>">
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
        <link type="text/css" rel="stylesheet" href="https://tras.pw/fileinput/fileinput.min.css">
        <link type="text/css" rel="stylesheet" href="https://tras.pw/assets/styles/croppie.css">
        <script src="https://tras.pw/js/croppie.min.js"></script>
        <script src="https://tras.pw/fileinput/fileinput.min.js"></script>
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
        function l(t) {console.log(t)}
        $("#image-upload-button").on('click', function() {
            $("#image-resize").croppie('result', 'rawcanvas').then(function(canvas) {
                var dataUrl = canvas.toDataURL();
                $("#image-resize").croppie('destroy');
                $("#image-resize-container").hide();
                $("#image-uploading").fadeIn();
                $.ajax({
                    url: "https://tras.pw/uploadavatar.php",
                    type: "POST",
                    data: {image: dataUrl},
                    dataType: "json",
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (event) {
                            if (event.lengthComputable) {
                                var pc = event.loaded / event.total;
                                $("#upload-progress-bar").css("width", Math.round(pc * 100) + "%");
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(data) {
                        $("#image-uploading").fadeOut();
                        if (data.status == 200) {          
                            $("#uploaded").fadeIn("fast", function() {$("#uploaded").show()});
                        } else {
                            var ue = $("#uploaderror");
                            $("#p-u-e").text(data.error);
                            ue.fadeIn('slow', function(){setTimeout(function(){ue.fadeOut()},2000)})
                        }
                    },
                    error: function(){l("error")}
                });
            });
        });
        </script>
    </div>
<?php
        break;
    case "password":
?>
    <h4>Change password</h4>
<?php
        break;
    case "notifications":
?>
    <h4>Notifications settigns</h4>
<?php
        break;
}
?>
</div>
<?php
    }
} else {
?>
<script>
window.location.href = "https://tras.pw/settings/basic";
</script>
<?php
}
?>