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
              <li><a href="#" class="active">Add</a>
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
                      <h3>Add User</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <p>Only a Super Admin has the permmision to add a user. Ensure that proper roles are selected for the user.</p>
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
                    <form id="form-project" role="form" method='post' action='/admin/user/new/add' autocomplete="off">
                      {!! csrf_field() !!}
                      <p>User Information</p>
                       
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Name <span class='error-msg'>{{ $errors->first('name') }}</span></label>
                          <input type="text" class="form-control" value='' name="name" required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Email <span class='error-msg'>{{ $errors->first('email') }}</span></label>
                          <input type="email" class="form-control" name="email" value='' required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Mobile Number <span class='error-msg'>{{ $errors->first('mobile') }}</span></label>
                          <input type="text" class="form-control" name="mobile" value='' required>
                        </div>
                        <div class="form-group form-group-default required">
                          <label>Password <span class='error-msg'>{{ $errors->first('password') }}</span></label>
                          <input type="password" class="form-control" value='' name="password" required>
                        </div>
                        
                      </div>
                      <p class="m-t-10">Advanced Information</p>
                      <div class="form-group form-group-default form-group-default-select2">
                        <label>Roles</label>
                        <select class=" full-width" id='selMultiAdd' data-init-plugin="select2" multiple>
                          @foreach ($roles as $role)
                          <option  value="{{$role->id}}" >{{$role->display_name}}</option>
                          @endforeach
                        </select>
                        <input type='hidden' name='tags' id='tagsAddUser'>
                      </div>
                       
                      <div class="form-group">
                          <div class="radio radio-success">
                            <input type="radio" value="1" checked='checked' name="status" id="yes">
                            <label for="yes">Active</label>
                            <input type="radio" value="0" name="status" id="no">
                            <label for="no">Inactive</label>
                          </div>
                      </div>
                      <br>
                      <button class="btn btn-success" id='add-user' type="submit">Add</button>
                      <a href="/admin/users/all"><i class="pg-close"></i> Close</a>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
          </div>
          <!-- END CONTAINER FLUID -->

@endsection