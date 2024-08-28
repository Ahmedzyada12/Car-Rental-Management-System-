@extends('layouts.master')
@section('title', 'قائمة العملاء')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-2"><span class="text-muted fw-light">Company Profile /</span>
                {{ $data['company']->first_name . ' ' . $data['company']->last_name }} </h4>

            <!-- Order List Widget -->
            <div class="card mb-4" id="sss">
                <div class="card-widget-separator-wrapper">
                    <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                            <label for="selectfilter" class="form-label">Filter By</label>
                            <select id="selectfilter" name="filter_by" class="select2 form-select form-select-lg"
                                data-allow-clear="true">
                                <option value="all" {{ $filterValue == 'all' ? 'selected' : '' }}>all</option>
                                <option value="current_month" {{ $filterValue == 'current_month' ? 'selected' : '' }}>
                                    current month</option>
                                <option value="last_month" {{ $filterValue == 'last_month' ? 'selected' : '' }}>last month
                                </option>
                                <option value="current_year" {{ $filterValue == 'current_year' ? 'selected' : '' }}>current
                                    year</option>
                                <option value="last_year" {{ $filterValue == 'last_year' ? 'selected' : '' }}>last year
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-widget-separator-wrapper">
                    <div class="card-body card-widget-separator">
                        <div class="row gy-4 gy-sm-1">
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h4 class="mb-2">{{ $data['orders'] }}</h4>
                                        <p class="mb-0 fw-medium">Orders</p>
                                    </div>
                                    <span class="avatar me-sm-4">
                                        <span class="avatar-initial bg-label-secondary rounded">
                                            <i class="ti-md ti ti-calendar-stats text-body"></i>
                                        </span>
                                    </span>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none me-4" />
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h4 class="mb-2">{{ $data['customers'] }}</h4>
                                        <p class="mb-0 fw-medium">Customers</p>
                                    </div>
                                    <span class="avatar p-2 me-lg-4">
                                        <span class="avatar-initial bg-label-secondary rounded"><i
                                                class="ti-md ti ti-checks text-body"></i></span>
                                    </span>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none" />
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div
                                    class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                    <div>
                                        <h4 class="mb-2">{{ $data['sum'] }}</h4>
                                        <p class="mb-0 fw-medium">Paid</p>
                                    </div>
                                    <span class="avatar p-2 me-sm-4">
                                        <span class="avatar-initial bg-label-secondary rounded"><i
                                                class="ti-md ti ti-wallet text-body"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="mb-2">32</h4>
                                        <p class="mb-0 fw-medium">Failed</p>
                                    </div>
                                    <span class="avatar p-2">
                                        <span class="avatar-initial bg-label-secondary rounded"><i
                                                class="ti-md ti ti-alert-octagon text-body"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-end company-cust" id="add-new-record">

                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('customers/customers_trans.New Record') }}
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body flex-grow-1">
                    <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                        <input class="comp-cust" type="hidden" name="parent_id" value="{{ $data['company']->user_id }}">
                        <div class="col-sm-12">
                            <label class="form-label"
                                for="basicFullname">{{ trans('customers/customers_trans.first Name') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="first_name" class="input-group-text"><i class="ti ti-user"></i></span>
                                <input type="text" id="first_name" class="form-control dt-first_name" name="first_name"
                                    aria-describedby="basicFullname2" />
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label"
                                for="last_name">{{ trans('customers/customers_trans.last Name') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="last_name" class="input-group-text"><i class="ti ti-user"></i></span>
                                <input type="text" id="last_name" class="form-control dt-last_name" name="last_name"
                                    aria-describedby="last_name2" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="basicPost">{{ trans('drivers/drivers_trans.Address') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                                <input type="text" id="address" name="address" class="form-control dt-address"
                                    aria-describedby="basicPost2" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label"
                                for="basicPost">{{ trans('customers/customers_trans.Phone') }}</label>
                            <div class="input-group input-group-merge">
                                <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                                <input type="text" id="phone" name="phone" class="form-control dt-phone"
                                    aria-describedby="basicPost2" />
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <button type="submit"
                                class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('customers/customers_trans.Submit') }}</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">{{ trans('customers/customers_trans.Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" id="test">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic7 table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>id</th>
                                <th>الاسم</th>
                                <th>phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="card">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic8 table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>id</th>
                                <th>تاريخ البدء</th>
                                <th>اسم العميل</th>
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
        </div>
        </>
        <!-- / Content -->



        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // function getQueryParameter(name) {
            //     // Extract query parameters from the URL
            //     var urlParams = new URLSearchParams(window.location.search);
            //     // Return the value of the specified parameter
            //     return urlParams.get(name);
            // }
            // var filterValue = getQueryParameter('filter') || 'all';
            // // console.log(filterValue)
            // $('#selectfilter option').each(function() {
            //     // Check if the value of the current option matches the valueToSelect
            //     if ($(this).val() == filterValue) {
            //         console.log(filterValue)
            //         console.log($(this).val())

            //         // Add the 'selected' attribute to the matching option
            //         $(this).prop('selected', true);
            //     }
            // });

            // Set the selected value of the select dropdown
            // $('#selectfilter').val(filterValue);

            $('#selectfilter').change(function() {
                var selectedFilter = $(this).val();
                var currentUrl = window.location.href;
                var url = currentUrl.split('?')[0] + '?filter=' + selectedFilter;
                console.log(url)
                window.location.href = url;
                // $('#test').load(url + " #test");
            })
        });
    </script>
@endsection
