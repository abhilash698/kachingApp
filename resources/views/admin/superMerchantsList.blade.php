 @extends('admin.layouts.main')

@section('content')

        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg bg-white">
            <!-- START PANEL -->
            <div class="panel panel-transparent">
              <div class="panel-heading">
                <div class="panel-title">
                  <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <li>
                    <a href="/admin/dashboard">Dashboard</a>
                  </li>
                  <li><a href="#" class="active">Super Mercahnts</a>
                  </li>
                </ul>
                <!-- END BREADCRUMB -->
                </div>
                <div class="pull-right">
                  <div class='col-xs-5 col-xs-offset-2'><a href="/admin/addSuperMerchant"><button class="btn btn-primary" >Add Super Merchant</button></a></div>
                  <div class="col-xs-5">

                    <form method='get' action='/admin/search/superMerchant'>
                      <input type="text" id="search-user" name='q' class="form-control pull-right" placeholder="Search">
                    </form>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                <table class="table table-hover demo-table-search" id="tableWithSearch">
                  <thead>
                    <tr>
                      <th>Super Merchant</th>
                      <th>Merchants</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($stores as $store)
                    <tr>
                      <td class="v-align-middle semi-bold">
                        <p>{{ $store->store_name }}</p>
                      </td>
                      <td class="v-align-middle">
                      @foreach ($store->childs as $child)
                      <a href="#" class="btn btn-tag">{{ $child->store_name }}@if(isset($store->Address)) {{ ', '.$store->Address->Area->title }} @endif</a>
                      @endforeach
                      </td>
                       
                      <td class='v-align-middle'><a href="/admin/superMerchant/{{ $store->id }}/edit"><i class='fa fa-pencil-square-o'></i></a> &nbsp&nbsp<a href="/admin/superMerchantDelete/{{ $store->id }}/delete" class='confirmation'><i class='fa fa-trash-o'></i></a></td>
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                {!! $stores->render() !!}
              </div>
            </div>
            <!-- END PANEL -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
@endsection