@extends('layouts.master')
@section('title', 'Car Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('content')
    <div class="content-wrapper">
        @if (auth()->user()->role == 0 || Auth::user()->role == 6)
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <!-- View sales -->
                    <div class="col-xl-4 mb-4 col-lg-5 col-12">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-7">
                                    <div class="card-body text-nowrap">
                                        <h5 class="card-title mb-0">{{ trans('dashboardadmin_trans.Hi') }}
                                            {{ auth()->user()->first_name }} ! 🎉</h5>
                                        <p class="mb-2">{{ trans('dashboardadmin_trans.Total price of this month') }}</p>
                                        <h4 class="text-primary mb-1">${{ $current_month }}</h4>
                                        <a href="{{ route('admin.orders.index') }}"
                                            class="btn btn-primary">{{ trans('dashboardadmin_trans.view sales') }}</a>
                                    </div>
                                </div>
                                <div class="col-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('assets/img/illustrations/card-advance-sale.png') }}"
                                            height="140" alt="view sales" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View sales -->

                    <!-- Statistics -->
                    <div class="col-xl-8 mb-4 col-lg-7 col-12">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title mb-0">{{ trans('dashboardadmin_trans.Statistics') }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                                <i class="fa-solid fa-building ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $companies }}</h5>
                                                <small>{{ trans('sidebar_trans.Companies') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge rounded-pill bg-label-info me-3 p-2">
                                                <i class="ti ti-users ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $customers }}</h5>
                                                <small>{{ trans('dashboardadmin_trans.Customers') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                                {{-- <i class="ti ti-shopping-cart ti-sm"></i> --}}
                                                <i class="fa-solid fa-id-card ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $drivers }}</h5>
                                                <small>{{ trans('sidebar_trans.Drivers') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{ $orders->count() }}</h5>
                                                    <small>{{ trans('sidebar_trans.Orders') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics -->

                    <div class="col-xl-4 col-12">
                        <div class="row">
                            <!-- Expenses -->
                            <div class="col-xl-6 mb-4 col-md-3 col-6">
                                <div class="card bg-info">
                                    <div class="card-header pb-0">
                                        <h5 class="card-title mb-0 text-white">
                                            {{ trans('dashboardadmin_trans.Total Orders') }}
                                        </h5>
                                        <small class="text-white">{{ $orders->count() }}</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="profitLastMonth"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0 text-white">{{ $orders->sum('price') }}$</h4>
                                            <small class="text-white">100%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Expenses -->

                            <!-- Profit last month -->
                            <div class="col-xl-6 mb-4 col-md-3 col-6">
                                <div class="card bg-success">
                                    <div class="card-header pb-0">
                                        <h5 class="card-title mb-0 text-white">
                                            {{ trans('dashboardadmin_trans.Approved Orders') }}</h5>
                                        <small
                                            class="text-white">{{ $orders->where('status', 'approved')->count() }}</small>

                                    </div>
                                    <div class="card-body">
                                        <div id="profitLastMonth"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0 text-white">
                                                {{ $orders->where('status', 'approved')->sum('price') }}$</h4>
                                            <small
                                                class="text-white">{{ number_format(($orders->where('status', 'approved')->sum('price') * 100) / $orders->sum('price'), 1) }}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Profit last month -->
                            <!-- Generated Leads -->
                            <div class="col-xl-6 mb-4 col-md-3 col-6">
                                <div class="card bg-warning">
                                    <div class="card-header pb-0">
                                        <h5 class="card-title mb-0 text-white">
                                            {{ trans('dashboardadmin_trans.Pending Orders') }}</h5>
                                        <small
                                            class="text-white">{{ $orders->where('status', 'pending')->count() }}</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="profitLastMonth"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0 text-white">
                                                {{ $orders->where('status', 'pending')->sum('price') }}$
                                            </h4>
                                            <small
                                                class="text-white">{{ number_format(($orders->where('status', 'pending')->sum('price') * 100) / $orders->sum('price'), 1) }}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4 col-md-3 col-6">
                                <div class="card bg-danger">
                                    <div class="card-header pb-0">
                                        <h5 class="card-title mb-0 text-white">
                                            {{ trans('dashboardadmin_trans.Rejected Orders') }}</h5>
                                        <small
                                            class="text-white">{{ $orders->where('status', 'rejected')->count() }}</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="profitLastMonth"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                            <h4 class="mb-0 text-white">
                                                {{ $orders->where('status', 'rejected')->sum('price') }}$</h4>
                                            <small
                                                class="text-white">{{ number_format(($orders->where('status', 'rejected')->sum('price') * 100) / $orders->sum('price'), 1) }}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Generated Leads -->
                        </div>
                    </div>

                    <!-- Revenue Report -->
                    <div class="col-12 col-xl-8 mb-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row row-bordered g-0">
                                    {{-- charts --}}
                                    <div class="col-md-8 position-relative p-4">
                                        <div class="card-header d-inline-block p-0 text-wrap position-absolute">
                                            <h5 class="m-0 card-title">Revenue Report</h5>
                                        </div>
                                        <div id="totalRevenueChart" class="mt-n1">
                                            {{--  --}}
                                            {{-- <div class="col-md-6 col-xxl-4 mb-4 order-1 order-xxl-3"> --}}
                                            <div class="">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div id="deliveryExceptionsChart" class=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--  --}}
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-4"
                                        style="display: flex;

                                justify-content: center;
                                flex-direction: column;">
                                        <select id="year-form" class="select2 form-select form-select-lg"
                                            data-allow-clear="true" name="year">
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                        </select>
                                        <h3 class="text-center pt-4 mb-0" id="year-price"></h3>

                                        <div class="text-center mt-4">
                                            <a href="admin/orders" class="btn btn-primary">All Orders</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-4">

                    <!-- Statistics -->
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-5">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                                <i class="ti ti-shopping-cart ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $orders->where('status', 'complete')->count() }}
                                                </h5>
                                                <small>Completed</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="divider divider-vertical">
                                            <div class="divider-text">
                                                <span class="badge-divider-bg bg-label-secondary">VS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                                <i class="ti ti-shopping-cart ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">
                                                    {{ $orders->whereIn('status', ['pending', 'approved'])->count() }}</h5>
                                                <small>Waiting</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- calender --}}
                <div class="card app-calendar-wrapper">
                    <div class="row g-0">
                        <!-- Calendar Sidebar -->
                        <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                            <div class="p-3">
                                <hr class="container-m-nx mb-4 mt-3" />
                                <div class="app-calendar-events-filter ms-3">
                                    <div class="form-check form-check-danger mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                            data-value="personal" checked />
                                        <label class="form-check-label" for="select-personal">Old</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                            data-value="business" checked />
                                        <label class="form-check-label" for="select-business">Normal</label>
                                    </div>

                                    <div class="form-check form-check-success mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                            data-value="holiday" checked />
                                        <label class="form-check-label" for="select-holiday">Almost</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Calendar & Modal -->
                        <div class="col app-calendar-content">
                            <div class="card shadow-none border-0">
                                <div class="card-body pb-0">
                                    <!-- FullCalendar -->
                                    <div id="calendar"></div>
                                </div>
                            </div>
                            <div class="app-overlay"></div>
                            <!-- FullCalendar Offcanvas -->
                            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                                aria-labelledby="addEventSidebarLabel">
                                <div class="offcanvas-header my-1">
                                    <h5 class="offcanvas-title" id="addEventSidebarLabel">Add
                                        Event</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body pt-0">
                                    <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                                        <div class="mb-3">
                                            {{-- <label class="form-label" for="eventTitle">Title</label> --}}
                                            {{-- <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                            placeholder="Event Title" /> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLabel">Label</label>
                                            <select class="select2 select-event-label form-select" id="eventLabel"
                                                name="eventLabel">
                                                <option data-label="primary" value="Business" selected>Business</option>
                                                <option data-label="danger" value="Personal">
                                                    Personal</option>
                                                <option data-label="warning" value="Family">Family
                                                </option>
                                                <option data-label="success" value="Holiday">
                                                    Holiday</option>
                                                <option data-label="info" value="ETC">ETC
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventStartDate">Start
                                                Date</label>
                                            <input type="text" class="form-control" id="eventStartDate"
                                                name="eventStartDate" placeholder="Start Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventEndDate">End
                                                Date</label>
                                            <input type="text" class="form-control" id="eventEndDate"
                                                name="eventEndDate" placeholder="End Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input allDay-switch" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">All Day</span>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventURL">Event
                                                URL</label>
                                            <input type="url" class="form-control" id="eventURL" name="eventURL"
                                                placeholder="https://www.google.com" />
                                        </div>
                                        <div class="mb-3 select2-primary">
                                            <label class="form-label" for="eventGuests">Add
                                                Guests</label>
                                            <select class="select2 select-event-guests form-select" id="eventGuests"
                                                name="eventGuests" multiple>
                                                <option data-avatar="1.png" value="Jane Foster">
                                                    Jane Foster</option>
                                                <option data-avatar="3.png" value="Donna Frank">
                                                    Donna Frank</option>
                                                <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle
                                                    Robertson
                                                </option>
                                                <option data-avatar="7.png" value="Lori Spears">
                                                    Lori Spears</option>
                                                <option data-avatar="9.png" value="Sandy Vega">
                                                    Sandy Vega</option>
                                                <option data-avatar="11.png" value="Cheryl May">
                                                    Cheryl May</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLocation">Location</label>
                                            <input type="text" class="form-control" id="eventLocation"
                                                name="eventLocation" placeholder="Enter Location" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventDescription">Description</label>
                                            <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                                <button type="reset"
                                                    class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                                    data-bs-dismiss="offcanvas">
                                                    Cancel
                                                </button>
                                            </div>
                                            <div><button
                                                    class="btn btn-label-danger btn-delete-event d-none">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Calendar & Modal -->
                    </div>
                </div>
            </div>
            @if (auth()->user()->role == 0)
                <div class="container-xxl flex-grow-1 container-p-y">

                    <div class="row mb-4">

                        <!-- Statistics -->
                        <div class="col-12">
                            <div class="card h-100">
                                <a href="{{ route('about') }}" class="btn btn-success">About Us</a>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        @endif

        <!--------vendor----------->
        @if (auth()->user()->role == 4)
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <!-- View sales -->
                    <div class="col-xl-4 mb-4 col-lg-5 col-12">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-7">
                                    <div class="card-body text-nowrap">
                                        <h5 class="card-title mb-0">{{ trans('dashboardadmin_trans.Hi') }}
                                            {{ auth()->user()->first_name }} ! 🎉</h5>
                                        <p class="mb-2">{{ trans('dashboardadmin_trans.Total price of this month') }}
                                        </p>
                                        <h4 class="text-primary mb-1">${{ $totalPrice }}</h4>
                                        <a href="{{ route('vendor.showOrders') }}"
                                            class="btn btn-primary">{{ trans('sidebar_trans.view orders') }}</a>
                                    </div>
                                </div>
                                <div class="col-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('assets/img/illustrations/card-advance-sale.png') }}"
                                            height="140" alt="view sales" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View sales -->

                    <!-- Statistics -->
                    <div class="col-xl-8 mb-4 col-lg-7 col-12">
                        <div class="card h-100">
                            <div class="card-header">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title mb-0">{{ trans('dashboardadmin_trans.Statistics') }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                                {{-- <i class="ti ti-shopping-cart ti-sm"></i> --}}
                                                <i class="fa-solid fa-id-card ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $totalDrivers }}</h5>
                                                <small>{{ trans('sidebar_trans.Drivers') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{ $totalOrders }}</h5>
                                                    <small>{{ trans('sidebar_trans.Orders') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{ $totalCars }}</h5>
                                                    <small>{{ trans('sidebar_trans.cars') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics -->


                    <!-- Revenue Report -->


                </div>
                <div class="row mb-4">
                    <!-- Expenses -->
                    <div class="col-6 col-xl-3 mb-3">
                        <div class="card bg-info">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('dashboardadmin_trans.Total Orders') }}
                                </h5>
                                <small class="text-white">{{ $totalOrders }}</small>
                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">{{ $orders->sum('price') }}$</h4>
                                    <small class="text-white">100%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Expenses -->

                    <!-- Profit last month -->
                    <div class="col-6 col-xl-3 mb-3">
                        <div class="card bg-success">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('dashboardadmin_trans.Approved Orders') }}</h5>
                                <small class="text-white">{{ $orders->where('status', 'approved')->count() }}</small>

                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">
                                        {{ $orders->where('status', 'approved')->sum('price') }}$</h4>
                                    <small
                                        class="text-white">{{ number_format(($orders->where('status', 'approved')->sum('price') * 100) / $orders->sum('price'), 1) }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Profit last month -->
                    <!-- Generated Leads -->
                    <div class="col-6 col-xl-3 mb-3">
                        <div class="card bg-warning">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('dashboardadmin_trans.Pending Orders') }}</h5>
                                <small class="text-white">{{ $orders->where('status', 'pending')->count() }}</small>
                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">
                                        {{ $orders->where('status', 'pending')->sum('price') }}$
                                    </h4>
                                    <small
                                        class="text-white">{{ number_format(($orders->where('status', 'pending')->sum('price') * 100) / $orders->sum('price'), 1) }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-3 mb-3">
                        <div class="card bg-danger">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('dashboardadmin_trans.Rejected Orders') }}</h5>
                                <small class="text-white">{{ $orders->where('status', 'rejected')->count() }}</small>
                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">
                                        {{ $orders->where('status', 'rejected')->sum('price') }}$</h4>
                                    <small
                                        class="text-white">{{ number_format(($orders->where('status', 'rejected')->sum('price') * 100) / $orders->sum('price'), 1) }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Generated Leads -->


                </div>
                <div class="row mb-4">

                    <!-- Statistics -->
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-5">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                                <i class="ti ti-shopping-cart ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">{{ $orders->where('status', 'complete')->count() }}
                                                </h5>
                                                <small>Completed</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="divider divider-vertical">
                                            <div class="divider-text">
                                                <span class="badge-divider-bg bg-label-secondary">VS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                                <i class="ti ti-shopping-cart ti-sm"></i>
                                            </div>
                                            <div class="card-info">
                                                <h5 class="mb-0">
                                                    {{ $orders->whereIn('status', ['pending', 'approved'])->count() }}</h5>
                                                <small>Waiting</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card app-calendar-wrapper">
                    <div class="row g-0">
                        <!-- Calendar Sidebar -->
                        <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                            <div class="p-3">
                                <hr class="container-m-nx mb-4 mt-3" />
                                <div class="app-calendar-events-filter ms-3">
                                    <div class="form-check form-check-danger mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                            data-value="personal" checked />
                                        <label class="form-check-label" for="select-personal">Old</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                            data-value="business" checked />
                                        <label class="form-check-label" for="select-business">Normal</label>
                                    </div>

                                    <div class="form-check form-check-success mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                            data-value="holiday" checked />
                                        <label class="form-check-label" for="select-holiday">Almost</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Calendar & Modal -->
                        <div class="col app-calendar-content">
                            <div class="card shadow-none border-0">
                                <div class="card-body pb-0">
                                    <!-- FullCalendar -->
                                    <div id="calendar-vendor"></div>
                                </div>
                            </div>
                            <div class="app-overlay"></div>
                            <!-- FullCalendar Offcanvas -->
                            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                                aria-labelledby="addEventSidebarLabel">
                                <div class="offcanvas-header my-1">
                                    <h5 class="offcanvas-title" id="addEventSidebarLabel">Add
                                        Event</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body pt-0">
                                    <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                                        <div class="mb-3">
                                            {{-- <label class="form-label" for="eventTitle">Title</label> --}}
                                            {{-- <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                            placeholder="Event Title" /> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLabel">Label</label>
                                            <select class="select2 select-event-label form-select" id="eventLabel"
                                                name="eventLabel">
                                                <option data-label="primary" value="Business" selected>Business</option>
                                                <option data-label="danger" value="Personal">
                                                    Personal</option>
                                                <option data-label="warning" value="Family">Family
                                                </option>
                                                <option data-label="success" value="Holiday">
                                                    Holiday</option>
                                                <option data-label="info" value="ETC">ETC
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventStartDate">Start
                                                Date</label>
                                            <input type="text" class="form-control" id="eventStartDate"
                                                name="eventStartDate" placeholder="Start Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventEndDate">End
                                                Date</label>
                                            <input type="text" class="form-control" id="eventEndDate"
                                                name="eventEndDate" placeholder="End Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input allDay-switch" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">All Day</span>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventURL">Event
                                                URL</label>
                                            <input type="url" class="form-control" id="eventURL" name="eventURL"
                                                placeholder="https://www.google.com" />
                                        </div>
                                        <div class="mb-3 select2-primary">
                                            <label class="form-label" for="eventGuests">Add
                                                Guests</label>
                                            <select class="select2 select-event-guests form-select" id="eventGuests"
                                                name="eventGuests" multiple>
                                                <option data-avatar="1.png" value="Jane Foster">
                                                    Jane Foster</option>
                                                <option data-avatar="3.png" value="Donna Frank">
                                                    Donna Frank</option>
                                                <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle
                                                    Robertson
                                                </option>
                                                <option data-avatar="7.png" value="Lori Spears">
                                                    Lori Spears</option>
                                                <option data-avatar="9.png" value="Sandy Vega">
                                                    Sandy Vega</option>
                                                <option data-avatar="11.png" value="Cheryl May">
                                                    Cheryl May</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLocation">Location</label>
                                            <input type="text" class="form-control" id="eventLocation"
                                                name="eventLocation" placeholder="Enter Location" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventDescription">Description</label>
                                            <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                                <button type="reset"
                                                    class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                                    data-bs-dismiss="offcanvas">
                                                    Cancel
                                                </button>
                                            </div>
                                            <div><button
                                                    class="btn btn-label-danger btn-delete-event d-none">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Calendar & Modal -->
                    </div>
                </div>


            </div>
            <div class="container-xxl flex-grow-1 container-p-y">

                <div class="row mb-4">

                </div>

            </div>
        @endif
        {{-- company calender --}}
        @if (auth()->user()->role == 1)
            @php
                $orders = \App\Models\Order::where('company_id', auth()->id());
                $orders_price = $orders->sum('price');
                $orders_count = $orders->count();
                $users = \App\Models\User::where('parent_id', auth()->id())->count();
            @endphp
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="py-3 mb-2">
                    <span class="text-muted fw-light">Company Profile /</span>
                    {{ auth()->user()->first_name }}
                </h4>
                <div class="card mb-4">
                    <div class="card-widget-separator-wrapper">
                        <div class="card-body card-widget-separator">
                            <div class="row gy-4 gy-sm-1">
                                <div class="col-sm-6 col-lg-4">
                                    <div
                                        class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                        <div>
                                            <h4 class="mb-2">{{ $orders_count }}</h4>
                                            <p class="mb-0 fw-medium">Orders</p>
                                        </div>
                                        <span class="avatar me-sm-4">
                                            <span class="avatar-initial bg-label-secondary rounded">
                                                <i class="ti-md ti ti-calendar-stats text-body"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <hr class="d-none d-sm-block d-lg-none me-4">
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div
                                        class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                        <div>
                                            <h4 class="mb-2">{{ $users }}</h4>
                                            <p class="mb-0 fw-medium">Customers</p>
                                        </div>
                                        <span class="avatar p-2 me-lg-4">
                                            <span class="avatar-initial bg-label-secondary rounded"><i
                                                    class="ti-md ti ti-checks text-body"></i></span>
                                        </span>
                                    </div>
                                    <hr class="d-none d-sm-block d-lg-none">
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div
                                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                        <div>
                                            <h4 class="mb-2">{{ $orders_price }}</h4>
                                            <p class="mb-0 fw-medium">Paid</p>
                                        </div>
                                        <span class="avatar p-2 me-sm-4">
                                            <span class="avatar-initial bg-label-secondary rounded"><i
                                                    class="ti-md ti ti-wallet text-body"></i></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card app-calendar-wrapper">
                    <div class="row g-0">
                        <!-- Calendar Sidebar -->
                        <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                            <div class="p-3">
                                <hr class="container-m-nx mb-4 mt-3" />
                                <div class="app-calendar-events-filter ms-3">
                                    <div class="form-check form-check-danger mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                            data-value="personal" checked />
                                        <label class="form-check-label" for="select-personal">Old</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                            data-value="business" checked />
                                        <label class="form-check-label" for="select-business">Normal</label>
                                    </div>

                                    <div class="form-check form-check-success mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                            data-value="holiday" checked />
                                        <label class="form-check-label" for="select-holiday">Almost</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Calendar & Modal -->
                        <div class="col app-calendar-content">
                            <div class="card shadow-none border-0">
                                <div class="card-body pb-0">
                                    <!-- FullCalendar -->
                                    <div id="calendar-company"></div>
                                </div>
                            </div>
                            <div class="app-overlay"></div>
                            <!-- FullCalendar Offcanvas -->
                            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                                aria-labelledby="addEventSidebarLabel">
                                <div class="offcanvas-header my-1">
                                    <h5 class="offcanvas-title" id="addEventSidebarLabel">Add
                                        Event</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body pt-0">
                                    <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                                        <div class="mb-3">
                                            {{-- <label class="form-label" for="eventTitle">Title</label> --}}
                                            {{-- <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                            placeholder="Event Title" /> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLabel">Label</label>
                                            <select class="select2 select-event-label form-select" id="eventLabel"
                                                name="eventLabel">
                                                <option data-label="primary" value="Business" selected>Business</option>
                                                <option data-label="danger" value="Personal">
                                                    Personal</option>
                                                <option data-label="warning" value="Family">Family
                                                </option>
                                                <option data-label="success" value="Holiday">
                                                    Holiday</option>
                                                <option data-label="info" value="ETC">ETC
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventStartDate">Start
                                                Date</label>
                                            <input type="text" class="form-control" id="eventStartDate"
                                                name="eventStartDate" placeholder="Start Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventEndDate">End
                                                Date</label>
                                            <input type="text" class="form-control" id="eventEndDate"
                                                name="eventEndDate" placeholder="End Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input allDay-switch" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">All Day</span>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventURL">Event
                                                URL</label>
                                            <input type="url" class="form-control" id="eventURL" name="eventURL"
                                                placeholder="https://www.google.com" />
                                        </div>
                                        <div class="mb-3 select2-primary">
                                            <label class="form-label" for="eventGuests">Add
                                                Guests</label>
                                            <select class="select2 select-event-guests form-select" id="eventGuests"
                                                name="eventGuests" multiple>
                                                <option data-avatar="1.png" value="Jane Foster">
                                                    Jane Foster</option>
                                                <option data-avatar="3.png" value="Donna Frank">
                                                    Donna Frank</option>
                                                <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle
                                                    Robertson
                                                </option>
                                                <option data-avatar="7.png" value="Lori Spears">
                                                    Lori Spears</option>
                                                <option data-avatar="9.png" value="Sandy Vega">
                                                    Sandy Vega</option>
                                                <option data-avatar="11.png" value="Cheryl May">
                                                    Cheryl May</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLocation">Location</label>
                                            <input type="text" class="form-control" id="eventLocation"
                                                name="eventLocation" placeholder="Enter Location" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventDescription">Description</label>
                                            <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                                <button type="reset"
                                                    class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                                    data-bs-dismiss="offcanvas">
                                                    Cancel
                                                </button>
                                            </div>
                                            <div><button
                                                    class="btn btn-label-danger btn-delete-event d-none">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Calendar & Modal -->
                    </div>
                </div>
            </div>
        @endif

        {{-- driver calender --}}
        @if (auth()->user()->role == 2)
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card app-calendar-wrapper">
                    <div class="row g-0">
                        <!-- Calendar Sidebar -->
                        <div class="col app-calendar-sidebar" id="app-calendar-sidebar">
                            <div class="p-3">
                                <hr class="container-m-nx mb-4 mt-3" />
                                <div class="app-calendar-events-filter ms-3">
                                    <div class="form-check form-check-danger mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-personal"
                                            data-value="personal" checked />
                                        <label class="form-check-label" for="select-personal">Old</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-business"
                                            data-value="business" checked />
                                        <label class="form-check-label" for="select-business">Normal</label>
                                    </div>

                                    <div class="form-check form-check-success mb-2">
                                        <input class="form-check-input input-filter" type="checkbox" id="select-holiday"
                                            data-value="holiday" checked />
                                        <label class="form-check-label" for="select-holiday">Almost</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Calendar & Modal -->
                        <div class="col app-calendar-content">
                            <div class="card shadow-none border-0">
                                <div class="card-body pb-0">
                                    <!-- FullCalendar -->
                                    <div id="calendar-driver"></div>
                                </div>
                            </div>
                            <div class="app-overlay"></div>
                            <!-- FullCalendar Offcanvas -->
                            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                                aria-labelledby="addEventSidebarLabel">
                                <div class="offcanvas-header my-1">
                                    <h5 class="offcanvas-title" id="addEventSidebarLabel">Add
                                        Event</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body pt-0">
                                    <form class="event-form pt-0" id="eventForm" onsubmit="return false">
                                        <div class="mb-3">
                                            {{-- <label class="form-label" for="eventTitle">Title</label> --}}
                                            {{-- <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                            placeholder="Event Title" /> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLabel">Label</label>
                                            <select class="select2 select-event-label form-select" id="eventLabel"
                                                name="eventLabel">
                                                <option data-label="primary" value="Business" selected>Business</option>
                                                <option data-label="danger" value="Personal">
                                                    Personal</option>
                                                <option data-label="warning" value="Family">Family
                                                </option>
                                                <option data-label="success" value="Holiday">
                                                    Holiday</option>
                                                <option data-label="info" value="ETC">ETC
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventStartDate">Start
                                                Date</label>
                                            <input type="text" class="form-control" id="eventStartDate"
                                                name="eventStartDate" placeholder="Start Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventEndDate">End
                                                Date</label>
                                            <input type="text" class="form-control" id="eventEndDate"
                                                name="eventEndDate" placeholder="End Date" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input allDay-switch" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"></span>
                                                    <span class="switch-off"></span>
                                                </span>
                                                <span class="switch-label">All Day</span>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventURL">Event
                                                URL</label>
                                            <input type="url" class="form-control" id="eventURL" name="eventURL"
                                                placeholder="https://www.google.com" />
                                        </div>
                                        <div class="mb-3 select2-primary">
                                            <label class="form-label" for="eventGuests">Add
                                                Guests</label>
                                            <select class="select2 select-event-guests form-select" id="eventGuests"
                                                name="eventGuests" multiple>
                                                <option data-avatar="1.png" value="Jane Foster">
                                                    Jane Foster</option>
                                                <option data-avatar="3.png" value="Donna Frank">
                                                    Donna Frank</option>
                                                <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle
                                                    Robertson
                                                </option>
                                                <option data-avatar="7.png" value="Lori Spears">
                                                    Lori Spears</option>
                                                <option data-avatar="9.png" value="Sandy Vega">
                                                    Sandy Vega</option>
                                                <option data-avatar="11.png" value="Cheryl May">
                                                    Cheryl May</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventLocation">Location</label>
                                            <input type="text" class="form-control" id="eventLocation"
                                                name="eventLocation" placeholder="Enter Location" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="eventDescription">Description</label>
                                            <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                                <button type="reset"
                                                    class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                                    data-bs-dismiss="offcanvas">
                                                    Cancel
                                                </button>
                                            </div>
                                            <div><button
                                                    class="btn btn-label-danger btn-delete-event d-none">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Calendar & Modal -->
                    </div>
                </div>
            </div>
        @endif

        @if (auth()->user()->role == 5)
            @php
                $paidCount = \App\Models\Invoice::where('status', 1)->count();
                $unpaidCount = \App\Models\Invoice::where('status', 2)->count();
                $partialCount = \App\Models\Invoice::where('status', 3)->count();
                $invoicesCount = $paidCount + $unpaidCount + $partialCount;

                $invoicesPrice = \App\Models\Invoice::sum('amount');
                $paidPrice = \App\Models\Invoice::where('status', 1)->sum('amount');
                $unpaidPrice = \App\Models\Invoice::where('status', 2)->sum('amount');
                $partialpaidPrice = \App\Models\Invoice::where('status', 3)->sum('amount');

            @endphp
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="py-3 mb-2">
                    <span class="text-muted fw-light">{{ trans('companies/companies_trans.Accountant Profile') }} /</span>
                    {{ auth()->user()->first_name }}
                </h4>

                <div class="row">
                    <!-- Expenses -->
                    <div class="col-xl-3 mb-4 col-6">
                        <div class="card bg-info">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('companies/companies_trans.total invoices') }}
                                </h5>
                                <small class="text-white">{{ $invoicesCount }}</small>
                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">{{ $invoicesPrice }}$</h4>
                                    <small class="text-white">100%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Expenses -->
                    <!-- Profit last month -->
                    <div class="col-xl-3 mb-4 col-6">
                        <div class="card bg-success">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('companies/companies_trans.paid invoices') }}</h5>
                                <small class="text-white">{{ $paidCount }}</small>

                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">
                                        {{ $paidPrice }}$</h4>
                                    <small
                                        class="text-white">{{ number_format(($paidPrice * 100) / $invoicesPrice, 1) }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Profit last month -->
                    <!-- Generated Leads -->
                    <div class="col-xl-3 mb-4 col-6">
                        <div class="card bg-danger">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('companies/companies_trans.unpaid invoices') }}</h5>
                                <small class="text-white">{{ $unpaidCount }}</small>
                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">
                                        {{ $unpaidPrice }}$
                                    </h4>
                                    <small
                                        class="text-white">{{ number_format(($unpaidPrice * 100) / $invoicesPrice, 1) }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 mb-4 col-6">
                        <div class="card bg-warning">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0 text-white">
                                    {{ trans('companies/companies_trans.partial paid invoices') }}</h5>
                                <small class="text-white">{{ $partialCount }}</small>
                            </div>
                            <div class="card-body">
                                <div id="profitLastMonth"></div>
                                <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
                                    <h4 class="mb-0 text-white">
                                        {{ $partialpaidPrice }}$</h4>
                                    <small
                                        class="text-white">{{ number_format(($partialpaidPrice * 100) / $invoicesPrice, 1) }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Generated Leads -->
                </div>

                {{-- datatable for accountant --}}
                <div class="card">
                    @if (session('mail'))
                        <div class="alert alert-success" role="alert">
                            {{ session('mail') }}
                        </div>
                    @endif
                    @if (session('not_found'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('not_found') }}
                        </div>
                    @endif
                    <div class="card-datatable table-responsive pt-0">
                        <table class="datatables-basic50 table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>id</th>
                                    <th>{{ trans('invoices/invoices_trans.customer') }}</th>
                                    <th>{{ trans('invoices/invoices_trans.due date') }}</th>
                                    <th>{{ trans('invoices/invoices_trans.amount') }}</th>
                                    <th>{{ trans('invoices/invoices_trans.paid') }}</th>
                                    <th>{{ trans('invoices/invoices_trans.Remaining') }}</th>
                                    <th>{{ trans('invoices/invoices_trans.status') }}</th>
                                    <th>{{ trans('vehicles sections/vehicles_trans.Actions') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal fade" id="invoicemodal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                            <div class="modal-content p-3 p-md-5">

                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <form action="{{ route('admin.invoice.changeStatus') }}" method="post"
                                        id="residualCustodyForm" class="row g-3">
                                        @csrf
                                        <div class="text-center mb-4">
                                            <h3 class="mb-2">{{ trans('invoices/invoices_trans.change status') }}</h3>
                                        </div>
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="">
                                        {{-- <input type="hidden" class="employeeAmount" name="employeeAmount" value=""> --}}

                                        <div class="row">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="basic-default-firstname">{{ trans('invoices/invoices_trans.status') }}</label>
                                                <select id="status-select" style="padding: 5px 10px"
                                                    class="form-select form-select-lg {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                                    data-allow-clear="true" name="status">
                                                    <option value="2">{{ trans('invoices/invoices_trans.Unpaid') }}
                                                    </option>
                                                    <option value="1">{{ trans('invoices/invoices_trans.paid') }}
                                                    </option>
                                                    <option value="3">
                                                        {{ trans('invoices/invoices_trans.Partially paid') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row" id="on_simi_paid"
                                            style="display: none; {{ session('more_than') ? 'display:flex;' : '' }}">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="paid">{{ trans('invoices/invoices_trans.paid') }}</label>
                                                    <input type="text"
                                                        class="form-control {{ $errors->has('paid') ? 'is-invalid' : '' }}"
                                                        id="paid" placeholder="99" name="paid"
                                                        value="{{ old('paid') }}" />
                                                    @if (session('more_than'))
                                                        <span class="text-danger">{{ session('more_than') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="due-paid">{{ trans('invoices/invoices_trans.Remaining') }}</label>
                                                    <input type="text" disabled class="form-control" id="due-paid"
                                                        value="" />
                                                    @if ($errors->has('more_than'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('more_than') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit"
                                                class="btn btn-primary me-sm-3 me-1">{{ trans('drivers/drivers_trans.Submit') }}</button>
                                            <button type="reset" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                {{ trans('companies/companies_trans.Cancel') }}
                                            </button>
                                        </div>


                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>


    <!-- /Noui Slider -->
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/app-logistics-dashboard.js') }}"></script>

    <script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
    @if (auth()->user()->role == 0 || auth()->user()->role == 6)
        <script src="{{ asset('assets/js/app-calendar.js') }}"></script>
    @endif
    @if (auth()->user()->role == 1)
        <script src="{{ asset('assets/js/app-calendar-company.js') }}"></script>
    @endif
    @if (auth()->user()->role == 2)
        <script src="{{ asset('assets/js/app-calendar-driver.js') }}"></script>
    @endif
    @if (auth()->user()->role == 4)
        <script src="{{ asset('assets/js/app-calendar-vendor.js') }}"></script>
    @endif

    <script src="{{ asset('assets/vendor/libs/fullcalendar/fullcalendar.js') }}"></script>
    <script>
        function getYearPrice() {
            var selectedValue = $('#year-form').val();
            console.log(selectedValue)
            $.ajax({
                type: 'GET',
                url: 'year/' + selectedValue,
                success: function(response) {
                    $('#year-price').text('$' + response.price)
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
        var currentYear = <?php echo date('Y'); ?>;
        $('#year-form').val(currentYear);
        getYearPrice();
        $('#year-form').change(getYearPrice);
    </script>

    // for accountant
    <script>
        $(window).ready(function() {

            $("body").on('click', '.invoiceclass', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var amount = $(this).data('amount');
                var paid = $(this).data('paid');
                var remaining = $(this).data('remaining');
                console.log([id, status, amount, paid, remaining]);

                $('#invoice_id').val(id);
                $('#due-paid').data('total', remaining);
                console.log($('#due-piad').data('total'))
                // var staus_select = $('#status-select').val();
                $('#status-select option').each(function() {
                    if ($(this).val() == status) {
                        $(this).prop('selected', true);
                        if (status == 3) {
                            $('#on_simi_paid').show()
                        } else {
                            $('#on_simi_paid').hide()
                        }
                    }
                });
                // $('#paid').val(paid);
                $('#due-paid').val(remaining);

            })
            // var remaining = $('#due-paid').val();
            $('#paid').on('change', function() {
                var remaining = $('#due-paid').val();
                console.log(remaining);
                console.log($(this).val());
                if (parseFloat($(this).val()) > parseFloat(remaining)) {
                    alert('Paid amount cannot be greater than the total remaining');
                    $(this).val('');
                } else {
                    // var price = $('#due-paid').data(amount);
                    console.log(parseFloat(remaining) - parseFloat($(this).val()))
                    $('#due-paid').val(parseFloat(remaining) - parseFloat($(this).val()));
                }
            });
        });
    </script>
    <script>
        $('#status-select').on('change', function() {
            var value = $(this).val()
            // console.log(value)
            if (value == 3) {
                $('#on_simi_paid').show()
            } else {
                $('#on_simi_paid').hide()
            }
        })
    </script>
@endsection
