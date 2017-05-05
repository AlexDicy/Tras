<?php
$sent = empty($_POST['to']);
$title = $sent ? "Send email from info@tras.pw" : "Email sent, send another";
$to = $sent ? "" : $_POST['to'];
$subject = $sent ? "Informations" : $_POST['subject'];
$preheader = $sent ? "We inform you that..." : $_POST['preheader'];
$body = $sent ? "" : $_POST['body'];
require_once('session.php');
reloadInfo();
if (!$sent &&  Shared::$USERDATA['info']['id'] == 6) {
    sendMail($subject, nl2br(htmlentities($body)), $to, $preheader);
} else if (!$sent) $title = "ADMIN NOT LOGGED IN, Email not sent";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send email from Tras</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="//tras.pw/assets/styles/tras.css?v148">
    <link type="text/css" rel="stylesheet" href="//tras.pw/assets/styles/md.css?v50">
    <link type="text/css" rel="stylesheet" href="//tras.pw/assets/styles/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="//tras.pw/assets/styles/feather.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
</head>
<body>
    <div class="container">
        <h2><?php echo htmlentities($title) ?></h2>
        <form action="sendmail.php" method="post">
            <div class="form-group">
                <label for="to">To</label>
                <input class="form-control" type="text" id="to" name="to" value="<?php echo htmlentities($to) ?>">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input class="form-control" type="text" id="subject" name="subject" value="<?php echo htmlentities($subject) ?>">
            </div>
            <div class="form-group">
                <label for="preheader">Preheader</label>
                <input class="form-control" type="text" id="preheader" name="preheader" value="<?php echo htmlentities($preheader) ?>">
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" type="text" id="body" name="body"><?php echo htmlentities($body) ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Send</button>
        </form>
    </div>
</body>
</html>