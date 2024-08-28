@extends('layouts.master')
@section('title', 'about us')

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

        <div class="container-xxl flex-grow-1 container-p-y">
            <form action="{{ route('about.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="formFile">Logo</label>
                    <input class="form-control" type="file" id="formFile" name="logo"
                        accept="image/jpeg, image/png, image/jpg" />
                    @if ($errors->has('logo'))
                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-destination">Company Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        id="basic-default-total" placeholder="name" name="name"
                        value="{{ old('name', $info->name) }}" />
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-destination">address</label>
                    <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                        id="basic-default-total" placeholder="address" name="address"
                        value="{{ old('address', $info->address) }}" />
                    @if ($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label"
                        for="basic-default-phone">{{ trans('reservations/reservation_trans.Phone') }}</label>
                    <input type="text" id="basic-default-phone"
                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                        placeholder="egypt - cairo - maadi" name="phone" value="{{ old('phone', $info->phone) }}" />
                    @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary"
                    id="button-submit">{{ trans('reservations/reservation_trans.Submit') }}</button>
            </form>
        </div>


        <!-- /Noui Slider -->
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/app-logistics-dashboard.js') }}"></script>

    <script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
    <script src="{{ asset('assets/js/app-calendar.js') }}"></script>
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
@endsection
