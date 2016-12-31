<?php
require_once 'session.php';
reloadInfo();
?>
<!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9" lang="en" data-ng-app="singular"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" data-ng-app="singular">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{app.description}}">
    <title data-ng-bind="pageTitle()">Tras - Dashboard</title>
    <!-- App CSS-->
    <link rel="stylesheet" href="t/css/app.css?v6" data-ng-if="!app.layout.isRTL">
    <link rel="stylesheet" href="t/css/apprtl.css" data-ng-if="app.layout.isRTL">
</head>

<body data-ng-class="{ 'layout-fixed' : app.layout.isFixed, 'aside-collapsed' : app.sidebar.isCollapsed, 'layout-boxed' : app.layout.isBoxed, 'aside-slide' : app.sidebar.slide, 'in-app': $state.includes('app')}">
    <noscript><!--noindex--><!--googleoff: index--><div style="text-align: center;padding-top:13%;" class="robots-nocontent"><h1>Sorry, Javascript is not enabled...</h1><h3><a target="_blank" href="http://enable-javascript.com/">Enable it</a></h3></div><!--googleon: index--><!--/noindex--></noscript>
    <div data-ui-view="" data-autoscroll="false" data-ng-class="app.viewAnimation" class="app-container"></div>
    <!-- App Scripts-->
    <script src="t/js/base.js"></script>
    <script src="t/js/app.js?v6"></script>
</body>

</html>