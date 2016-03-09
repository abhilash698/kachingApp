@extends('merchant.layouts.main')

@section('content')
<!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <br>
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg bg-white" style='min-height:500px;'>
            <div class="panel panel-transparent">
              <div class="panel-heading">
                <div class="panel-title">
                </div>
                <div class="pull-right">
                  <div class='col-xs-4 col-xs-offset-2'><a href="" data-target="#modalSlideUp" data-toggle="modal" ><button class="btn btn-primary" >Add Offer</button></a></div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class='col-sm-5'>
                    <h1> User Profile </h1><br>
                    <div class='col-sm-3'>
                      Name :
                    </div>
                    <div class='col-sm-9'>
                      {{ $user->name}}
                    </div><br><br>
                    <div class='col-sm-3'>
                      Email :
                    </div>
                    <div class='col-sm-9'>
                      {{ $user->email}}
                    </div><br><br>
                    <div class='col-sm-3'>
                      Mobile :
                    </div>
                    <div class='col-sm-9'>
                      {{ $user->mobile}}
                    </div><br><br>
                  </div>
                  <div class='col-sm-6'>
                    <h1> Store Information </h1>
                    <div class='col-sm-6'>
                      <img src="/assets/img/stores/{{ $user->Stores->logoUrl }}">
                    </div>
                    <div class='col-sm-6'>
                      {{ $user->name}}
                    </div>
                    <div class='col-sm-6'>
                      Email 
                    </div>
                    <div class='col-sm-6'>
                      {{ $user->email}}
                    </div>
                    <div class='col-sm-6'>
                      Mobile 
                    </div>
                    <div class='col-sm-6'>
                      {{ $user->mobile}}
                    </div>
                  </div>
                  
                </div>
                <!-- ROW END -->
              </div>
              <!-- END PANEL -->
            </div>
          </div>
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