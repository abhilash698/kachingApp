 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
              <li>
                <a href="/admin/user/all">User</a>
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
            <form role="form" method='post' action='/admin/add/supermerchant'>
              {!! csrf_field() !!}
              <div class="col-sm-5">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                   
                  <div class="panel-body">
                    <p>Select Super Merchant</p>
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <br>
                    <div class="form-group form-group-default form-group-default-select2 required">
                      <label class="">Super Merchant</label>
                      <select class="full-width" name='superMerchant' data-placeholder="Select Super Merchant" data-init-plugin="select2" required>

                        @foreach ($stores as $store)
                           <option value="{{$store->id}}">@if(isset($store->Address)){{$store->store_name.', '.$store->Address->Area->title }}@endif</option>
                        @endforeach
                      </select>
                    </div>
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
                      <p>Select Child Merchants</p>
                      <br>
                      <div class="form-group form-group-default form-group-default-select2">
                        <label>Child Stores</label>
                        <select class=" full-width" id='selMultiTags'  data-init-plugin="select2" multiple required>
                          @foreach ($stores as $store)
                          <option  value="{{$store->id}}" >@if(isset($store->Address)){{$store->store_name.' ,'.$store->Address->Area->title }}@endif</option>
                          @endforeach
                        </select>
                        <input type='hidden' name='childMercahnts' id='multiMerchants'>
                      </div>
                    
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              <div class="col-sm-2 col-sm-offset-10"><button id='add-supermerchant' class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
            </div>
          </div>
        </div>
          <!-- END CONTAINER FLUID -->

@endsection