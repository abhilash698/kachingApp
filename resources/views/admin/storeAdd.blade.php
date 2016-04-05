 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="/admin/user/{{ $user->id }}/all">User</a>
              </li>
              <li><a href="#" class="active">Add Store</a>
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
                      <h3>Add Store</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <p>Store is added under the merchant name {{ $user->name }}. Please ensure store added to valid and active merchant. Only Super Admin has the rights to add a store.
                      <br> Make Sure Store Image Dimmesions be 280x240 px for better dispaly.</p>
                    <br>
                    <!-- <div>
                      <div class="profile-img-wrapper m-t-5 inline">
                        <img width="35" height="35" src="{{ URL::to('assets/img/users') }}/{{Auth::user()->profileImg}}" alt="" >
                        <div class="chat-status available">
                        </div>
                      </div>
                      <div class="inline m-l-10">
                        <p class="small hint-text"><br>{{ Auth::User()->name }}
                           </p>
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
                    <form id="form-project" role="form" method='post' action='/admin/store/add'  enctype="multipart/form-data" autocomplete="off">
                      {!! csrf_field() !!}
                      <p>Store Information</p>
                      <input type='hidden' name='user_id' value='{{ $user->id }}'>
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Store Name <span class='error-msg'>{{ $errors->first('store_name') }}</span></label>
                          <input type="text" class="form-control"  name="store_name" required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Landline <span class='error-msg'>{{ $errors->first('landline') }}</span></label>
                          <input type="text" class="form-control"  name="landline" required>
                        </div>
                        
                        <div class="form-group form-group-default required">
                          <label>Cost for Two <span class='error-msg'>{{ $errors->first('cost_two') }}</span></label>
                          <input type="text" class="form-control"  name="cost_two" required>
                        </div>

                        <div class="form-group form-group-default required">
                          <label>Veg </label>
                            <div class="">
                              <input type="radio" value="1" name="veg" >
                              <label for="yes">Yes</label>
                              <input type="radio" value="0" name="veg" >
                              <label for="no">No</label>
                            </div>
                        </div>

                        <div class="form-group form-group-default required">
                          <label>Logo <span class='error-msg'>{{ $errors->first('logo') }}</span></label>
                          <input name="logo" type="file" />
                        </div>
                                          
                      </div>
                      <p class="m-t-10">Store Info</p>
                      <div class="form-group form-group-default form-group-default-select2">
                        <label>Tags</label>
                        <select class=" full-width" id='selMultiTags' data-init-plugin="select2" multiple>
                          @foreach ($tags as $tag)
                          <option  value="{{$tag->id}}" >{{$tag->title}}</option>
                          @endforeach
                        </select>
                        <input type='hidden' name='tags' id='storeTags'>
                      </div>
                       
                       
                      <div class="form-group">
                          <div class="">
                            <input type="radio" value="1"  name="status" >
                            <label for="yes">Active</label>
                            <input type="radio" value="0"  name="status" >
                            <label for="no">Inactive</label>
                          </div>
                      </div>

                      <p class="m-t-10">Store Address </p>
                      <div class="form-group form-group-default required">
                        <label>Street <span class='error-msg'>{{ $errors->first('street') }}</span></label>
                        <input type="text" class="form-control" value='' name="street" required>
                      </div>
                      <span class='error-msg'>{{ $errors->first('city_id') }}</span>
                      <select class="cs-select cs-skin-slide" name='city_id' data-init-plugin="cs-select">
                        @foreach($cities as $city)
                        <option  value="{{$city->id}}">{{$city->title}}</option>
                        @endforeach
                      </select>

                      <span class='error-msg'>{{ $errors->first('area_id') }}</span>
                      <select class="cs-select cs-skin-slide" name='area_id' data-init-plugin="cs-select">
                        @foreach($areas as $area)
                        <option  value="{{$area->id}}">{{$area->title}}</option>
                        @endforeach
                      </select>

                      <span class='error-msg'>{{ $errors->first('state_id') }}</span>
                      <select class="cs-select cs-skin-slide" name='state_id' data-init-plugin="cs-select">
                        @foreach($states as $state)
                        <option  value="{{$state->id}}">{{$state->title}}</option>
                        @endforeach
                      </select>

                      <span class='error-msg'>{{ $errors->first('country_id') }}</span>
                      <select class="cs-select cs-skin-slide" name='country_id' data-init-plugin="cs-select">
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->title}}</option>
                        @endforeach
                      </select>

                      <br>
                      <div class="form-group form-group-default required">
                        <label>Pincode <span class='error-msg'>{{ $errors->first('pincode') }}</span></label>
                        <input type="text" class="form-control" value='' name="pincode" required>
                      </div>

                      <div class="form-group form-group-default required">
                        <label>Latitude <span class='error-msg'>{{ $errors->first('latitude') }}</span></label>
                        <input type="text" class="form-control" value='' name="latitude" required>
                      </div>

                      <div class="form-group form-group-default required">
                        <label>Longitude <span class='error-msg'>{{ $errors->first('longitude') }}</span></label>
                        <input type="text" class="form-control" value='' name="longitude" required>
                      </div>
                       
                       
                      <br>
                      <button class="btn btn-success" id='update-store' type="submit">Add</button>
                      <a href="/admin/user/{{$user->id}}"><i class="pg-close"></i> Close</a>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
          </div>
        </div>
          <!-- END CONTAINER FLUID -->

@endsection