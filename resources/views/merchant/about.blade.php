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
                  About
                </div>
                 
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                 <h5>{{$about}}</h5>
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