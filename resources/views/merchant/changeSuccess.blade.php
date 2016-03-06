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
           <p class="p-t-35">Forgot Password.</p>
          <!-- START Login Form -->
           <h3>Password Successfully Changed</h3>
           <a href="/merchant/login"><button class="btn btn-primary btn-cons m-t-10" type="button">Login</button></a>
          <!--END Login Form-->
           
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    <!-- END PAGE CONTAINER -->
@endsection