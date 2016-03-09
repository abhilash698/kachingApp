@extends('merchant.layouts.main')

@section('content')
<!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <div class="content">
          <!-- START PAGE COVER -->
          <div class="jumbotron page-cover" data-pages="parallax">
            <div class="container-fluid container-fixed-lg">
              <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <li>
                    <a href="/merchant/dashboard">Dashboard</a>
                  </li>
                  <li>
                    <a href="">Store</a>
                  </li>
                </ul>
                <!-- END BREADCRUMB -->
                <div class="container-md-height m-b-20">
                  <div class="row row-md-height">
                    <div class="col-lg-7 col-md-6 col-md-height col-middle bg-white">
                      <!-- START PANEL -->
                      <div class="full-height">
                        <div class="panel-body text-center">
                          <img class="image-responsive-height demo-mw-500" src="{{  url('assets/img/stores/') }}/{{ $store->logoUrl }}" alt="">
                        </div>
                      </div>
                      <!-- END PANEL -->
                    </div>
                    <div class="col-lg-5 col-md-height col-md-6 col-top">
                      <!-- START PANEL -->
                      <div class="panel panel-transparent">
                        <div class="panel-heading">
                          <div class="panel-title">Store Details
                          </div>
                        </div>
                        <div class="panel-body">
                          <h3>{{ $store->store_name }}</h3>
                          <p>{{  $store->description }}</p>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Contact </span>
                            </div>
                            <div class="col-xs-6 text-right">+91 {{ $store->Merchant->mobile }} / {{ $store->landline }}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Email</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->Merchant->email}}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Cost for Two</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->cost_two}}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Store Address</span>
                            </div>
                            <div class="col-xs-6 text-right">@if(isset($store->Address)){{ $store->Address->street.', '.$store->Address->City->title }}@endif</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Created Time</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->created_at }}</div>
                          </div>
                          <br>
                          <a href="/merchant/store/edit" style='float:right;'><button class="btn btn-primary buy-now">Edit</button></a>
                          
                        </div>
                      </div>
                      <!-- END PANEL -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END PAGE COVER -->
          <br>
        </div>
       <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright © 2014 </span>
              <span class="font-montserrat">Kaching</span>.
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

@endsection

