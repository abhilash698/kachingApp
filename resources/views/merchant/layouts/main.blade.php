<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Merchant - Admin Dashboard</title>
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
    {!! Html::style('assets/css/jquery.datetimepicker.css') !!}
    {!! Html::style('assets/css/merchant.css') !!}
     

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
  @if($is_super)
  <body class='fixed-header menu-pin pace-done'>
  @else
  <body class="fixed-header menu-pin menu-behind">
  @endif


    <div class="se-pre-con"></div>
    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      @if($is_super)
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      <div class="sidebar-overlay-slide from-top" id="appMenu">
        @foreach( $linked as $k => $linkedstore)
        @if ($k % 2 == 0)
        <div class="row">
          <div class="col-xs-12 no-padding padding-5px">
            <div class='child-merchant-wrapper even-merchant'>
              <a href="/merchant/linked/store/offers?id={{$linkedstore['store_id']}}" class="p-l-40">
                <h5 class='store-name'>{{$linkedstore['store_name']}}</h5>
                <p class='store-area'>{{$linkedstore['store_area']}}</p>
                <p class='store-offers'>{{$linkedstore['offers_count']}} Offers</p>
              </a>
            </div>
          </div>
        @if(count($linked) == ($k+1))
        </div>
        @endif
        @else
          <div class="col-xs-12 no-padding padding-5px">
            <div class='child-merchant-wrapper odd-merchant'>
              <a href="#" class="p-l-40">
                <h5 class='store-name'>{{$linkedstore['store_name']}}</h5>
                <p class='store-area'>{{$linkedstore['store_area']}}</p>
                <p class='store-offers'>{{$linkedstore['offers_count']}} Offers</p>
              </a>
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
      @endif
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        @if($is_super)
        <div class="sidebar-header-controls">
          <span class='supermerchant-header'>Super Merchant</span>
          <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
          </button>
        </div>
        @endif
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 ">
            <a href="/merchant/dashboard" class="detailed">
              <span class="title">Dashboard</span>
            </a>
            <span class="icon-thumbnail bg-success"><i class="pg-home"></i></span>
          </li>
          @if($is_super)
          <li>
            <a href="/merchant/linked/offers/all" class="detailed">
              <span class="title">All Offers</span>
            </a>
            <span class="icon-thumbnail"><i class="fa fa-bookmark"></i></span>
          </li>
          @endif
          <li class="">
            <a href="/merchant/store" class="detailed">
              <span class="title">Store Info</span>
            </a>
            <span class="icon-thumbnail "><i class="fa fa-building-o"></i></span>
          </li>

          <li class="">
            <a href="/merchant/profile/edit" class="detailed">
              <span class="title">Profile</span>
            </a>
            <span class="icon-thumbnail "><i class="fa fa-user"></i></span>
          </li>

          <li class="lg-hidden hidden-md hidden-lg">
            <a href="/logout" class="detailed">
              <span class="title">Logout</span>
            </a>
            <span class="icon-thumbnail "><i class="fa fa-user"></i></span>
          </li>
          
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- Modal -->
    <div class="modal fade fill-in" id="modalFillIn" tabindex="-1" role="dialog" aria-hidden="true">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="pg-close"></i>
      </button>
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="text-left p-b-5"><span class="semi-bold">News letter</span> signup</h5>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-9 ">
                <input type="text" placeholder="Your email address here" class="form-control input-lg" id="icon-filter" name="icon-filter">
              </div>
              <div class="col-md-3 no-padding sm-m-t-10 sm-text-center">
                <button type="button" class="btn btn-primary btn-lg btn-large fs-15">Sign up</button>
              </div>
            </div>
            <p class="text-right sm-text-center hinted-text p-t-10 p-r-10">What is it? Terms and conditions</p>
          </div>
          <div class="modal-footer">
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Modal -->
    <div class="modal fade slide-up disable-scroll" id="modalSlideUp" tabindex="-1" role="dialog" aria-hidden="false">
      <div class="modal-dialog ">
        <div class="modal-content-wrapper">
          <div class="modal-content">
            <div class="loading-spiner-holder loading-add" ><div class="loading-spiner"><img src="/assets/img/custom/loader.gif" /></div></div>
            <div class="modal-header clearfix text-left">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
              </button>
              <h5>Add <span class="semi-bold">Offer</span></h5>
              <p style='color:red; ' id='errorMsgAdd'></p>
            </div>
            <div class="modal-body">
              <form role="form" name="offerForm" >
                <div class="form-group-attached">
                  @if($is_super)
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default form-group-default-select2 required">
                        <label class="">Select Merchant</label>
                        <select class="full-width" name='store_token' data-placeholder="Select Merchant" data-init-plugin="select2" required>
                          <option value='' selected>My Store Only</option>
                          <option value='all'>All Stores</option>
                          @foreach($linked as $linkedstore)
                          <option value="{{$linkedstore['store_id']}}">{{$linkedstore['store_name'].', '.$linkedstore['store_area']}}</option>
                          @endforeach
                        </select>
                      </div>
                       
                    </div>
                  </div>
                  @endif
                  <div class="row">
                    <div class="col-sm-12">
                      <input type="hidden" name="token" value="{{ csrf_token() }}">
                      <div class="form-group form-group-default">
                        <label>Offer Title </label>
                        <input type="text" name="title" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group form-group-default">
                        <label>Start Time</label>
                        <input type="text"  name="startDate" class="form-control datetimepicker" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group form-group-default">
                        <label>End Time </label>
                        <input type="text" name="endDate" class="form-control datetimepicker" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Fineprint </label>
                        <textarea name='fineprint' style="width:100%; height: 100px;" required></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="row"> 
                <div class="col-sm-2 col-sm-offset-10 m-t-10 sm-m-t-10">
                  <button type="button" id='submitAdd' class="btn btn-primary btn-block m-t-5">Add</button>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
    <!-- /.modal-dialog -->
    <!-- MODAL SLIDE UP SMALL  -->
    <!-- Modal -->
    <div class="modal fade slide-up disable-scroll" id="modalSlideUpSmall" tabindex="-1" role="dialog" aria-hidden="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
          <div class="modal-content">
            <div class="modal-body text-center m-t-20">
              <h4 class="no-margin p-b-10"> @if($is_super) This is child offer. Try editing parent offer. @else You cannot edit this offer. Belongs to supermerchant. @endif</h4>
              <button type="button" class="btn btn-primary btn-cons" data-dismiss="modal">Continue</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
    <!-- /.modal-dialog -->
    <!-- MODAL STICK UP  -->
    <div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="loading-spiner-holder loading"><div class="loading-spiner"><img src="/assets/img/custom/loader.gif" /></div></div>
          <div class="modal-header clearfix text-left">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
            </button>
            <h5>Edit <span class="semi-bold">Offer</span></h5>
            <p style='color:red; ' id='errorMsg'></p>
          </div>
          <div class="modal-body">
            <form role="form" name="editOfferForm">
              <input type="hidden" name="token" value="{{ csrf_token() }}" >
              <input type="hidden" name="offer_id" >
              <div class="form-group-attached">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group form-group-default">
                      <label>Offer Title</label>
                      <input type="text" name="title" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group form-group-default">
                      <label>Start Time</label>
                      <input type="text" class="form-control datetimepicker" name='startDate' required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group form-group-default">
                      <label>End Time</label>
                      <input type="text" class="form-control datetimepicker" name='endDate' required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group form-group-default">
                      <label>Fineprint</label>
                      <textarea name='fineprint' style="width:100%; height: 100px;" name='fineprint' required></textarea>
                    </div>
                  </div>
                </div>
              </div>
            <div class="row">
              <div class="col-sm-3 col-sm-offset-9 m-t-10 sm-m-t-10">
                <button type="button" id='submitEdit' class="btn btn-primary btn-block m-t-5">Update</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- END MODAL STICK UP  -->
    <!-- MODAL STICK UP SMALL ALERT -->
    <div class="modal fade stick-up" id="modalStickUpSmall" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
          <div class="modal-content">
            <div class="loading-spiner-holder loading-changeMobile"><div class="loading-spiner"><img src="/assets/img/custom/loader.gif" /></div></div>
            <div class="modal-header clearfix text-left">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
              </button>
              <h5>Change Mobile</h5>
              <br>
            </div>
            <div class="modal-body">
              <input type="hidden" id='token-change' name="token" value="{{ csrf_token() }}" >
              <div class="form-group form-group-default mobile">
                <label>New Mobile Number <span class='error-msg' id='mobile-error-msg'></span></label>
                <input type="text" id='mobile-change' class="form-control" name="mobile" required>
              </div>
              <div class="form-group form-group-default otp">
                <label> Enter OTP <span class='error-msg' id='otp-error-msg'></span></label>
                <input type="text" id='otp-change' class="form-control" name="mobile" required>
              </div>
              <div class='update-msg'>
                <h3>Mobile number has been changed.</h3>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary btn-cons  pull-right" id='change-mobile-btn'>Continue</button>
              <button type="button" class="btn btn-primary btn-cons  pull-right " id='verify-mobile-btn'>Verify</button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- END MODAL STICK UP SMALL ALERT -->
    <!-- MODAL STICK UP SMALL ALERT -->
    <div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
            </button>
            <div class="container-xs-height full-height">
              <div class="row-xs-height">
                <div class="modal-body col-xs-height col-middle text-center   ">
                  <h5 class="text-primary ">Before you <span class="semi-bold">proceed</span>, Are you sure you want to disable this offer?</h5>
                  <br>
                  <input type='hidden' value='' name='deleteId' >
                  <input type='hidden' value='{{ csrf_token() }}' name='token' >
                  <button type="button" class="btn btn-primary btn-block" id='disable' >Continue</button>
                  <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- END MODAL STICK UP SMALL ALERT -->
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
             
          </div>
          <!-- END ACTION BAR -->
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table">
          <div class="header-inner ">
            <div class="brand inline pull-right">
              {!! Html::image('assets/img/custom/index.png', 'logo' , array('width'=>'60' )) !!}  
            </div>
            <!-- START NOTIFICATION LIST -->
            <ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-20 p-r-30">
               <h5>Kaching Merchant Admin</h5> </div>
            </ul>
            <!-- END NOTIFICATIONS LIST -->
        </div>
        
        <div class=" pull-right p-r-20">
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
                <li><a href="/merchant/profile/edit"><i class="pg-settings_small"></i> Profile</a>
                </li>
                <li><a href="/merchant/about"><i class="pg-outdent"></i> about</a>
                </li>
                <li><a href="/merchant/support"><i class="pg-signals"></i> service</a>
                </li>
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

      @yield('content')




      </div>
    <!-- END PAGE CONTAINER -->
     
    <!-- START OVERLAY -->
    <div class="overlay hide" data-pages="search">
      <!-- BEGIN Overlay Content !-->
      <div class="overlay-content has-results m-t-20">
        <!-- BEGIN Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Logo !-->
          <img class="overlay-brand" src="/assets/img/logo.png" alt="logo" data-src="/assets/img/logo.png" data-src-retina="/assets/img/logo_2x.png" width="78" height="22">
          <!-- END Overlay Logo !-->
          <!-- BEGIN Overlay Close !-->
          <a href="#" class="close-icon-light overlay-close text-black fs-16">
            <i class="pg-close"></i>
          </a>
          <!-- END Overlay Close !-->
        </div>
        <!-- END Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Controls !-->
          <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
          <br>
          <div class="inline-block">
            <div class="checkbox right">
              <input id="checkboxn" type="checkbox" value="1" checked="checked">
              <label for="checkboxn"><i class="fa fa-search"></i> Search within page</label>
            </div>
          </div>
          <div class="inline-block m-l-10">
            <p class="fs-13">Press enter to search</p>
          </div>
          <!-- END Overlay Controls !-->
        </div>
        <!-- BEGIN Overlay Search Results, This part is for demo purpose, you can add anything you like !-->
        <div class="container-fluid">
          <span>
                <strong>suggestions :</strong>
            </span>
          <span id="overlay-suggestions"></span>
          <br>
          <div class="search-results m-t-40">
            <p class="bold">Pages Search Results</p>
            <div class="row">
              <div class="col-md-6">
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div>
                      <img width="50" height="50" src="/assets/img/profiles/avatar.jpg" data-src="/assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on pages</h5>
                    <p class="hint-text">via john smith</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div>T</div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> related topics</h5>
                    <p class="hint-text">via pages</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div><i class="fa fa-headphones large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> music</h5>
                    <p class="hint-text">via pagesmix</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
              </div>
              <div class="col-md-6">
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-info text-white inline m-t-10">
                    <div><i class="fa fa-facebook large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name">ice cream</span> on facebook</h5>
                    <p class="hint-text">via facebook</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular bg-complete text-white inline m-t-10">
                    <div><i class="fa fa-twitter large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5">Tweats on<span class="semi-bold result-name"> ice cream</span></h5>
                    <p class="hint-text">via twitter</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
                <!-- BEGIN Search Result Item !-->
                <div class="">
                  <!-- BEGIN Search Result Item Thumbnail !-->
                  <div class="thumbnail-wrapper d48 circular text-white bg-danger inline m-t-10">
                    <div><i class="fa fa-google-plus large-text "></i>
                    </div>
                  </div>
                  <!-- END Search Result Item Thumbnail !-->
                  <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5">Circles on<span class="semi-bold result-name"> ice cream</span></h5>
                    <p class="hint-text">via google plus</p>
                  </div>
                </div>
                <!-- END Search Result Item !-->
              </div>
            </div>
          </div>
        </div>
        <!-- END Overlay Search Results !-->
      </div>
      <!-- END Overlay Content !-->
    </div>
    <!-- END OVERLAY -->
    <!-- BEGIN VENDOR JS -->

    {!! Html::script('assets/plugins/jquery/jquery-1.11.1.min.js') !!} 
    {!! Html::script('assets/plugins/jquery-ui/jquery-ui.min.js') !!} 
    {!! Html::script('assets/plugins/pace/pace.min.js') !!} 
    
    {!! Html::script('assets/plugins/modernizr.custom.js') !!} 
    
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
    
    
    
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    {!! Html::script('pages/js/pages.min.js') !!} 
    {!! Html::script('assets/js/demo.js') !!} 
    {!! Html::script('assets/js/jquery.flip.min.js') !!}

    {!! Html::script('assets/js/jquery.datetimepicker.full.min.js') !!} 
    <!-- END CORE TEMPLATE JS -->
   <!--  {!! Html::script('assets/js/gallery.js') !!} -->
    <!-- BEGIN PAGE LEVEL JS -->
    {!! Html::script('assets/js/scripts.js') !!} 
   

    <script type="text/javascript">
      $(function() {
        $('.datetimepicker').datetimepicker({
          format:'Y-m-d H:i'
        });
      });

      $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
      });

      $(function() {
        // with vanilla JS!
        Ps.initialize(document.getElementById('appMenu'));
    });
    </script>

    {!! Html::script('assets/js/custom.js') !!} 

    <!-- END PAGE LEVEL JS -->
    <!-- END VENDOR JS -->

    
    
  </body>
</html>