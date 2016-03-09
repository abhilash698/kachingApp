 @extends('merchant.layouts.main')

@section('content')
<!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="#">Profile</a>
              </li>
              <li><a href="#" class="active">Edit</a>
              </li>
            </ul>
            <!-- END BREADCRUMB -->
          </div>
          <!-- END CONTAINER FLUID -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg bg-white">
            <div class="row">
               
              <div class="col-sm-5">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                  <div class="panel-body">
                    <form id="form-project" role="form" method='post' action='/merchant/profile/edit' autocomplete="off">
                      {!! csrf_field() !!}
                      <h5>User Information</h5>@if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Name <span class='error-msg'>{{ $errors->first('name') }}</span></label>
                          <input type="text" class="form-control" value='{{$user->name}}' name="name" required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Email <span class='error-msg'>{{ $errors->first('email') }}</span></label>
                          <input type="email" class="form-control" name="email" value='{{ $user->email }}' required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Mobile Number <a href="" data-target="#modalStickUpSmall" data-toggle="modal">Change</a></label>
                          <input type="text" class="form-control" id='mobile-orginal' name="mobile" value='{{ $user->mobile }}' disabled>
                        </div>
                        
                      </div>                       
                      
                      <br>
                      <button class="btn btn-success" id='update-user' type="submit" style='float:right;'>Update</button>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              <div class="col-sm-4 col-sm-offset-1">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                  <div class="panel-body">
                    <form id="form-project" role="form" method='post' action='/merchant/profile/changepassword' autocomplete="off">
                      {!! csrf_field() !!}
                      <h5>Change Password</h5>@if (session('status1'))
                            <div class="alert alert-success">
                                {{ session('status1') }}
                            </div>
                        @endif
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Old Password <span class='error-msg'>{{ $errors->first('old') }}</span></label>
                          <input type="password" class="form-control" name="old" required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>New Password <span class='error-msg'>{{ $errors->first('new') }}</span></label>
                          <input type="password" class="form-control" name="new" required>
                        </div>                        
                      </div>                       
                      <br>
                      <button class="btn btn-success" id='update-user' type="submit" style='float:right;'>Change Password</button>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
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