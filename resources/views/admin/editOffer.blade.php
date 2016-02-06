 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="/admin/offer/{{ $offer->id }}">Offer</a>
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
                  <div class="panel-heading">
                    <div class="panel-title">
                      <h3>Offer Edit</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <p>Admin and Super Admin has the permissions to edit the information of a offer. Please ensure that the correct start and end date for the offer.</p>
                    <br>
                    <!-- <div>
                      <div class="profile-img-wrapper m-t-5 inline">
                        <img width="35" height="35" src="{{ URL::to('assets/img/users') }}/{{Auth::user()->profileImg}}" alt="" >
                        <div class="chat-status available">
                        </div>
                      </div>
                      <div class="inline m-l-10">
                        <p class="small hint-text">{{ Auth::User()->name }}
                          <br>Editable by Super Admin & Admin</p>
                      </div>
                    </div> -->
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              <div class="col-sm-7">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                  <div class="panel-body">
                    <form id="form-project" role="form" method='post' action='/admin/offer/update' autocomplete="off">
                      {!! csrf_field() !!}
                      <p>Offer Information</p>
                      <input type='hidden' name='offer_id' value='{{ $offer->id }}'>
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">

                          <label>Offer Title  <span class='error-msg'>{{ $errors->first('title') }}</span></label>
                          <input type="text" class="form-control" value='{{$offer->title}}' name="title" required>
                        </div>

                        <div class="form-group form-group-default required">
                          <label>Start Date <span class='error-msg'>{{ $errors->first('startDate') }}</span></label>
                          <div id="datepicker-component" class="input-group date col-sm-8">
                            <input type="text" name='startDate' class="form-control" value='{{ $offer->startDate }}'><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>

                        <div class="form-group form-group-default required">
                          <label>End Date <span class='error-msg'>{{ $errors->first('endDate') }}</span></label>
                          <div id="datepicker-component" class="input-group date col-sm-8">
                            <input type="text" name='endDate' value='{{ $offer->endDate }}' class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>

                        <div class="form-group form-group-default required">
                          <label>Fineprint <span class='error-msg'>{{ $errors->first('fineprint') }}</span></label>
                          <textarea name='fineprint' style="width:100%; height: 150px;">{{ $offer->fineprint }}</textarea>
                        </div>                        
                        
                      </div>
                      
                      <br>
                      <button class="btn btn-success" id='update-user' type="submit">Update</button>
                      <a href="/admin/store/{{ $offer->store_id }}/offers/all"><i class="pg-close"></i> Close</a>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
          </div>
          <!-- END CONTAINER FLUID -->

@endsection