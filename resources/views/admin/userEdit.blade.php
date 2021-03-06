 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="#">User</a>
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
                      <h3>User Edit</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <p>Only a Super Admin has the permmision to edit the information of a user. Ensure that proper roles are selected for the user.</p>
                    <br>
                    <!-- <div>
                      <div class="profile-img-wrapper m-t-5 inline">
                        <img width="35" height="35" src="{{ URL::to('assets/img/users') }}/{{ Auth::user()->profileImg }}" alt="" >
                        <div class="chat-status available">
                        </div>
                      </div>
                      <div class="inline m-l-10">
                        <p class="small hint-text">{{ Auth::User()->name }}
                          <br>Editable by Only Super Admin</p>
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
                    <form id="form-project" role="form" method='post' action='/admin/user/update' autocomplete="off">
                      {!! csrf_field() !!}
                      <p>User Information</p>
                      <input type='hidden' name='user_id' value='{{ $user->id }}'>
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
                          <label>Mobile Number <span class='error-msg'>{{ $errors->first('mobile') }}</span></label>
                          <input type="text" class="form-control" name="mobile" value='{{ $user->mobile }}' required>
                        </div>
                        
                      </div>
                      <p class="m-t-10">Advanced Information</p>
                      <div class="form-group form-group-default form-group-default-select2">
                        <label>Roles</label>
                        <select class=" full-width" id='selMulti' data-init-plugin="select2" multiple>
                          @foreach ($roles as $role)
                          <option @if($user->hasrole($role->name)) {{ 'selected '}} @endif value="{{$role->id}}" >{{$role->display_name}}</option>
                          @endforeach
                        </select>
                        <input type='hidden' name='tags' id='tagsInp'>
                      </div>
                       
                      <div class="form-group">
                          <div class="">
                            <input type="radio" value="1" {{ $user->status ? 'checked="checked"' : ''}}  name="status" >
                            <label for="yes">Active</label>
                            <input type="radio" {{ !$user->status ? 'checked="checked"' : ''}} value="0" name="status" >
                            <label for="no">Inactive</label>
                          </div>
                      </div>
                      <br>
                      <button class="btn btn-success" id='update-user' type="submit">Update</button>
                      <a href="/admin/user/{{ $user->id }}/"><i class="pg-close"></i> Close</a>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
          </div>
          <!-- END CONTAINER FLUID -->

@endsection