 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="/admin/elements">Areas</a>
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
                      <h3>Add Area</h3>
                    </div>
                  </div>
                  <div class="panel-body">
                    <p>Only a Super Admin has the permmision to add a Element. Ensure that proper tilte is given for the Area.</p>
                    <br>
                     
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              <div class="col-sm-4">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                  <div class="panel-body">
                    <form id="form-project" role="form" method='post' action='/admin/element/area/add' autocomplete="off">
                      {!! csrf_field() !!}
                      <p>Area Information</p>
                       
                      <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                          <label>Title <span class='error-msg'>{{ $errors->first('title') }}</span></label>
                          <input type="text" class="form-control" value='' name="title" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group form-group-default form-group-default-select2 required">
                            <label class="">City <span class='error-msg'>{{ $errors->first('city_id') }}</span></label>
                            <select class="full-width" name='city_id' data-placeholder="Select City" data-init-plugin="select2" autocomplete="off" required>
                              @foreach($cities as $city)
                              <option  value="{{$city->id}}">{{$city->title}}</option>
                              @endforeach
                            </select>
                          </div><!-- end form group -->
                        </div>
                      </div>
                      
                      <br>
                      <button class="btn btn-success" id='add-area' type="submit">Add</button>
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