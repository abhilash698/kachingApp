@extends('admin.layouts.main')

@section('content')
<!-- START PAGE CONTENT -->
        <div class="content sm-gutter">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid padding-25 sm-padding-10">
            <!-- START ROW -->
            <div class="row">
              <div class="col-md-6 col-xlg-5">
                <div class="row">
                  <div class="col-md-12 m-b-10">
                    <div class="ar-3-2 widget-1-wrapper">
                      <!-- START WIDGET -->
                      <div class="widget-1 panel no-border bg-complete no-margin widget-loader-circle-lg">
                        <div class="panel-heading top-right ">
                          <div class="panel-controls">
                            <ul>
                              <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i class="portlet-icon portlet-icon-refresh-lg-master"></i></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="pull-bottom bottom-left bottom-right ">
                            <span class="label font-montserrat fs-11">Dashboard</span>
                            <br>
                            <h2 class="text-white"></h2>
                            <p class="text-white hint-text">Last week statistics</p>
                            <div class="row stock-rates m-t-15">
                              <div class="company col-xs-4">
                                <div>
                                  <p class="font-montserrat text-success no-margin fs-16">
                                    <i class="fa fa-caret-up"></i> {{ round((($week_aUsers + $week_iUsers) / ($aUsers + $iUsers))*100) }}% 
                                    <span class="font-arial text-white fs-12 hint-text m-l-5">{{ $week_aUsers + $week_iUsers }}</span>
                                  </p>
                                  <p class="bold text-white no-margin fs-11 font-montserrat lh-normal">
                                    USERS
                                  </p>
                                </div>
                              </div>
                              <div class="company col-xs-4">
                                <div>
                                  <p class="font-montserrat text-success no-margin fs-16">
                                    <i class="fa fa-caret-up"></i> 
                                    @if($past != 0) {{ round(($week_offers/$past)*100) }}
                                    @else {{ 0 }}
                                    @endif 
                                    %
                                    <span class="font-arial text-white fs-12 hint-text m-l-5">{{ $week_offers }}</span>
                                  </p>
                                  <p class="bold text-white no-margin fs-11 font-montserrat lh-normal">
                                    OFFERS
                                  </p>
                                </div>
                              </div>
                              <div class="company col-xs-4">
                                <div class="pull-right">
                                  <p class="font-montserrat text-success no-margin fs-16">
                                    <i class="fa fa-caret-up"></i> +0.95%
                                    <span class="font-arial text-white fs-12 hint-text m-l-5">40</span>
                                  </p>
                                  <p class="bold text-white no-margin fs-11 font-montserrat lh-normal">
                                    UBER RIDES
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- END WIDGET -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xlg-4">
                <div class="row">
                  <div class="col-sm-6 m-b-10">
                    <div class="ar-1-1">
                      <!-- START WIDGET -->
                      <div class="back-img1 panel no-border bg-primary widget widget-loader-circle-lg no-margin" >
                        <div class="panel-heading">
                          <div class="panel-controls">
                            <ul>
                              <li><a href="#" class="portlet-refresh" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh-lg-white"></i></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="padding-25">
                            <span class="label font-montserrat fs-11">USERS</span>
                            <br>
                            <a href="/admin/users/active"><h5 class="text-white font-montserrat" >Active Users - <strong>{{ $aUsers }}</strong></h5></a>
                            <a href="/admin/users/inactive"><h5 class="text-white font-montserrat">InActive Users - <strong>{{ $iUsers }}</strong></h5></a>
                            <h4 class="text-white"></h4>
                            <a href="/admin/users/all"><p class="text-white hint-text hidden-md">List of all users</p></a>
                          </div>
                        </div>
                      </div>
                      <!-- END WIDGET -->
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-6 m-b-10">
                    <div class="ar-1-1">
                      <!-- START WIDGET -->
                      <div class="back-img2 panel no-border bg-primary widget widget-loader-circle-lg no-margin">
                        <div class="panel-heading">
                          <div class="panel-controls">
                            <ul>
                              <li><a href="#" class="portlet-refresh" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh-lg-white"></i></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="padding-25">
                            <span class="label font-montserrat fs-11">MERCHANTS</span>
                            <br>
                            <a href="/admin/stores/active"><h5 class="text-white font-montserrat">Active Stores - <strong>{{ $aStores }}</strong></h5></a>
                            <a href="/admin/stores/inactive"><h5 class="text-white font-montserrat">InActive Stores - <strong>{{ $iStores }}</strong></h5></a>
                            <a href="/admin/stores/all"><p class="text-white hint-text hidden-md">List of all merchants</p></a>
                          </div>
                        </div>
                      </div>
                      <!-- END WIDGET -->
                    </div>
                  </div>
                   
                </div>
                <div class="row">
                  <div class="col-sm-6 m-b-10">
                    <div class="ar-1-1">
                      <!-- START WIDGET -->
                      <div class="back-img3 panel no-border bg-primary widget widget-loader-circle-lg no-margin">
                        <div class="panel-heading">
                          <div class="panel-controls">
                            <ul>
                              <li><a href="#" class="portlet-refresh" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh-lg-white"></i></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="padding-25">
                            <span class="label font-montserrat fs-11">OFFERS</span>
                            <br>
                            <a href="/admin/offers/today"><h5 class="text-white font-montserrat">Todays Offers - <strong>{{ $today }}</strong></h5></a>
                            <a href="/admin/offers/future"><h5 class="text-white font-montserrat">Future Offers - <strong>{{ $future }}</strong></h5></a>
                            <a href="/admin/offers/past"><h5 class="text-white font-montserrat">Past Offers - <strong>{{ $past }}</strong></h5></a>
                            <a href="/admin/offers/all"><p class="text-white hint-text hidden-md">List of all offers</p></a>
                          </div>
                        </div>
                      </div>
                      <!-- END WIDGET -->
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-sm-6 m-b-10">
                    <div class="ar-1-1">
                      <!-- START WIDGET -->
                      <div class="back-img4 panel no-border bg-primary widget widget-loader-circle-lg no-margin">
                        <div class="panel-heading">
                          <div class="panel-controls">
                            <ul>
                              <li><a href="#" class="portlet-refresh" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh-lg-white"></i></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="padding-25">
                            <span class="label font-montserrat fs-11">Miscellaneous</span>
                            <br>
                            <a href=""><h5 class="text-white font-montserrat">Uber Rides</h5></a>
                            <a href="/admin/elements"><h5 class="text-white font-montserrat">Elements</h5></a>
                          </div>
                        </div>
                      </div>
                      <!-- END WIDGET -->
                    </div>
                  </div>
                   
                </div>
                
                
              </div>
               
            </div>
             
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->

      @endsection