@extends('admin.layouts.main')

@section('content')
		<div class="content">
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
                    <a href="/admin/offers/today"><button type="button" class="btn btn-default">Active</button></a>
                    <a href="/admin/offers/past"><button type="button" class="btn btn-default">Up Comming</button></a>
                    <a href="/admin/offers/future"><button type="button" class="btn btn-default">Expired</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="social-wrapper" style='padding-top:30px;'>
            <div class="social " data-pages="social">
              <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="feed">
            	<!-- START ITEM -->
                  @foreach ($offers as $offer)
                    <div class="card share  col1" data-social="item">
                       
                      <div class="card-header clearfix">
                        <div class="user-pic">
                          <img alt="Profile Image" width="33" height="33" data-src-retina="{{  url('assets/img/users') }}/{{ $offer->Store->Merchant->profileImg }}" data-src="{{  url('assets/img/users') }}/{{ $offer->Store->Merchant->profileImg }}" src="{{  url('assets/img/users') }}/{{ $offer->Store->Merchant->profileImg }}">
                        </div>
                        <h5>{{$offer->Store->Merchant->name}}</h5>
                        <h6>created at
                                <span class="location semi-bold"><i class="fa fa-map-marker"></i> {{$offer->created_at}}</span>
                            </h6>
                      </div>
                      <div class="card-description">
                        <div class="flip"> 
            						  <div class="card"> 
            						    <div class="face front">
                              <p class='head-offer'>{{ $offer->Store->store_name }}</p>
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
                        <span>Start Date : {{ $offer->startDate }}</span><br><span>End Date : {{ $offer->endDate }}</span>
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

@endsection

@section('footer')

<script type="text/javascript">
$(".flip").hover(function(){
  $(this).find(".card").toggleClass("flipped");
  return false;
});
</script>


@stop