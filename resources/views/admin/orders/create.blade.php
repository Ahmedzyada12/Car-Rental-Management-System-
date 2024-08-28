@extends('layouts.master')
@section('title', 'Add Booking')

@section('css')
    <style>
        .email-c {
            display: none
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-2"><span class="text-muted fw-light"> {{ trans('reservations/reservation_trans.add') }}
                    /</span> {{ trans('reservations/reservation_trans.new order') }} </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('reservations/reservation_trans.Add a order') }}</h5>
                            <small
                                class="text-muted float-end">{{ trans('reservations/reservation_trans.Add a order') }}</small>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    Fail to create the Booking, complete all inputs
                                </div>
                            @endif
                            <form id="final_order" action="{{ route('admin.orders.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="col-md-6 col-12 mb-4">

                                        <label for="flatpickr-multi"
                                            class="form-label">{{ trans('reservations/reservation_trans.from') }}</label>
                                        {{-- <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM"
                                            id="flatpickr-multi" name='date_from' /> --}}
                                        <input type="text"
                                            class="form-control flatpickr-input {{ $errors->has('date_from') ? 'is-invalid' : '' }}"
                                            name='date_from' placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime">
                                    </div>
                                    <div class="col-md-6 col-12 mb-4">
                                        <label for="flatpickr-multi2"
                                            class="form-label">{{ trans('reservations/reservation_trans.to') }}</label>
                                        {{-- <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM"
                                            id="flatpickr-multi2" name='date_to' /> --}}
                                        <input type="text"
                                            class="form-control flatpickr-input {{ $errors->has('date_to') ? 'is-invalid' : '' }}"
                                            name='date_to' placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime2">
                                    </div>
                                </div>
                                {{-- @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="card bg-danger text-white mb-4 p-2 ps-3 " id="data-massage"
                                    style="display: none;">
                                </div> --}}

                                <!-- Basic -->
                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('reservations/reservation_trans.Choose a section') }}</label>
                                    <select id="category-select" required
                                        class="select2 form-select form-select-lg {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="category">
                                        <option value="" disabled selected>
                                            {{ trans('reservations/reservation_trans.Choose a section') }}</option>
                                        @foreach ($categoery as $categoery_val)
                                            <option value="{{ $categoery_val->category_id }}">{{ $categoery_val->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="col-md-12 mb-4" style="display: none;" id='cars-div'>
                                    <label for="cars-select"
                                        class="form-label">{{ trans('reservations/reservation_trans.Choose a car') }}</label>
                                    <select id="cars-select" required
                                        class="select2 form-select form-select-lg {{ $errors->has('car_id') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="car_id">
                                    </select>
                                </div>
                                <!-- fawzi -->
                                {{--
                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('reservations/reservation_trans.Choose the manager') }}</label>
                                    <select id="admin-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('admin_id') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="admin_id">
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->user_id }}">
                                                {{ $admin->first_name . ' ' . $admin->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('customers/customers_trans.choose company') }}</label>
                                    <select id="company-select" required
                                        class="select2 form-select form-select-lg {{ $errors->has('company_id') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="company_id">
                                        <option value='' disabled selected>
                                            {{ trans('customers/customers_trans.choose company') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->user_id }}">
                                                {{ $company->first_name . ' ' . $company->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-destination">
                                        {{ trans('reservations/reservation_trans.The destination') }}</label>
                                    <select placeholder="select destination" class="select2 form-select form-select-lg"
                                        name="destination" data-allow-clear="true" id="destination">
                                    </select>
                                </div>

                                <div class="col-md-12 mb-4" id="customer-div">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('reservations/reservation_trans.Select the client') }}</label>
                                    <div style="" class="d-flex align-items-center gap-2 ">
                                        <div class="flex-grow-1">
                                            <select id="customer-select" required
                                                class="select2 form-select form-select-lg {{ $errors->has('customer_id') ? 'is-invalid' : '' }}"
                                                data-allow-clear="true" name="customer_id">
                                                {{-- @foreach ($customers as $customer)
                                                    <option value="{{ $customer->user_id }}">{{ $customer->first_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <button type="button" style="width: fit-content" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal-add-client">
                                            {{ trans('reservations/reservation_trans.Add a client') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('reservations/reservation_trans.Select the driver') }}</label>
                                    <div style="" class="d-flex align-items-center gap-2 ">
                                        <div class="flex-grow-1">
                                            <select id="driver-select" required
                                                class="select2 form-select form-select-lg {{ $errors->has('driver_id') ? 'is-invalid' : '' }}"
                                                data-allow-clear="true" name="driver_id">
                                                @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->user_id }}">
                                                        {{ $driver->first_name . ' ' . $driver->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" style="width: fit-content" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal-add-driver">
                                            {{ trans('sidebar_trans.Add driver') }}
                                        </button>
                                    </div>
                                </div>
                                <!-- fawzi -->
                                <div class="col-md-12 mb-4">

                                    <div id='price-calc' style="display: none;">
                                        <div class="row" id= "basic-default-price">
                                            <div class="mb-3 col">
                                                <label class="form-label" for="basic-default-hourlyprice">
                                                    {{ trans('reservations/reservation_trans.number of hours') }}</label>
                                                <input type="text" required
                                                    class="form-control {{ $errors->has('hours') ? 'is-invalid' : '' }}"
                                                    id="basic-default-hourlyprice"
                                                    placeholder="{{ trans('reservations/reservation_trans.number of hours') }}"
                                                    name="hours" value="{{ old('hours', 0) }}" />
                                            </div>

                                            <div class="mb-3 col">
                                                <label class="form-label" for="basic-default-dailyprice">
                                                    {{ trans('reservations/reservation_trans.number of days') }}</label>
                                                <input type="text" required
                                                    class="form-control {{ $errors->has('days') ? 'is-invalid' : '' }}"
                                                    id="basic-default-dailyprice"
                                                    placeholder="{{ trans('reservations/reservation_trans.number of days') }}"
                                                    name="days" value="{{ old('days', 0) }}" />
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-price">
                                                {{ trans('reservations/reservation_trans.total') }}</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                                id="basic-default-total"
                                                placeholder="{{ trans('reservations/reservation_trans.total') }}"
                                                name="price" value="{{ old('price') }}" />
                                            @if ($errors->has('price'))
                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- destination removed --}}

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="note">{{ trans('reservations/reservation_trans.Note') }}</label>
                                    {{-- <input type="text" class="form-control" id="note" placeholder="note"
                                        name="note" value="{{ old('note') }}" /> --}}
                                    <textarea name="note" placeholder="note" class="form-control">{{ old('note') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary"
                                    id="button-submit">{{ trans('reservations/reservation_trans.Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end Form -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal-add-client" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        {{ trans('reservations/reservation_trans.Add a client') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.customer.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="order" value="order">
                        <div class="mb-3">
                            <label for="select2Basic"
                                class="form-label">{{ trans('customers/customers_trans.choose company') }}</label>
                            <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true"
                                name="parent_id" required>
                                <option value="" disabled selected>
                                    {{ trans('reservations/reservation_trans.select') }}</option>
                                @foreach ($companys as $companys_val)
                                    <option value="{{ $companys_val->user_id }}">{{ $companys_val->first_name }}
                                        {{ $companys_val->last_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('parent_id'))
                                <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-firstname">{{ trans('reservations/reservation_trans.first Name') }}</label>
                            <input type="text" required
                                class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                id="basic-default-firstname"
                                placeholder="{{ trans('reservations/reservation_trans.first Name') }}" name="first_name"
                                value="{{ old('first_name') }}" />
                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-lastname">{{ trans('reservations/reservation_trans.last Name') }}</label>
                            <input type="text" required
                                class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                id="basic-default-lastname"
                                placeholder="{{ trans('reservations/reservation_trans.last Name') }}" name="last_name"
                                value="{{ old('last_name') }}" />
                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-address">{{ trans('reservations/reservation_trans.Address') }}</label>
                            <input type="text" required
                                class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                id="basic-default-address"
                                placeholder="{{ trans('reservations/reservation_trans.Address') }}" name="address"
                                value="{{ old('address') }}" />
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-phone">{{ trans('reservations/reservation_trans.Phone') }}</label>
                            <input type="text" id="basic-default-phone"
                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                placeholder="658 799 8941" name="phone" value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ trans('reservations/reservation_trans.Cancel') }}</button>
                            <button type="submit"
                                class="btn btn-primary">{{ trans('reservations/reservation_trans.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal-add-driver" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ trans('drivers/drivers_trans.Add a driver') }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.drivers.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="order" value="order">
                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-firstname">{{ trans('reservations/reservation_trans.first Name') }}</label>
                            <input type="text"
                                class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                id="basic-default-firstname"
                                placeholder="{{ trans('reservations/reservation_trans.first Name') }}" name="first_name"
                                value="{{ old('first_name') }}" />
                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-lastname">{{ trans('reservations/reservation_trans.last Name') }}</label>
                            <input type="text" required
                                class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                id="basic-default-lastname"
                                placeholder="{{ trans('reservations/reservation_trans.last Name') }}" name="last_name"
                                value="{{ old('last_name') }}" />
                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-address">{{ trans('reservations/reservation_trans.Address') }}</label>
                            <input type="text" required
                                class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                id="basic-default-address"
                                placeholder="{{ trans('reservations/reservation_trans.Address') }}" name="address"
                                value="{{ old('address') }}" />
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-email">{{ trans('reservations/reservation_trans.Email') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="email" id="basic-default-email" required
                                    class="check-email-input form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    placeholder="email@example.com" name="email" value="{{ old('email') }}"
                                    aria-describedby="basic-default-email2" />
                                <span class="input-group-text" id="basic-default-email2">email@example.com</span>
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                            <span id="check-email" style="display: none" class="text-danger">
                                هذا الايميل موجود بالفعل
                            </span>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label"
                                for="multicol-password">{{ trans('reservations/reservation_trans.password') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="multicol-password" required
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-password2" />
                                <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label"
                                for="multicol-password-confirmation">{{ trans('drivers/drivers_trans.password confirmation') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" required id="multicol-password-confirmation"
                                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    name="password_confirmation"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-password2" />
                                <span class="input-group-text cursor-pointer" id="multicol-password2-confirmation"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                            <span id="check-pass" style="display: none" class="text-danger">
                                كلمة السر غير متطابقة
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-phone">{{ trans('reservations/reservation_trans.Phone') }}</label>
                            <input type="text" id="basic-default-phone" required
                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                placeholder="658 799 8941" name="phone" value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label"
                                for="basic-default-phone">{{ trans('drivers/drivers_trans.Driver price') }}</label>
                            <input type="text" required id="basic-default-phone"
                                class="form-control {{ $errors->has('driver_price') ? 'is-invalid' : '' }}"
                                placeholder="{{ trans('drivers/drivers_trans.Driver price') }}" name="driver_price"
                                value="{{ old('driver_price') }}" />
                            @if ($errors->has('driver_price'))
                                <span class="text-danger">{{ $errors->first('driver_price') }}</span>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ trans('companies/companies_trans.Cancel') }}</button>
                            <button type="submit"
                                class="btn btn-primary">{{ trans('reservations/reservation_trans.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    {{-- for destination --}}
    <script>
        $('#company-select').on('change', function() {
            var companyId = $(this).val();
            $.ajax({
                url: '/admin/orders/getdists/' + companyId,
                method: 'GET',
                success: function(response) {
                    $('#destination').empty();
                    console.log(response)
                    $.each(response, function(index, item) {
                        var optionText = item.destination.from + ' -> to -> ' + item.destination
                            .to;
                        var optionValue = item.id;
                        var optionPrice = item.price;
                        $('#destination').append(
                            '<option value="" disabled selected>Select Destination</option>'
                        );

                        $('#destination').append('<option value="' + optionValue +
                            '" data-price="' + optionPrice + '">' + optionText + '</option>'
                        );
                    });
                    // $.each(response, function(key, value) {
                    //     customerSelect.append('<option value="' +
                    //         key + '"> ' + value + '</option>')
                    // });
                }
            });
        });
    </script>
    <script type="text/javascript">
        var baseUrl2 = "{{ route('admin.orders.getcustomers', ['id' => 'tempId']) }}";
        baseUrl2 = baseUrl2.replace('tempId', ''); // Remove the placeholder
        $('#company-select').on('change', function() {
            var companyId = $(this).val();
            var customerSelect = $('#customer-select');
            $.ajax({
                url: baseUrl2 + companyId,
                method: 'GET',
                success: function(response) {
                    customerSelect.empty();
                    $.each(response, function(key, value) {
                        customerSelect.append('<option value="' +
                            value.user_id + '"> ' + value.first_name + " " + value
                            .last_name + '</option>')
                    });
                }
            });
        });



        var baseUrl3 =
            "{{ route('admin.orders.getPrice', ['id' => 'tempId', 'driver_id' => 'tempDriver', 'hours' => 'temphours', 'days' => 'tempdaily', 'dist_id' => 'tempId']) }}";


        $('#cars-select').on('change', function() {
            var car_id = $(this).val();

            if (car_id) {
                // If a car is selected (car_id is not empty), show price-calc
                $('#price-calc').show();
            } else {
                // If no car is selected, hide price-calc
                $('#price-calc').hide();
            }
        });

        function getPrice() {
            var car_id = $('#cars-select').val();
            var driver_id = $('#driver-select').val();
            var houreprice = $('#basic-default-hourlyprice').val();
            var dailyprice = $('#basic-default-dailyprice').val();
            var dist_id = $('#destination').val();
            var totalPrice = $('basic-default-total');
            houreprice = houreprice ? houreprice : 0;
            dailyprice = dailyprice ? dailyprice : 0;
            dist_id = dist_id ? dist_id : 0;
            // var finalUrl = baseUrl3.replace('tempId', car_id).replace('tempDriver', driver_id).replace('temphours',
            //     houreprice).replace('tempdaily', dailyprice);
            var finalUrl = '/admin/orders/getprice/' + car_id + '/' + driver_id + '/' + houreprice + '/' +
                dailyprice + '/' + dist_id;
            $.ajax({
                url: finalUrl,
                method: 'GET',
                success: function(response) {
                    totalPrice.empty();
                    console.log(response.total_price);
                    $('#basic-default-total').val(response.total_price);

                }
            });
        }

        $('#driver-select').on('change', getPrice)
        $('#basic-default-hourlyprice').on('keyup', getPrice)
        $('#basic-default-dailyprice').on('keyup', getPrice)
        $('#destination').on('change', getPrice)
        $('#company-select').on('change', getPrice)
        $('#cars-select').on('change', getPrice)




        function checkDateRange() {
            var dateFrom = $('#flatpickr-datetime').val();
            var dateTo = $('#flatpickr-datetime2').val();

            // Ensure both dates are selected
            if (dateFrom && dateTo) {
                $.ajax({
                    url: "{{ route('admin.orders.check-dates-ajax') }}", // Adjust the URL as needed
                    type: 'POST',
                    data: {
                        date_from: dateFrom,
                        date_to: dateTo,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        if (response.status == 'error') {
                            // If there is an error, show the message
                            console.log(response.status);
                            $('#data-massage').text(response.message).show();
                        }

                        if (response.status == 'success') {
                            console.log(response.status);
                            // If the response is successful, clear and hide the message
                            $('#data-massage').text('').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                    }
                });
            } else {
                console.log('not sending')
            }
        }
        // $('#flatpickr-datetime').on('change', checkDateRange)
        // $('#flatpickr-datetime2').on('change', checkDateRange)
    </script>
    <script>
        var flatpickrDateTime = document.querySelector("#flatpickr-datetime");
        flatpickrDateTime.flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });

        var flatpickrDateTime2 = document.querySelector("#flatpickr-datetime2");
        flatpickrDateTime2.flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today"
        });
    </script>
    <script>
        $("#multicol-password-confirmation").on("blur", function() {
            // Get the values of both password fields
            var password = $("#multicol-password").val();
            var confirmPassword = $(this).val();

            // Compare the values
            if (password != confirmPassword) {
                // Display error message if passwords do not match
                $("#check-pass").show();
            } else {
                // Hide error message if passwords match
                $("#check-pass").hide();
            }
        });

        // check email
        var email = 'sss';

        console.log($('.check-email-input'));
        $('.check-email-input').on('blur', function() {
            var email = $(this).val();
            console.log(email)

            // Make an AJAX request to check if the email exists
            $.ajax({
                type: 'GET',
                url: '/admin/driver/check-email/' + email,
                success: function(response) {
                    console.log(response)
                    if (response.exist) {
                        $("#check-email").show();
                    } else {
                        $("#check-email").hide();
                    }
                },
                error: function(error) {
                    console.error('Error checking email:', error);
                }
            });
        });
    </script>

    {{-- for final validate --}}
    <script>
        document.getElementById('final_order').addEventListener('submit', function(event) {
            var dateInput = document.getElementById('flatpickr-datetime');
            var dateInput2 = document.getElementById('flatpickr-datetime2');
            if (!dateInput.value || !dateInput2.value) {
                event.preventDefault();
                alert('Please enter a valid date');
            }
        });
    </script>
@endsection
