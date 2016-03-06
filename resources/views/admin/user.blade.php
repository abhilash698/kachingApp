 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg bg-white">
            <!-- START PANEL -->
            <div class="panel panel-transparent">
              <div class="panel-heading">
                <div class="panel-title">Pages Default Tables Style
                </div>
                <div class="pull-right">
                  <div class='col-xs-4 col-xs-offset-2'><a href="/admin/user/new/add"><button class="btn btn-primary" >Add User</button></a></div>
                  <div class="col-xs-6">
                    <form method='get' action='/admin/search/users'>
                      <input type="text" id="search-user" name='q' class="form-control pull-right" placeholder="Search">
                    </form>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                <table class="table table-hover demo-table-search" id="tableWithSearch">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Roles</th>
                      <th>Email</th>
                      <th>mobile</th>
                      <th>Status</th>
                      <th>Image</th>
                      <th>Mobile Verification</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="v-align-middle semi-bold">
                        <p>{{ $user->name }}</p>
                      </td>
                      <td class="v-align-middle">
                      @foreach ($user->roles as $role)
                      <a href="#" class="btn btn-tag">{{ $role->name }}</a>
                      @endforeach
                      </td>
                      <td class="v-align-middle">
                        <p>{{ $user->email }}</p>
                      </td>
                      <td class="v-align-middle">
                        <p>{{ $user->mobile }}</p>
                      </td>
                      <td class="v-align-middle">
                        <p>{{ $user->status ? 'Active' : 'Inactive'}}<p>
                      </td>
                      <td class="v-align-middle">
                        <p>{{ URL::to('/profile/img') }}/img-56.jpg</td>
                      <td class="v-align-middle">
                        <p>{{ $user->is_mobile_verified ? 'Active' : 'Inactive'}}<p>
                      </td>
                      <td><a href="/admin/user/{{ $user->id }}/edit"><i class='fa fa-pencil-square-o'></i></a> &nbsp&nbsp<a href="/admin/user/{{ $user->id }}/delete" class='confirmation'><i class='fa fa-trash-o'></i></a> &nbsp&nbsp&nbsp<a href="/admin/user/{{ $user->id }}/addstore"><i class='fa fa-plus'></i></a></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END PANEL -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
@endsection