<!DOCTYPE html>
<html>
  <head>
    @include('admin.layouts.includes.header')
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
          <li>
            <a href="/admin/addSuperMerchant" class="detailed">
              <span class="super">Add Super Merchant</span>
            </a>
            <span class="icon-thumbnail"><i class="fa fa-user-secret"></i></span>
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
            <!-- <a href="#" class="search-link" data-toggle="search"><i class="pg-search"></i>Type anywhere to <span class="bold">search</span></a>  -->
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
                  <a href="/logout" class="clearfix">
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
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">



    @yield('content')

    @include('admin.layouts.includes.footer')
    
  </body>
</html>