@extends('layouts.master')
@section('title', 'قائمة العملاء')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-3 mb-2"><span class="text-muted fw-light">Customer Profile /</span>{{$data['customer']->first_name ." ".$data['customer']->last_name}} </h4>

      <!-- Order List Widget -->

      <div class="card mb-2">
        <div class="card-widget-separator-wrapper">
          <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
              <div class="col-sm-6 col-lg-4">
                <div
                  class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                  <div>
                    <h4 class="mb-2">{{$data['orders']}}</h4>
                    <p class="mb-0 fw-medium">Orders</p>
                  </div>
                  <span class="avatar p-2 me-lg-4">
                    <span class="avatar-initial bg-label-secondary rounded"
                      ><i class="ti-md ti ti-checks text-body"></i
                    ></span>
                  </span>
                  </span>
                </div>
                <hr class="d-none d-sm-block d-lg-none me-4" />
              </div>
              <div class="col-sm-6 col-lg-4">
                <div
                  class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                  <div>
                    <h4 class="mb-2">{{$data['sum']}}</h4>
                    <p class="mb-0 fw-medium">Paid</p>
                  </div>
                  <span class="avatar p-2 me-sm-4">
                    <span class="avatar-initial bg-label-secondary rounded"
                      ><i class="ti-md ti ti-wallet text-body"></i
                    ></span>
                  </span>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h4 class="mb-2">32</h4>
                    <p class="mb-0 fw-medium">Failed</p>
                  </div>
                  <span class="avatar p-2">
                    <span class="avatar-initial bg-label-secondary rounded"
                      ><i class="ti-md ti ti-alert-octagon text-body"></i
                    ></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


  
    
    <div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic9 table">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>id</th>
                        <th>تاريخ البدء</th>
                        <th>اسم الشركه</th>
                        <th>تاريخ الانتهاء</th>
                        <th>اسم السائق</th>
                        <th>السعر</th>
                        <th>الوجهه</th>
                        <th>حاله الطلب</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    
    <!-- / Content -->



    <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
@endsection
