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
            <form role="form" method='post' action='/admin/edit/supermerchant'>
              {!! csrf_field() !!}
              <input type='hidden' name='parent_id' value='{{ $parent->id }}'>
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
                        <option value="{{$parent->id}}" selected>{{$parent->store_name.', '.$parent->Address->Area->title }}</option>
                        @foreach ($excludedStores as $store)
                           @if(isset($store->Address))<option value="{{$store->id}}">{{$store->store_name.', '.$store->Address->Area->title }}</option>@endif
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
                          @foreach ($childs as $childStore)
                          @if(isset($childStore->Address)) <option {{ 'selected '}} value="{{$childStore->id}} " >{{$childStore->store_name.' ,'.$childStore->Address->Area->title }}</option>@endif
                          @endforeach

                          @foreach ($excludedStores as $store)
                          @if(isset($store->Address)) <option  value="{{$store->id}}" >{{$store->store_name.' ,'.$store->Address->Area->title }}</option>@endif
                          @endforeach
                        </select>
                        <input type='hidden' name='childMerchants' id='multiMerchants'>
                      </div>
                    
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              <div class="col-sm-2 col-sm-offset-10"><button id='add-supermerchant' class="btn btn-success" type="submit">Update</button>
              </div>
            </form>
            </div>
          </div>
        </div>
          <!-- END CONTAINER FLUID -->

@endsection