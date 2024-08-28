@extends('layouts.master')
@section('title', 'قائمة الطلبات')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Modal to add new record -->
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('sidebar_trans.Orders list') }}</h5>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('drivers/drivers_trans.New Record') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullname">{{ trans('reservations/reservation_trans.first Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="first_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="first_name" class="form-control dt-first_name" name="first_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label"
                            for="last_name">{{ trans('reservations/reservation_trans.last Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="last_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="last_name" class="form-control dt-last_name" name="last_name"
                                aria-describedby="last_name2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicPost">{{ trans('reservations/reservation_trans.Address') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="address" name="address" class="form-control dt-address"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicPost">{{ trans('reservations/reservation_trans.Phone') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="phone" name="phone" class="form-control dt-phone"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicEmail">{{ trans('reservations/reservation_trans.Email') }}</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="text" id="email" name="email" class="form-control dt-email" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="password">{{ trans('reservations/reservation_trans.password') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="password" class="input-group-text"><i class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password" id="password" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="password_confirmation">{{ trans('reservations/reservation_trans.password confirmation') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="password_confirmation" class="input-group-text"><i
                                    class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password_confirmation"
                                id="password_confirmation" name="password_confirmation" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('reservations/reservation_trans.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('companies/companies_trans.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!--/ DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic20 table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('reservations/reservation_trans.from') }}</th>
                            <th>{{ trans('reservations/reservation_trans.customer name') }}</th>
                            <th>{{ trans('reservations/reservation_trans.to') }} </th>
                            <th>{{ trans('reservations/reservation_trans.hours number') }} </th>
                            <th>{{ trans('reservations/reservation_trans.days number') }} </th>
                            <th>{{ trans('reservations/reservation_trans.destination') }}</th>
                            <th>{{ trans('reservations/reservation_trans.Order status') }}</th>
                            <th>action</th>
                            {{-- <th></th> --}}

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>

@endsection
@section('js')
    {{-- // <!-- Vendors JS --> --}}
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>

    {{-- // <!-- Main JS --> --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- // <!-- Page JS --> --}}
    <script src="{{ asset('assets/js/app-user-list.js') }}"></script>

    <script>
        // $(document).ready(function() {
        //     var dataTable = $('#DataTables_Table_0').DataTable();
        //     var dataId = 0;
        //     $('#DataTables_Table_0').on('draw.dt', function() {
        //         $('.orderStatus').on('click', function() {
        //             var span = $(this);
        //             var dataId = $(this).data('id');
        //             var link = '/admin/orders/status/' + dataId
        //             // console.log(dataId)
        //             $.ajax({
        //                 url: link,
        //                 type: 'GET',
        //                 success: function(response) {
        //                     console.log(response.status)
        //                     if (response.success == 1) {
        //                         span.removeClass('bg-label-warning')
        //                         span.removeClass('bg-label-success')
        //                         span.removeClass('bg-label-danger')
        //                         var spanClass = response.status == 'approved' ?
        //                             'success' :
        //                             response.status == 'rejected' ? 'danger' :
        //                             response.status == 'pending' ? 'warning' : '';
        //                         span.addClass('bg-label-' + spanClass)
        //                         span.text(response.status)
        //                     } else {
        //                         console.log(response.success)
        //                     }
        //                 },
        //                 error: function(error) {
        //                     console.error('AJAX error:', error);
        //                 }
        //             })
        //         })
        //     });
        // });

        // $(document).ready(function() {
        //     var dataTable = $('#DataTables_Table_0').DataTable();
        //     var dataId = 0;
        //     $('#DataTables_Table_0').on('draw.dt', function() {
        //         // $('.orderStatus').on('click', function() {
        //         $('.statusSelect').on('change', function() {
        //             var selectedValue = $(this).val();
        //             var dataId = $(this).data('id');
        //             console.log(dataId);
        //             var link = '/admin/orders/new_status/' + dataId + '/' + selectedValue
        //             $.ajax({
        //                 url: link,
        //                 type: 'GET',
        //                 success: function(response) {
        //                     console.log(response)
        //                 },
        //                 error: function(error) {
        //                     console.error('AJAX error:', error);
        //                 }
        //             })
        //         })
        //     });
        // });
    </script>
@endsection
