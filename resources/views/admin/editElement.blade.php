 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="/admin/elements">Elements</a>
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
                      <h3>Edit {{ $tab }}</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <p>Only a Super Admin has the permmision to edit a Element. Ensure that proper tilte is given for the {{ $tab }}.</p>
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
                    <form id="form-project" role="form" method='post' action='{{ $post_url }}' autocomplete="off">
                      {!! csrf_field() !!}
                      <p>{{ $tab }} Information</p>
                      <input type='hidden' name='element_id' value='{{ $id }}'>
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Title <span class='error-msg'>{{ $errors->first('title') }}</span></label>
                          <input type="text" class="form-control" value='{{ $title }}' name="title" required>
                        </div>
                      </div>
                      
                      <br>
                      <button class="btn btn-success" id='add-user' type="submit">Edit</button>
                      <a href="/admin/elements"><i class="pg-close"></i> Close</a>
                    </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
            </div>
          </div>
          <!-- END CONTAINER FLUID -->

@endsection