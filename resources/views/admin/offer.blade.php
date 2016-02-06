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
                    <a href="/admin/offers/all">Offer</a>
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
                          <img class="image-responsive-height demo-mw-500" src="{{  url('assets/img/stores/') }}/{{ $offer->store->logoUrl }}" alt="">
                        </div>
                      </div>
                      <!-- END PANEL -->
                    </div>
                    <div class="col-lg-5 col-md-height col-md-6 col-top">
                      <!-- START PANEL -->
                      <div class="panel panel-transparent">
                        <div class="panel-heading">
                          <div class="panel-title">Offer Details
                          </div>
                        </div>
                        <div class="panel-body">
                          <h3>{{ $offer->title }}</h3>
                          <!-- <p>{{  $offer->fineprint }}</p> -->
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Store Name</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $offer->store->store_name}}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Offer Start Date</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $offer->startDate}}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Offer End Date</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $offer->endDate }}</div>
                          </div>
                          <div class="row m-b-20 m-t-20">
                            <div class="col-xs-6"><span class="font-montserrat all-caps fs-11">Created Time</span>
                            </div>
                            <div class="col-xs-6 text-right">{{ $offer->created_at }}</div>
                          </div>
                          <br>
                          <a href="/admin/offer/{{ $offer->id }}/edit"><button class="btn btn-primary buy-now">Edit</button></a>
                           
                           
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