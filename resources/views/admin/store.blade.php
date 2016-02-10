@extends('admin.layouts.main')

@section('content')
    <div class="content">
          <!-- START PAGE COVER -->
          <div class="jumbotron page-cover" data-pages="parallax">
            <div class="container-fluid container-fixed-lg">
              <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <li>
                    <a href="/admin/dashboard">Dashboard</a>
                  </li>
                  <li>
                    <a href="/admin/stores/all">Stores</a>
                  </li>
                  <li><a href="#" class="active">Details</a>
                  </li>
                </ul>
                <!-- END BREADCRUMB -->
                <div class="container-md-height m-b-20">
                  <div class="row row-md-height">
                    <div class="col-lg-7 col-md-6 col-md-height col-middle bg-white">
                      <!-- START PANEL -->
                      <div class="full-height">
                        <div class="panel-body text-center">
                          <img class="image-responsive-height demo-mw-500" src="{{  url('assets/img/stores/') }}/{{ $store->logoUrl }}" alt="">
                        </div>
                      </div>
                      <!-- END PANEL -->
                    </div>
                    <div class="col-lg-5 col-md-height col-md-6 col-top">
                      <!-- START PANEL -->
                      <div class="panel panel-transparent">
                        <div class="panel-heading">
                          <div class="panel-title">Store Details
                          </div>
                        </div>
                        <div class="panel-body">
                          <h3>{{ $store->store_name }}</h3>
                          <p>{{  $store->description }}</p>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Contact </span>
                            </div>
                            <div class="col-xs-6 text-right">+91 {{ $store->merchant->mobile }} / {{ $store->landline }}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Email</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->merchant->email}}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Cost for Two</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->cost_two}}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Store Address</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->address->street.', '.$store->address->city->title }}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Created Time</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $store->created_at }}</div>
                          </div>
                          <br>
                          <a href="/admin/store/{{ $store->id }}/addoffer"><button class="btn btn-primary add-now">Add Offer</button></a>
                          <a href="/admin/store/{{ $store->id }}/edit"><button class="btn btn-primary buy-now">Edit</button></a>
                          <br><br>
                          <div>
                            <a href="/admin/user/{{$store->merchant->id}}">
                            <div class="profile-img-wrapper m-t-5 inline">
                              <img alt="Profile Image" width="33" height="33" data-src-retina="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}" data-src="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}" src="{{  url('assets/img/users') }}/{{ $store->merchant->profileImg }}">
                              <div class="chat-status available">
                              </div>
                            </div>
                            <div class="inline m-l-10">
                              <p class="small hint-text m-t-5">{{$store->merchant->name}}
                                <br> {{ $store->merchant->email }}</p>
                            </div>
                            </a>
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
          <!-- END PAGE COVER -->
          <br>
        </div>
      </div>
      <!-- End CONTAINER FLUID -->

@endsection

@section('footer')

<script type="text/javascript">
$(".flip").hover(function(){
  $(this).find(".card").toggleClass("flipped");
  return false;
});
</script>


@stop