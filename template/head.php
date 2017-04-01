    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="<?php echo getDescription(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick"), Shared::get("description")) ?>">
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@TrasGames">
    <meta name="twitter:title" content="<?php echo getTitle(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick")) ?>">
    <meta name="twitter:description" content="<?php echo getDescription(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick"), Shared::get("description")) ?>">
    <meta name="twitter:creator" content="@TrasGames">
    <meta property="og:title" content="<?php echo getTitle(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick")) ?>">
    <meta property="og:description" content="<?php echo getDescription(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick"), Shared::get("description")) ?>">
    <meta property="og:url" content="<?php echo "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="https://<?php echo Shared::get("host") ?>/images/logo-blue-background.png">
    <meta property="og:image:width" content="1440">
    <meta property="og:image:height" content="891">
    <meta property="og:type" content="website">
    <meta property="fb:app_id" content="198347767255916">
    <meta name="theme-color" content="#43a8eb">
    <title><?php echo Shared::getTitle(Shared::get("name"), Shared::get("link"), Shared::get("path"), Shared::get("infoNick")) ?></title>
    <link id="favicon" rel="icon" type="image/png" href="/images/logo-128.png" sizes="128x128">
    <link id="favicon" rel="icon" type="image/png" href="/images/logo-min-512.png" sizes="512x512">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="//<?php echo Shared::get("host") ?>/assets/styles/tras.css?v162">
    <link type="text/css" rel="stylesheet" href="//<?php echo Shared::get("host") ?>/assets/styles/md.css?v52">
    <link type="text/css" rel="stylesheet" href="//<?php echo Shared::get("host") ?>/assets/styles/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="//<?php echo Shared::get("host") ?>/assets/styles/feather.css">
    <link rel="manifest" href="/manifest.json">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <style type="text/css">
        @charset "UTF-8";
        [ng\:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak,
        .ng-hide:not(.ng-hide-animate) {
            display: none !important;
        }
        ng\:form {
            display: block;
        }
        .ng-animate-shim {
            visibility: hidden;
        }
        .ng-anchor {
            position: absolute;
        }
    </style>
    <style type="text/css">
        .jqstooltip {
            position: absolute;
            left: 0px;
            top: 0px;
            visibility: hidden;
            background: rgb(0, 0, 0) transparent;
            background-color: rgba(0, 0, 0, 0.6);
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
            color: white;
            font: 10px arial, san serif;
            text-align: left;
            white-space: nowrap;
            padding: 5px;
            border: 1px solid white;
            z-index: 10000;
        }
        .jqsfield {
            color: white;
            font: 10px arial, san serif;
            text-align: left;
        }
    </style>