@extends('layouts.master')
@section('title', 'اضافة طلب')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('companies/companies_trans.add') }} /</span>
                {{ trans('companies/companies_trans.new order') }} </h4>
            @if (session('success'))
                <div class="alert alert-primary" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('companies/companies_trans.add order') }}</h5>
                            <small class="text-muted float-end">{{ trans('companies/companies_trans.add order') }}</small>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    Fail to create the Booking, complete all inputs
                                </div>
                            @endif
                            <form action="{{ route('company.order.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="col-md-6 col-12 mb-4">

                                        <label for="flatpickr-datetime"
                                            class="form-label">{{ trans('reservations/reservation_trans.from') }}</label>
                                        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM"
                                            id="flatpickr-datetime" name='date_from' />
                                    </div>
                                    <div class="col-md-6 col-12 mb-4">
                                        <label for="flatpickr-datetime2"
                                            class="form-label">{{ trans('reservations/reservation_trans.to') }}</label>
                                        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM"
                                            id="flatpickr-datetime2" name='date_to' />
                                    </div>
                                </div>
                                {{-- <div class="card bg-danger text-white mb-4" id="data-massage" style="display: none;"></div>
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif --}}
                                <!-- Basic -->
                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('reservations/reservation_trans.Choose a section') }}</label>
                                    <select id="category-select" class="select2 form-select form-select-lg"
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
                                    <label for="cars-select" class="form-label">
                                        {{ trans('reservations/reservation_trans.Choose car') }}</label>
                                    <select id="cars-select" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" name="car_id">
                                    </select>
                                </div>
                                <!-- fawzi -->

                                {{-- <div class="col-md-12 mb-4">
                                    <label for="select2Basic" class="form-label">اختر المدير</label>
                                    <select id="admin-select" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" name="admin_id">
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->user_id }}">{{ $admin->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-destination">
                                        {{ trans('reservations/reservation_trans.The destination') }}</label>
                                    <select placeholder="select destination" class="select2 form-select form-select-lg"
                                        name="destination" id="destination" data-allow-clear="true">
                                        <option value="" disabled selected>
                                            {{ trans('reservations/reservation_trans.destination') }} </option>
                                        @foreach ($destinations as $destination)
                                            <option value="" disabled selected>
                                                {{ trans('reservations/reservation_trans.Choose a section') }}</option>
                                            <option value="{{ $destination->id }}">
                                                {{ $destination->destination->from . '->to->' . $destination->destination->to }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-4" id="customer-div">
                                    <label for="select2Basic" class="form-label">
                                        {{ trans('companies/companies_trans.choose customer') }}</label>
                                    <div style="" class="d-flex align-items-center gap-2 ">
                                        <div class="flex-grow-1">
                                            <select id="customer-select" class="select2 form-select form-select-lg"
                                                data-allow-clear="true" name="customer_id">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->user_id }}">
                                                        {{ $customer->first_name . ' ' . $customer->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <button type="button" style="width: fit-content" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal-add-client">
                                            اضافة عميل
                                        </button> --}}
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic" class="form-label">
                                        {{ trans('companies/companies_trans.choose driver') }} </label>
                                    <div style="" class="d-flex align-items-center gap-2 ">
                                        <div class="flex-grow-1">
                                            <select id="driver-select" class="select2 form-select form-select-lg"
                                                data-allow-clear="true" name="driver_id">
                                                @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->user_id }}">
                                                        {{ $driver->first_name . ' ' . $driver->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <button type="button" style="width: fit-content" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal-add-driver">
                                            اضافة سائق
                                        </button> --}}
                                    </div>
                                </div>
                                <!-- fawzi -->
                                <div class="col-md-12 mb-4">

                                    <div id='price-calc' style="display: none;">
                                        <div class="row" id= "basic-default-price">
                                            <div class="mb-3 col">
                                                <label class="form-label" for="basic-default-hourlyprice">
                                                    {{ trans('reservations/reservation_trans.hours number') }}</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('hours') ? 'is-invalid' : '' }}"
                                                    id="basic-default-hourlyprice" placeholder="20" name="hours"
                                                    value="{{ old('hours') }}" />
                                            </div>

                                            <div class="mb-3 col">
                                                <label class="form-label" for="basic-default-dailyprice">
                                                    {{ trans('reservations/reservation_trans.days number') }}</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('days') ? 'is-invalid' : '' }}"
                                                    id="basic-default-dailyprice" placeholder="100" name="days"
                                                    value="{{ old('days') }}" />
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-price">
                                                {{ trans('reservations/reservation_trans.price') }}</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                                id="basic-default-total" placeholder="500" name="price"
                                                value="{{ old('price') }}" />
                                            @if ($errors->has('price'))
                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


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
@endsection

@section('js')
    <script type="text/javascript">
        // var baseUrl2 = "{{ route('admin.orders.getcustomers', ['id' => 'tempId']) }}";
        // baseUrl2 = baseUrl2.replace('tempId', ''); // Remove the placeholder
        // $('#company-select').on('change', function() {
        //     var companyId = $(this).val();
        //     var customerSelect = $('#customer-select');
        //     $.ajax({
        //         url: baseUrl2 + companyId,
        //         method: 'GET',
        //         success: function(response) {
        //             customerSelect.empty();
        //             $.each(response, function(key, value) {
        //                 customerSelect.append('<option value="' +
        //                     key + '"> ' + value + '</option>')
        //             });
        //         }
        //     });
        // });



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
            var dist_id = $('#destination').val();
            var houreprice = $('#basic-default-hourlyprice').val();
            var dailyprice = $('#basic-default-dailyprice').val();
            var totalPrice = $('basic-default-total');
            houreprice = houreprice ? houreprice : 0;
            dailyprice = dailyprice ? dailyprice : 0;
            dist_id = dist_id ? dist_id : 0;

            // var finalUrl = baseUrl3.replace('tempId', car_id).replace('tempDriver', driver_id).replace('temphours',
            //     houreprice).replace('tempdaily', dailyprice);
            var finalUrl = '/company/getprice/' + car_id + '/' + driver_id + '/' + houreprice + '/' +
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
        $('#destination').on('change', getPrice)
        $('#basic-default-hourlyprice').on('keyup', getPrice)
        $('#basic-default-dailyprice').on('keyup', getPrice)
        $('#cars-select').on('change', getPrice)




        function checkDateRange() {
            var dateFrom = $('#flatpickr-datetime').val();
            var dateTo = $('#flatpickr-datetime2').val();

            // Ensure both dates are selected
            if (dateFrom && dateTo) {
                $.ajax({
                    url: "{{ route('company.orders.check-dates-ajax') }}", // Adjust the URL as needed
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
@endsection
