<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Kaching - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />

    {!! Html::style('assets/plugins/pace/pace-theme-flash.css') !!}
    {!! Html::style('assets/plugins/boostrapv3/css/bootstrap.min.css') !!}
    {!! Html::style('assets/plugins/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('assets/plugins/jquery-scrollbar/jquery.scrollbar.css') !!}
    {!! Html::style('assets/plugins/bootstrap-select2/select2.css') !!}
    {!! Html::style('assets/plugins/switchery/css/switchery.min.css') !!}
    {!! Html::style('pages/css/pages-icons.css') !!}
    {!! Html::style('pages/css/pages.css') !!}
     
    <!--[if lte IE 9]>
        <link href="pages/css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
    </script>
  </head>
  <body class="fixed-header   ">

    @yield('content')

    <!-- END OVERLAY -->
    <!-- BEGIN VENDOR JS -->
    {!! Html::script('assets/plugins/pace/pace.min.js') !!} 
    {!! Html::script('assets/plugins/jquery/jquery-1.11.1.min.js') !!} 
    {!! Html::script('assets/plugins/modernizr.custom.js') !!} 
    {!! Html::script('assets/plugins/jquery-ui/jquery-ui.min.js') !!} 
    {!! Html::script('assets/plugins/boostrapv3/js/bootstrap.min.js') !!} 
    {!! Html::script('assets/plugins/jquery/jquery-easy.js') !!} 
    {!! Html::script('assets/plugins/jquery-unveil/jquery.unveil.min.js') !!} 
    {!! Html::script('assets/plugins/jquery-bez/jquery.bez.min.js') !!} 
    {!! Html::script('assets/plugins/jquery-ios-list/jquery.ioslist.min.js') !!} 
    {!! Html::script('assets/plugins/jquery-actual/jquery.actual.min.js') !!} 
    {!! Html::script('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') !!} 
    {!! Html::script('assets/plugins/bootstrap-select2/select2.min.js') !!}
    {!! Html::script('assets/plugins/classie/classie.js') !!}  
    {!! Html::script('assets/plugins/switchery/js/switchery.min.js') !!} 
    {!! Html::script('assets/plugins/jquery-validation/js/jquery.validate.min.js') !!} 
    
    
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    {!! Html::script('pages/js/pages.min.js') !!} 
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    {!! Html::script('assets/js/scripts.js') !!} 
    <!-- END PAGE LEVEL JS -->
    <script>
    $(function()
    {
      $('#form-register').validate()
    })
    </script>
  </body>
</html>