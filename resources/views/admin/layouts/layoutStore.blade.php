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
    {!! Html::style('assets/plugins/jquery-metrojs/MetroJs.css') !!}
    {!! Html::style('assets/plugins/codrops-dialogFx/dialog.css') !!}
    {!! Html::style('assets/plugins/codrops-dialogFx/dialog-sandra.css') !!}
    {!! Html::style('assets/plugins/owl-carousel/assets/owl.carousel.css') !!}
    {!! Html::style('assets/plugins/jquery-nouislider/jquery.nouislider.css') !!}
    {!! Html::style('pages/css/pages-icons.css') !!}
    {!! Html::style('pages/css/pages.css') !!}
    {!! Html::style('assets/css/style.css') !!}

     
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
    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
       
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        {!! Html::image('assets/img/custom/index.png', 'logo' , array('width'=>'60' )) !!}
         
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 open">
            <a href="/admin/dashboard" class="detailed">
              <span class="title">Dashboard</span>
            </a>
            <span class="icon-thumbnail bg-success"><i class="pg-home"></i></span>
          </li>
          <!-- <li class="">
            <a href="">
              <span class="title">Builder</span>
            </a>
            <span class="icon-thumbnail"><i class="pg-layouts"></i></span>
          </li> -->
          <li class="">
            <a href="javascript:;"><span class="title">Users</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-users"></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="/admin/users/all">All</a>
                <span class="icon-thumbnail">L</span>
              </li>
              <li class="">
                <a href="/admin/users/role/customer">Customers</a>
                <span class="icon-thumbnail">C</span>
              </li>
              <li class="">
                <a href="/admin/users/role/merchant">Merchants</a>
                <span class="icon-thumbnail">M</span>
              </li>
              <li class="">
                <a href="/admin/users/role/admin">Admin</a>
                <span class="icon-thumbnail">A</span>
              </li>
              <li class="">
                <a href="/admin/users/role/superAdmin">Super Admin</a>
                <span class="icon-thumbnail">SA</span>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;"><span class="title">Stores</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-building "></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="/admin/stores/all">All</a>
                <span class="icon-thumbnail">AL</span>
              </li>
               
              <li class="">
                <a href="javascript:;">Category</a>
                <span class="icon-thumbnail">CT</span>
                <ul class="sub-menu">
                  @foreach($headTags as $tag)
                  <li>
                    <a style='text-transform: capitalize;' href="/admin/stores/category/{{ $tag->id }}">{{$tag->title}}</a>
                  </li>
                  @endforeach
                </ul>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;"><span class="title">Offers</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-flag "></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="/admin/offers/today">Active</a>
                <span class="icon-thumbnail">TD</span>
              </li>
              <li class="">
                <a href="/admin/offers/future">Up Comming</a>
                <span class="icon-thumbnail">FU</span>
              </li>
              <li class="">
                <a href="/admin/offers/past">Expired</a>
                <span class="icon-thumbnail">PA</span>
              </li>
              <li class="">
                <a href="/admin/offers/all">All</a>
                <span class="icon-thumbnail">AL</span>
              </li>
               
            </ul>
          </li>
          <li class="">
            <a href="javascript:;"><span class="title">App Contents</span>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-plug"></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="/admin/elements">Elements</a>
                <span class="icon-thumbnail">E</span>
              </li>
               
            </ul>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <!-- LEFT SIDE -->
        <div class="pull-left full-height visible-sm visible-xs">
          <!-- START ACTION BAR -->
          <div class="sm-action-bar">
            <a href="#" class="btn-link toggle-sidebar" data-toggle="sidebar">
              <span class="icon-set menu-hambuger"></span>
            </a>
          </div>
          <!-- END ACTION BAR -->
        </div>
        <!-- RIGHT SIDE -->
        <div class="pull-right full-height visible-sm visible-xs">
          <!-- START ACTION BAR -->
          <div class="sm-action-bar">
            <a href="#" class="btn-link" data-toggle="quickview" data-toggle-element="#quickview">
              <span class="icon-set menu-hambuger-plus"></span>
            </a>
          </div>
          <!-- END ACTION BAR -->
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table">
          <div class="header-inner">
            <div class="brand inline">
                {!! Html::image('assets/img/custom/index.png', 'logo' , array('width'=>'60' )) !!}
             </div>
          </div>
        </div>
         
        <div class=" pull-right">
          <!-- START User Info-->
          <div class="visible-lg visible-md m-t-10">
            <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
              <span class="semi-bold">{{ Auth::user()->name }}</span>
            </div>
            <div class="dropdown pull-right">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                    <img src="{{ URL::to('assets/img/users') }}/{{ Auth::user()->profileImg }}" width='32' height='32'> 
                
                </span>
              </button>
              <ul class="dropdown-menu profile-dropdown" role="menu">
                <!-- <li><a href="#"><i class="pg-settings_small"></i> Settings</a>
                </li> -->
                <li class="bg-master-lighter">
                  <a href="/admin/logout" class="clearfix">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END User Info-->
        </div>
      </div>
      <!-- END HEADER -->


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
    {!! Html::script('assets/plugins/jquery-metrojs/MetroJs.min.js') !!}
    {!! Html::script('assets/plugins/imagesloaded/imagesloaded.pkgd.min.js') !!}
    {!! Html::script('assets/plugins/jquery-isotope/isotope.pkgd.min.js') !!}
    {!! Html::script('assets/plugins/codrops-dialogFx/dialogFx.js') !!}
    {!! Html::script('assets/plugins/owl-carousel/owl.carousel.min.js') !!}
    {!! Html::script('assets/plugins/jquery-nouislider/jquery.nouislider.min.js') !!}
    {!! Html::script('assets/plugins/jquery-nouislider/jquery.liblink.js') !!}   

    
    
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    {!! Html::script('pages/js/pages.min.js') !!} 
    <!-- END CORE TEMPLATE JS -->
    {!! Html::script('assets/js/gallery.js') !!}
    <!-- BEGIN PAGE LEVEL JS -->
    {!! Html::script('assets/js/scripts.js') !!} 
    <!-- END PAGE LEVEL JS -->
    
  </body>
</html>