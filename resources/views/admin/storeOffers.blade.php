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
                    <a href="/admin/store/{{ $store->id }}">Store</a>
                  </li>
                  <li><a href="#" class="active">Offers</a>
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
                          <div class="panel-title">Store Offers
                          </div>
                        </div>
                        <div class="panel-body">
                          <h3>{{ $store->store_name }}</h3>
                          <p>{{  $store->description }}</p>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Merchant Contact</span>
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
                          <br>
                          <br>
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
          <div class="row">
            <div class="col-md-2 col-md-offset-5">
              <h1 class='semi-bold font-montserrat'>OFFERS</h1>
               
            </div>
          </div>
          <div class='row'>
            <div class="col-md-4 col-md-offset-7">
              <div class="pull-right sm-pull-left">
                <div class="btn-toolbar m-t-10" role="toolbar">
                  <div class="btn-group">
                    <a href="/admin/store/{{ $store->id }}/offers/today"><button type="button" class="btn btn-default">Active</button></a>
                    <a href="/admin/store/{{ $store->id }}/offers/past"><button type="button" class="btn btn-default">Up Comming</button></a>
                    <a href="/admin/store/{{ $store->id }}/offers/future"><button type="button" class="btn btn-default">Expired</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
          <div class="social-wrapper" style='padding-top:30px;'>
            <div class="social " data-pages="social">
              <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="feed">
            	<!-- START ITEM -->
                  @foreach ($offers as $offer)
                    <div class="card share  col1" data-social="item">
                      <div class="card-description">
                        <div class="flip"> 
            						  <div class="card"> 
            						    <div class="face front" >
                              <p class='head-offer'>{{ $offer->store->store_name }}</p>
                              <p class='offer-txt'>{{$offer->title}}.</p>

                              <hr>
                              <div class='row' style='width:100%;display: inline-block; padding-top:0px;'>
                                <div class='col-md-6 offer-global'>
                                  <i class='fa fa-newspaper-o'></i><span>Kaching</span>
                                  @if(count($offer->votesCount) == 0)
                                    <span class="txt">0</span>
                                  @else
                                  @foreach ($offer->votesCount as $vote)
                                    <span class="txt">{{ $vote->aggregate }}</span>
                                  @endforeach
                                  @endif
 
                                </div>
                                <div class='col-md-6 offer-global' >
                                  <i class='fa fa-star'></i><span>Favourites</span>
                                  @if(count($offer->favouriteCount) == 0)
                                    <span class="txt">0</span>
                                  @else
                                  @foreach ($offer->favouriteCount as $fav)
                                    <span class="txt">{{ $fav->aggregate }}</span>
                                  @endforeach
                                  @endif
                                   
                                </div>
                              </div>
                              
                              

                            </div> 
            						    <div class="face back">
                              <p class='head-offer'>Fine Print </p>
                              <ul class='fineprint'>
                                <li>
                                  offer is valid only untill stocks last.
                                </li>
                                <li>
                                  Kindly recheck with our store managers reg.
                                </li>
                                <li>
                                  Not Valid on Desserts and mocktails
                                </li>
                              </ul>
                            </div> 
            						  </div> 
            						</div> 
                      </div>
                      <div class='offer-range'>
                        <span>Start Date : {{ $offer->startDate }}</span><span>End Date : {{ $offer->endDate }}</span>
                      </div>
                      <div class='edit-options'>
                        <span><a href="/admin/offer/{{ $offer->id }}/edit"><i class="fa fa-pencil-square-o "></i></a></span>
                        <span><a href="/admin/offer/{{ $offer->id }}/delete"><i class="fa fa-trash "></i></a></span>
                      </div>
                    </div>
                    <!-- END ITEM -->
                    @endforeach
                </div>
                {!! $offers->render() !!}
              </div>
            </div>
          </div>
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