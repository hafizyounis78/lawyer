<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>نظام ادارة مكتب المحامي</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Preview page of Metronic Admin Theme #2 for " name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('')}}/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('')}}/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{url('')}}/assets/pages/css/login-4-rtl.min.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
    <style>
        .login {
            background-color: #d4d0d0 !important;
        }
        @font-face {
            font-family: "helveticaneuelt";
            src: url("{{url('')}}/public/font/helveticaneueltarabic-roman-42.ttf") ;
        }

        body, h1, h2, h3, h4, h5, h6 {
            font-family: "helveticaneuelt" !important;
            direction: rtl;
        }

    </style>
</head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="{{url('')}}/assets/pages/img/logo.png" alt="" width="12%"/> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    @if($errors->any())
        <div class="alert alert-danger ">
            <button class="close " data-close="alert"></button>
            <h4 class="font-dark">{{$errors->first()}}</h4>
        </div>
    @endif
    <!-- BEGIN LOGIN FORM -->
    {{--<form class="login-form" action="{{ route('login') }}" method="post">--}}
    {{Form::open(['method'=>'POST','url'=>url('login'),'class'=>'login-form'])}}
    <h3 class="form-title font-green">الدخول</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>الرجاء ادخال بريد إلكتروني وكلمة مرور صحيحة. </span>
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">البريد الإلكتروني</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off"
               placeholder="Email" name="email"/></div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">كلمة المرور</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
               placeholder="Password" name="password"/></div>
    <div class="form-actions">
        <button type="submit" class="btn green uppercase">الدخول</button>
        <label class="rememberme check mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="remember" value="1"/>تذكرني
            <span></span>
        </label>

    </div>


{{Form::close()}}
<!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->

    <!-- END FORGOT PASSWORD FORM -->

</div>
<div class="copyright"> 2018 © Lawyer.</div>
<!--[if lt IE 9]>
<script src="{{url('')}}/assets/global/plugins/respond.min.js"></script>
<script src="{{url('')}}/assets/global/plugins/excanvas.min.js"></script>
<script src="{{url('')}}/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{url('')}}/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js"
        type="text/javascript"></script>
<script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{url('')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('')}}/assets/pages/scripts/login.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
