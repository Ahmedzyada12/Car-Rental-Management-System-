@extends('layouts.master')
@section('title', 'بروفايل العميل')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-2"><span class="text-muted fw-light">employee Profile /</span>
            </h4>
            <form action="/admin/employee/profile/{{ $id }}" method="get">

                <!------------------------filter by month--------------->
                <div class="card mb-4" id="sss">
                    <div class="card-widget-separator-wrapper">
                        <div class="card-body card-widget-separator">
                            <div class="row gy-4 gy-sm-1 mb-3">
                                <label for="selectfiltermonth" class="form-label">month</label>
                                <select id="selectfiltermonth" name="month" class="select2 form-select form-select-lg"
                                    data-allow-clear="true">

                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?> </select>
                            </div>
                            <div class="row gy-4 gy-sm-1">
                                <label for="selectfilteryear" class="form-label1">year</label>
                                <select id="selectfilteryear" name="year" class="select2 form-select form-select-lg"
                                    onchange="this.form.submit()" data-allow-clear="true">
                                    <option value="اختر السنه" selected disabled>اختر السنه</option>

                                    @for ($year = date('Y'); $year >= 2023; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                </div>






            </form>
            {{-- <div class="offcanvas offcanvas-end company-cust" id="add-new-record">

                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('customers/customers_trans.New Record') }}
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body flex-grow-1">
                    <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                        <input class="comp-cust" type="hidden" name="parent_id" value="">
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
            </div> --}}
            <div class="card" id="test">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic-employee_profile table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>id</th>
                                <th>المبلغ</th>
                                <th>الشهر</th>
                                <th>السنه</th>
                                <th>التاريخ</th>
                                <th>actions</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>





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

                    //         $('#selectfiltermonth').change(function() {
                    //             var selectedFilter = $(this).val();
                    //             var currentUrl = window.location.href;
                    //             var url = currentUrl.split('?')[0] + '?filter=' + selectedFilter;
                    //             console.log(url)
                    //             window.location.href = url;
                    //             // $('#test').load(url + " #test");
                    //         })
                    //     });


                    //     $('#selectfilteryear').change(function() {
                    //             var selectedFilteryear = $(this).val();
                    //             var currentUrl = window.location.href;
                    //             var url = currentUrl.split('?')[0] + '?filter=' + selectedFilteryear;
                    //             console.log(url)
                    //             window.location.href = url;
                    //             // $('#test').load(url + " #test");
                    //         })

                    //
    </script>



@endsection
