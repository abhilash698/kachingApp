@extends('admin.layouts.layoutStore')

@section('content')
<!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
      <!-- START PAGE CONTENT -->
        <div class="content">
          <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <!-- START CATEGORY -->
            <div class="gallery">
              <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <li>
                    <a href="/admin/dashboard">Dashboard</a>
                  </li>
                  <li><a href="#" class="active">Stores</a>
                  </li>
                </ul>
                <!-- END BREADCRUMB -->
              <div class="gallery-filters ">
                  <div class="pull-right">
                    <div class="col-xs-4">
                      <form method='get' action='/admin/search/stores' class='m-t-10'>
                        <input type="text" id="search-user" name='q' class="form-control pull-right" placeholder="Search">
                      </form>
                    </div>
                    <div class="col-xs-8">
                      <div class="btn-toolbar m-t-10" role="toolbar">
                        <div class="btn-group">
                          <a href="/admin/stores/all"><button type="button" class="btn btn-default">All</button></a>
                          <a href="/admin/stores/active"><button type="button" class="btn btn-default">Active</button></a>
                          <a href="/admin/stores/inactive"><button type="button" class="btn btn-default">InActive</button></a>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <!-- START GALLERY ITEM -->
              <!-- 
                    FOR DEMO PURPOSES, FIRST GALLERY ITEM (.first) IS HIDDEN 
                    FOR SCREENS <920px. PLEASE REMOVE THE CLASS 'first' WHEN YOU IMPLEMENT 
                -->


              @foreach ($stores as $store)
              <div class="gallery-item" data-width="1" data-height="1">
                <input type='hidden' value='{{ $store->id }}' >
                <!-- START PREVIEW -->
                 <img class='image-responsive-height' src= '{{  url('assets/img/stores/') }}/{{ $store->logoUrl }}' />
                <!-- END PREVIEW -->
                <!-- START ITEM OVERLAY DESCRIPTION -->
                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info ">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <h4 class="pull-left bold text-white " style='line-height:28px; margin:0px;'> {{ $store->store_name }} </h4>
                        <div class="clearfix"></div>
                      </div>
                      <div class="" style='margin:0px 0px 50px 0px;'>
                        <h4 class="pull-left bold text-white fs-14  p-t-10" style='line-height:normal;'>
                          @foreach ($store->tags as $tag)
                          <span style='background-color:#0D6185; padding:4px; margin-right:4px;'>{{ $tag->title }} </span>
                          @endforeach
                        </h4>
                        <div class="clearfix"></div>
                      </div>
                      <div class="m-t-10">
                        <div class="thumbnail-wrapper d32 circular m-t-5">
                          <img alt="Profile Image" width="40" height="40" data-src-retina="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}" data-src="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}" src="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}">
                        </div>
                        <div class="inline m-l-10">
                          <p class="no-margin text-white fs-12">{{ $store->merchant->name }}</p>
                          <p class="no-margin text-white fs-12">{{ $store->status ? 'Active':'InActive' }}</p>
                        </div>
                         
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
              </div>
              <!-- END GALLERY ITEM -->
              @endforeach

            </div>
            <!-- END CATEGORY -->
            {!! $stores->render() !!}
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright © 2014 </span>
              <span class="font-montserrat">Peach Studio</span>.
              <span class="hint-text">All rights reserved. </span>
              <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a></span>
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
              <a href="#">Hand-crafted</a> <span class="hint-text">&amp; Made with Love ®</span>
            </p>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->

      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->

     @foreach ($stores as $store)
      <!-- START DIALOG -->
    <div id="itemDetails{{$store->id}}" class="dialog item-details">
      <div class="dialog__overlay"></div>
      <div class="dialog__content">
        <div class="container-fluid">
          <div class="row dialog__overview">
            <div class="col-sm-7 no-padding item-slideshow-wrapper full-height">
              <div class="item-slideshow full-height">
                <div class="slide" data-image="{{  url('assets/img/stores/') }}/{{ $store->logoUrl }}">
                </div>
                
              </div>
            </div>
            <div class="col-sm-5 p-r-35 p-t-35 p-l-35 full-height item-description">
              <h2 class="semi-bold no-margin font-montserrat">{{ $store->store_name }}</h2>
              <p class="fs-13">{{ $store->description }}.
              </p>
              <div class="row m-b-20 m-t-20">
                <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Numer</span>
                </div>
                <div class="col-xs-6 text-right">+91 {{ $store->merchant->mobile}}</div>
              </div>
              <div class="row m-b-20 m-t-20">
                <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Email</span>
                </div>
                <div class="col-xs-6 text-right">{{ $store->merchant->email}}</div>
              </div>
              <div class="row m-b-20 m-t-20">
                <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Cost for Two</span>
                </div>
                <div class="col-xs-6 text-right">{{ $store->cost_two}}</div>
              </div>
              <div class="row m-b-20 m-t-20">
                <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Store Address</span>
                </div>
                <div class="col-xs-6 text-right">{{ $store->address->street.', '.$store->address->city->title }}</div>
              </div>
              <div class="row m-b-20 m-t-20">
                <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Created Time</span>
                </div>
                <div class="col-xs-6 text-right">{{ $store->created_at }}</div>
              </div>
              
              <br>
              <a href="/admin/store/{{ $store->id }}/addoffer"><button class="btn btn-primary add-now">Add Offer</button></a>
              <a href="/admin/store/{{ $store->id }}/edit"><button class="btn btn-primary buy-now">Edit</button></a>
            </div>
          </div>
          <div class="row dialog__footer bg-info-dark hidden-xs">
            <div class="col-sm-7 full-height separator">
              <div class="container-xs-height">
                <div class="row row-xs-height">
                  
                  <div class="col-xs-7 col-xs-height col-middle no-padding">
                    <div class="thumbnail-wrapper d48 circular inline">
                      <img alt="Profile Image" width="33" height="33" data-src-retina="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}" data-src="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}" src="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}">
                    </div>
                    <a href="/admin/user/{{$store->merchant->id}}">
                    <div class="inline m-l-15">
                      <p class="text-white no-margin"> {{ $store->merchant->name }}</p>
                      <p class="hint-text text-white no-margin fs-12">{{$store->status ? 'Active':'InActive'}}</p>
                    </div>
                    </a>
                  </div>
                  
                  <div class="col-xs-5 col-xs-height col-middle text-right  no-padding">
                    <a href="/admin/store/{{ $store->id }}/offers/all"><h2 class="bold text-white price font-montserrat"><small>OFFERS</small> {{ $store->offers->count() }}</h2></a>
                  </div>
                </div>
              </div>
            </div>
             
          </div>
        </div>
        <button class="close action top-right" data-dialog-close><i class="pg-close fs-14"></i>
        </button>
      </div>
    </div>
    <!-- END DIALOG -->
    @endforeach
    
@endsection