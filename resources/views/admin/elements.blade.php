@extends('admin.layouts.main')

@section('content')
        <div class="content">
<!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
          	<div class="panel panel-transparent">
              <div class="panel-heading">
                <div class="panel-title">
	                  <!-- START BREADCRUMB -->
	                <ul class="breadcrumb">
	                  <li>
	                    <a href="/admin/dashboard">Dashboard</a>
	                  </li>
	                  <li><a href="#" class="active">Elements</a>
	                  </li>
	                </ul>
	                <!-- END BREADCRUMB -->
                </div>
                
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
	            <div class="row">
	              <div class="col-md-6">
	              	<div class="pull-right" style='position:relative; z-index: 12;'>
	                  <div class='col-xs-4 col-xs-offset-2'><a href="/admin/element/add/tag" ><button class="btn btn-primary" >Add Tag</button></a></div>
	                </div>

	              <!-- START PANEL -->
	                <div class="panel panel-transparent">
	                  <div class="panel-heading">
	                    <div class="panel-title">Store Tags
	                    </div>
	                    <div class="tools">
	                      <a class="collapse" href="javascript:;"></a>
	                      <a class="config" data-toggle="modal" href="#grid-config"></a>
	                      <a class="reload" href="javascript:;"></a>
	                      <a class="remove" href="javascript:;"></a>
	                    </div>
	                  </div>
	                  <div class="panel-body">
	                    <div class="table-responsive">
	                      <table class="table table-hover table-condensed" id="condensedTable">
	                        <thead>
	                          <tr>
	                            <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user 
	                                        Comman Practice Followed
	                                        -->
	                            <th style="width:30%">Id</th>
	                            <th style="width:40%">Title</th>
	                            <th style="width:30%">Actions</th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                        @foreach($tags as $tag)
	                          <tr>
	                            <td class="v-align-middle">{{ $tag->id }}</td>
	                            <td class="v-align-middle semi-bold">{{ $tag->title }}</td>
	                            <td class="v-align-middle "><a href="/admin/element/edit/{{ $tag->id }}/tag"><i class='fa fa-pencil-square-o'></i></a> &nbsp&nbsp<a href="/admin/tag/{{ $tag->id }}/delete" class='confirmation'><i class='fa fa-trash-o'></i></a></td>
	                          </tr>
	                        @endforeach 
	                        </tbody>
	                      </table>
	                    </div>
	                  </div>
	                </div>
	                <!-- END PANEL -->
	              </div>
	              <div class="col-md-6">
	              	<div class="pull-right" style='position:relative; z-index: 12;'>
	                  <div class='col-xs-4 col-xs-offset-2'><a href="/admin/element/add/city" ><button class="btn btn-primary" >Add City</button></a></div>
	                </div>
	              <!-- START PANEL -->
	                <div class="panel panel-transparent">
	                  <div class="panel-heading">
	                    <div class="panel-title">Cities
	                    </div>
	                    <div class="tools">
	                      <a class="collapse" href="javascript:;"></a>
	                      <a class="config" data-toggle="modal" href="#grid-config"></a>
	                      <a class="reload" href="javascript:;"></a>
	                      <a class="remove" href="javascript:;"></a>
	                    </div>
	                  </div>
	                  <div class="panel-body">
	                    <div class="table-responsive">
	                      <table class="table table-hover table-condensed" id="condensedTable">
	                        <thead>
	                          <tr>
	                            <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user 
	                                        Comman Practice Followed
	                                        -->
	                            <th style="width:30%">Id</th>
	                            <th style="width:30%">Title</th>
	                            <th style="width:40%">Actions</th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                        @foreach($cities as $city)
	                          <tr>
	                            <td class="v-align-middle">{{ $city->id }}</td>
	                            <td class="v-align-middle semi-bold">{{ $city->title }}</td>
	                            <td class="v-align-middle "><a href="/admin/element/edit/{{ $city->id }}/city"><i class='fa fa-pencil-square-o'></i></a> <!-- &nbsp&nbsp<a href="/admin/city/{{ $city->id }}/delete"><i class='fa fa-trash'></i></a> --></td>
	                          </tr>
	                        @endforeach
	                        </tbody>
	                      </table>
	                    </div>
	                  </div>
	                </div>
	                <!-- END PANEL -->
	              </div>
	            </div>
	            <div class="row">
	              <div class="col-md-6">
	              	<div class="pull-right" style='position:relative; z-index: 12;'>
	                  <div class='col-xs-4 col-xs-offset-2'><a href="/admin/element/add/state" ><button class="btn btn-primary" >Add State</button></a></div>
	                </div>
	              <!-- START PANEL -->
	                <div class="panel panel-transparent">
	                  <div class="panel-heading">
	                    <div class="panel-title">States
	                    </div>
	                    <div class="tools">
	                      <a class="collapse" href="javascript:;"></a>
	                      <a class="config" data-toggle="modal" href="#grid-config"></a>
	                      <a class="reload" href="javascript:;"></a>
	                      <a class="remove" href="javascript:;"></a>
	                    </div>
	                  </div>
	                  <div class="panel-body">
	                    <div class="table-responsive">
	                      <table class="table table-hover table-condensed" id="condensedTable">
	                        <thead>
	                          <tr>
	                            <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user 
	                                        Comman Practice Followed
	                                        -->
	                            <th style="width:30%">Id</th>
	                            <th style="width:40%">Title</th>
	                            <th style="width:30%">Actions</th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                        @foreach($states as $state)
	                          <tr>
	                            <td class="v-align-middle">{{ $state->id }}</td>
	                            <td class="v-align-middle semi-bold">{{ $state->title }}</td>
	                            <td class="v-align-middle "><a href="/admin/element/edit/{{ $state->id }}/state"><i class='fa fa-pencil-square-o'></i></a> <!-- &nbsp&nbsp<a href="/admin/state/{{ $state->id }}/delete"><i class='fa fa-trash'></i></a> --></td>
	                          </tr>
	                        @endforeach   
	                        </tbody>
	                      </table>
	                    </div>
	                  </div>
	                </div>
	                <!-- END PANEL -->
	              </div>
	              <div class="col-md-6">
	              	<div class="pull-right" style='position:relative; z-index: 12;'>
	                  <div class='col-xs-4 col-xs-offset-2'><a href="/admin/element/add/country" ><button class="btn btn-primary" >Add Country</button></a></div>
	                </div>
	              <!-- START PANEL -->
	                <div class="panel panel-transparent">
	                  <div class="panel-heading">
	                    <div class="panel-title">Countries
	                    </div>
	                    <div class="tools">
	                      <a class="collapse" href="javascript:;"></a>
	                      <a class="config" data-toggle="modal" href="#grid-config"></a>
	                      <a class="reload" href="javascript:;"></a>
	                      <a class="remove" href="javascript:;"></a>
	                    </div>
	                  </div>
	                  <div class="panel-body">
	                    <div class="table-responsive">
	                      <table class="table table-hover table-condensed" id="condensedTable">
	                        <thead>
	                          <tr>
	                            <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user 
	                                        Comman Practice Followed
	                                        -->
	                            <th style="width:30%">Id</th>
	                            <th style="width:40%">Title</th>
	                            <th style="width:30%">Actions</th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                        @foreach($countries as $country)
	                          <tr>
	                            <td class="v-align-middle">{{ $country->id }}</td>
	                            <td class="v-align-middle semi-bold">{{ $country->title }}</td>
	                            <td class="v-align-middle "><a href="/admin/element/edit/{{ $country->id }}/country"><i class='fa fa-pencil-square-o'></i></a><!--  &nbsp&nbsp<a href="/admin/country/{{ $country->id }}/delete"><i class='fa fa-trash'></i></a> --></td>
	                          </tr>
	                        @endforeach
	                        </tbody>
	                      </table>
	                    </div>
	                  </div>
	                </div>
	                <!-- END PANEL -->
	              </div>
	            </div>
	          </div>
	    	</div>
          </div>
      </div>

@endsection