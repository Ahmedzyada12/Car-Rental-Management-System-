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
        <!--/ DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic-vendor_orders table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('reservations/reservation_trans.starting date') }}</th>
                            <th>{{ trans('reservations/reservation_trans.customer name') }}</th>
                            <th>{{ trans('reservations/reservation_trans.Company Name') }}</th>
                            <th>{{ trans('reservations/reservation_trans.End date') }}</th>
                            <th>{{ trans('reservations/reservation_trans.drivers name') }}</th>
                            <th>{{ trans('drivers/drivers_trans.price') }}</th>
                            <th>{{ trans('reservations/reservation_trans.Destination price') }}</th>
                            {{-- <th>note</th> --}}
                            <th>{{ trans('reservations/reservation_trans.Order status') }}</th>
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


@endsection
