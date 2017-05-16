<?php
if (!Shared::has("description")) Shared::set("description", Shared::getDescription(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick"), Shared::get("description")));
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="<?= Shared::get("description") ?>">
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@TrasGames">
    <meta name="twitter:title" content="<?= getTitle(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick")) ?>">
    <meta name="twitter:description" content="<?= Shared::get("description") ?>">
    <meta name="twitter:creator" content="@TrasGames">
    <meta property="og:title" content="<?= getTitle(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick")) ?>">
    <meta property="og:description" content="<?= Shared::get("description") ?>">
    <meta property="og:url" content="<?= "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="https://<?= Shared::get("host") ?>/images/logo-blue-background.png">
    <meta property="og:image:width" content="1440">
    <meta property="og:image:height" content="891">
    <meta property="og:type" content="website">
    <meta property="fb:app_id" content="198347767255916">
    <meta name="theme-color" content="#43a8eb">
    <title><?= Shared::getTitle(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick")) ?></title>
    <link id="favicon" rel="icon" type="image/png" href="/images/logo-128.png" sizes="128x128">
    <link id="favicon" rel="icon" type="image/png" href="/images/logo-min-512.png" sizes="512x512">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="//<?= Shared::get("host") ?>/assets/styles/base.css?v2">
    <link type="text/css" rel="stylesheet" href="//<?= Shared::get("host") ?>/assets/styles/md.css?v52">
    <link type="text/css" rel="stylesheet" href="//<?= Shared::get("host") ?>/assets/styles/tras.css?v4">
    <link type="text/css" rel="stylesheet" href="//<?= Shared::get("host") ?>/assets/styles/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="//<?= Shared::get("host") ?>/assets/styles/feather.css">
    <link rel="manifest" href="/manifest.json">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>