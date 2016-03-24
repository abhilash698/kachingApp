@extends('merchant.layouts.main')

@section('content')
<!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <br>
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg bg-white" style='min-height:500px;'>
            <div class="panel panel-transparent">
              <div class="panel-heading">
                <div class="panel-title">
                </div>
                <div class="pull-right">
                  <div class='col-xs-4 col-xs-offset-2'><a href="" data-target="#modalSlideUp" data-toggle="modal" ><button class="btn btn-primary" >Add Offer</button></a></div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                @unless (count($offers))
                 <h2 style='text-align: center;'><br>No Offers Available. Create Your First Offer.</h2>
                @endunless
                

                <div class="row">
                 @foreach($offers as $offer)
                  <!-- OFFER START -->
                  <div class="col-sm-6 col-md-6 col-lg-4 col-xs-12 offer">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn-group">
                      <input type='hidden' value ='{{$offer->id}}' name='offerId'>
                      <input type='hidden' value ='{{$offer->title}}' name='offerTitle'>
                      <input type='hidden' value ='{{$offer->startDate}}' name='offerStartDate'>
                      <input type='hidden' value ='{{$offer->endDate}}' name='offerEndDate'>
                      <input type='hidden' value ='{{$offer->fineprint}}' name='offerFineprint'>

                      <button type="button" class="btn btn-success  offerDisable"  style='float:right;'><i class="toggleI{{$offer->id}} fa @if($offer->status){{ 'fa-toggle-on' }}@else{{ 'fa-toggle-off' }} @endif"></i>
                      </button>
                      <button type="button" class="btn btn-success offerEdit editObj{{$offer->id}}"  style='float:right;'><i class="fa fa-pencil"></i>
                      </button>
                     <!--  <button type="button" class="btn btn-success" style='float:right;'><i class="fa fa-trash-o"></i>
                      </button> -->
                    </div>
                    <!-- Card Start -->
                     <div class="card"> 
                        <div class="front">
                          <div class='col-lg-5 col-md-5 col-sm-3 col-xs-4'>
                            <img src="/assets/img/stores/{{$offer->Store->logoUrl}}">
                          </div>
                          <div class='col-lg-7 col-md-7 col-sm-8 col-xs-8'>
                            <h5>{{ $offer->Store->store_name }}</h5>
                            <p class='title{{$offer->id}}'>{{$offer->title}}</p>
                          </div>

                          <div class='col-lg-5 col-md-5 col-sm-5 col-xs-5 dy-txt'>
                            <i class='fa fa-thumbs-o-up'></i>
                            <span> Kaching</span><span class="bubble">
                                  @if(count($offer->votesCount) == 0)
                                   0
                                  @else
                                  @foreach ($offer->votesCount as $vote)
                                    {{ $vote->aggregate }}
                                  @endforeach
                                  @endif
                            </span>
                          </div>
                          <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 dy-txt'>
                            <i class='fa fa-heart-o'></i>
                            <span> Like</span><span class="bubble">
                                  @if(count($offer->favouriteCount) == 0)
                                    0
                                  @else
                                  @foreach ($offer->favouriteCount as $fav)
                                    {{ $fav->aggregate }}
                                  @endforeach
                                  @endif
                            </span>
                          </div>
                          <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3  dy-txt'>
                            <span> more..</span>
                          </div>

                        </div> 
                        <div class="back">
                          <div class='col-xs-7'>
                            <h5>Fineprint</h5>
                            <ul class='fineprint{{$offer->id}}'>
                              {!! $offer->fineprint !!}
                            </ul>
                          </div>
                          <div class='col-xs-5'>
                            <br>
                            <strong>Start Time</strong>
                            <p class='startDate{{$offer->id}}'>{{ date_format(date_create($offer->startDate), 'jS M h:i A') }}</p>
                            <strong>End Time</strong>
                            <p class='startDate{{$offer->id}}'>{{ date_format(date_create($offer->endDate), 'jS M h:i A') }}</p>
                          </div>
                        </div> 
                      </div>
                    <!-- card end -->  
                  </div>
                  <!-- OFFER ENDS -->

                  @endforeach




                  
                </div>
                <!-- ROW END -->
                {!! $offers->render() !!}
              </div>
              <!-- END PANEL -->
            </div>
          </div>
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright © 2014 </span>
              <span class="font-montserrat">Kaching</span>.
              <span class="hint-text">All rights reserved. </span>
              <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a></span>
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
              <a href="#">Hand-crafted</a> <span class="hint-text">&amp; Made with Love ®</span>
            </p>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->

@endsection