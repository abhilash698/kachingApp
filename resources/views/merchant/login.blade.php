@extends('merchant.layouts.authentication')

@section('content')

<!-- START PAGE-CONTAINER -->
    <div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic">
        <!-- START Background Pic-->
        {!! Html::image('http://ingenuityuk.com/wp-content/uploads/2014/12/ingenuity_146275016.jpg', '' , array('class' => 'lazy')) !!}
         <!-- END Background Pic-->
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <h2 class="semi-bold text-white">
					#StartDealing - Kaching Merchant Dashboard</h2>
          <p class="small">
            All Rights Reserved. Kaching Corporation</p>
        </div>
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          {!! Html::image('assets/img/custom/index.png', 'logo' , array('class' => '','width'=>'130')) !!}
           <p class="p-t-35">Login with your credentials.</p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" method='POST' action="/login">
            {!! csrf_field() !!}
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Login</label>
              <div class="controls">
                <input type="email" name="email" placeholder="Email" class="form-control" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Password</label>
              <div class="controls">
                <input type="password" class="form-control" name="password" placeholder="Credentials" required>
              </div>
            </div>
            <a href="/merchant/forgot/mobile">Forgot Password</a>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding">
                <div class="checkbox ">
                  <input type="checkbox" name='remember' value="1" id="checkbox1">
                  <label for="checkbox1">Keep Me Signed in</label>
                </div>
              </div>
               
            </div>
            <!-- END Form Control-->
            <button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>
          </form>
          <!--END Login Form-->
           
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    <!-- END PAGE CONTAINER -->
@endsection