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
                <a href="/merchant/store">Store</a>
              </li>
              <li><a href="" class="active">Edit</a>
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
                      <h3>{{$store->store_name}} Edit</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                      <div class="full-height">
                        <div class="panel-body text-center">
                          <img class="image-responsive-height demo-mw-500" src="{{  url('assets/img/stores/') }}/{{ $store->logoUrl }}" alt="">
                        </div>
                      </div>
                    <br>
                    <!-- <div>
                      <div class="profile-img-wrapper m-t-5 inline">
                        <img width="35" height="35" src="{{ URL::to('assets/img/users') }}/{{Auth::user()->profileImg}}" alt="" >
                        <div class="chat-status available">
                        </div>
                      </div>
                      <div class="inline m-l-10">
                        <p class="small hint-text">{{ Auth::User()->name }}
                          <br>Editable by Admin & Super Admin</p>
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
                    <form id="form-project" role="form" method='post' action='/merchant/store/edit' enctype="multipart/form-data" autocomplete="off">
                      {!! csrf_field() !!}
                      <p>Store Information</p>
                      <input type='hidden' name='store_id' value='{{ $store->id }}'>
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Store Name <span class='error-msg'>{{ $errors->first('store_name') }}</span></label>
                          <input type="text" class="form-control" value='{{$store->store_name}}' name="store_name" required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Veg <span class='error-msg'>{{ $errors->first('veg') }}</span></label>
                            <div class="">
                              <input type="radio" value="1" {{ $store->veg ? 'checked="checked"' : ''}}  name="veg" >
                              <label for="yes">Yes</label>
                              <input type="radio" value="0" {{ !$store->veg ? 'checked="checked"' : ''}} name="veg" >
                              <label for="no">No</label>
                            </div>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Landline <span class='error-msg'>{{ $errors->first('landline') }}</span></label>
                          <input type="text" class="form-control" value='{{$store->landline}}'  name="landline" required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Cost for Two <span class='error-msg'>{{ $errors->first('cost_two') }}</span></label>
                          <input type="text" class="form-control" value='{{$store->cost_two}}' name="cost_two" required>
                        </div>

                        <div class="form-group  form-group-default required">
                          <select cclass="full-width" data-init-plugin="select2" name='tag_id'>
                            @foreach ($tags as $tag)
                            <option @if($store->tags->contains($tag->id)) {{ 'selected '}} @endif  value="{{$tag->id}}" >{{$tag->title}}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="form-group form-group-default required">
                          <label>Logo</label>
                          <input name="logo" type="file" />
                        </div>
                                          
                      </div>
                       <br>
                      <p class="m-t-10">Store Address </p>
                      <div class="form-group form-group-default required">
                        <label>Street <span class='error-msg'>{{ $errors->first('street') }}</span></label>
                        <input type="text" class="form-control" value='{{$store->address->street }}' name="street" required>
                      </div>
                      <div class="form-group form-group-default required">
                        <span class='error-msg'>{{ $errors->first('city_id') }}</span>
                        <select class="cs-select cs-skin-slide" name='city_id' data-init-plugin="cs-select">
                          @foreach($cities as $city)
                          <option @if( $store->address->city_id == $city->id)  {{ 'selected' }} @endif value="{{$city->id}}">{{$city->title}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group form-group-default required">
                        <span class='error-msg'>{{ $errors->first('area_id') }}</span>
                        <select class="cs-select cs-skin-slide" name='area_id' data-init-plugin="cs-select">
                          @foreach($areas as $area)
                          <option @if( $store->address->area_id == $area->id)  {{ 'selected' }} @endif value="{{$area->id}}">{{$area->title}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group form-group-default required">

                        <span class='error-msg'>{{ $errors->first('state_id') }}</span>
                        <select class="cs-select cs-skin-slide" name='state_id' data-init-plugin="cs-select">
                          @foreach($states as $state)
                          <option @if($store->address->state_id == $state->id) {{ 'selected' }} @endif value="{{$state->id}}">{{$state->title}}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group form-group-default required">
                        <span class='error-msg'>{{ $errors->first('country_id') }}</span>
                        <select class="cs-select cs-skin-slide" name='country_id' data-init-plugin="cs-select">
                          @foreach($countries as $country)
                          <option @if($store->address->country_id == $country->id) {{ 'selected' }} @endif value="{{$country->id}}">{{$country->title}}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group form-group-default required">
                        <label>Pincode <span class='error-msg'>{{ $errors->first('pincode') }}</span></label>
                        <input type="text" class="form-control" value='{{$store->address->pincode }}' name="pincode" required>
                      </div>

                      <div class="form-group form-group-default required">
                        <label>Latitude <span class='error-msg'>{{ $errors->first('latitude') }}</span></label>
                        <input type="text" class="form-control" value='{{$store->address->latitude }}' name="latitude" required>
                      </div>

                      <div class="form-group form-group-default required">
                        <label>Longitude <span class='error-msg'>{{ $errors->first('longitude') }}</span></label>
                        <input type="text" class="form-control" value='{{$store->address->longitude }}' name="longitude" required>
                      </div>

                      <div class="form-group">
                          <div class="radio radio-success">
                            <input type="radio" value="1" {{ $store->status ? 'checked="checked"' : ''}}  name="status" id="yes">
                            <label for="yes">Active</label>
                            <input type="radio" value="0" {{ !$store->status ? 'checked="checked"' : ''}} name="status" id="no">
                            <label for="no">Inactive</label>
                          </div>
                      </div>

                       
                       
                      <br>
                      <button class="btn btn-success" type="submit">Update</button>
                      <a href="/merchant/store"><i class="pg-close"></i> Close</a>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
          </div>
        </div>
          <!-- END CONTAINER FLUID -->
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