    @extends('auth.layouts.authentication')

    @section('content')

    <div class="register-container full-height sm-p-t-30">
      <div class="container-sm-height full-height">
        <div class="row row-sm-height">
          <div class="col-sm-12 col-sm-height col-middle">
            {!! Html::image('assets/img/logo.png', 'logo' , array('class' => '','width'=>'78','height'=>'22')) !!}
             <h3>Pages makes it easy to enjoy what matters the most in your life</h3>
            <p>
              <small>
        Create a pages account. If you have a facebook account, log into it for this process. Sign in with <a href="#" class="text-info">Facebook</a> or <a href="#" class="text-info">Google</a>
    </small>
            </p>
            <form id="form-register" class="p-t-15" role="form" action="index.html">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group form-group-default">
                    <label>First Name</label>
                    <input type="text" name="fname" placeholder="John" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group form-group-default">
                    <label>Last Names</label>
                    <input type="text" name="lname" placeholder="Smith" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group form-group-default">
                    <label>Pages User name</label>
                    <input type="text" name="uname" placeholder="yourname.pages.com (this can be changed later)" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group form-group-default">
                    <label>Password</label>
                    <input type="password" name="pass" placeholder="Minimum of 4 Charactors" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group form-group-default">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="We will send loging details to you" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row m-t-10">
                <div class="col-md-6">
                  <p>I agree to the <a href="#" class="text-info small">Pages Terms</a> and <a href="#" class="text-info small">Privacy</a>.</p>
                </div>
                <div class="col-md-6 text-right">
                  <a href="#" class="text-info small">Help? Contact Support</a>
                </div>
              </div>
              <button class="btn btn-primary btn-cons m-t-10" type="submit">Create a new account</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class=" full-width">
      <div class="register-container m-b-10 clearfix">
        <div class="inline pull-left">
          {!! Html::image('assets/img/demo/pages_icon.png', '' , array('class' => 'm-t-5','width'=>'60','height'=>'60')) !!}
        </div>
        <div class="col-md-10 m-t-15">
          <p class="hinted-text small inline ">No part of this website or any of its contents may be reproduced, copied, modified or adapted, without the prior written consent of the author, unless otherwise indicated for stand-alone materials.</p>
        </div>
      </div>
    </div>
    @endsection