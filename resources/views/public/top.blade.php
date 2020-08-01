<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>Mstore - Online Shop Mobile Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">
    {{--调用自己需要加,调用api不需要--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/static/css/materialize.css">
    <link rel="stylesheet" href="/static/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/normalize.css">
    <link rel="stylesheet" href="/static/css/owl.carousel.css">
    <link rel="stylesheet" href="/static/css/owl.theme.css">
    <link rel="stylesheet" href="/static/css/owl.transitions.css">
    <link rel="stylesheet" href="/static/css/fakeLoader.css">
    <link rel="stylesheet" href="/static/css/animate.css">
    <link rel="stylesheet" href="/static/css/style.css">

    <link rel="shortcut icon" href="/static/img/favicon.png">

</head>
<body>

<!-- navbar top -->
<div class="navbar-top">
    <!-- site brand	 -->
    <div class="site-brand">
        <a href="index.html"><h1>Mstore</h1></a>
    </div>
    <!-- end site brand	 -->
    <div class="side-nav-panel-right">
        <a href="#" data-activates="slide-out-right" class="side-nav-left"><i class="fa fa-user"></i></a>
    </div>
</div>
<!-- end navbar top -->