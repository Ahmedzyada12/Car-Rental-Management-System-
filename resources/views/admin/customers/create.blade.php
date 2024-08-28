@extends('layouts.master')
@section('title', 'اضافة عميل')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('drivers/drivers_trans.add') }} /</span>
                {{ trans('customers/customers_trans.New customer') }} </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('sidebar_trans.Add Customer') }}</h5>
                            <small class="text-muted float-end">{{ trans('sidebar_trans.Add Customer') }}</small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.customer.store') }}" method="post">
                                @csrf
                                <div class="col-md-6 mb-4">
                                    <label for="select2Basic" class="form-label">
                                        {{ trans('customers/customers_trans.choose company') }}</label>
                                    <select id="select2Basic" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" name="parent_id">
                                        <option value="" disabled selected>
                                            {{ trans('customers/customers_trans.choose') }}</option>
                                        @foreach ($companys as $companys_val)
                                            <option value="{{ $companys_val->user_id }}">{{ $companys_val->first_name }}
                                                {{ $companys_val->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-firstname">{{ trans('customers/customers_trans.first Name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname"
                                        placeholder="{{ trans('customers/customers_trans.first Name') }}" name="first_name"
                                        value="{{ old('first_name') }}" />
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-lastname">{{ trans('customers/customers_trans.last Name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-lastname"
                                        placeholder="{{ trans('customers/customers_trans.last Name') }}" name="last_name"
                                        value="{{ old('last_name') }}" />
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic" class="form-label">country</label>
                                    <select id="category-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="country">
                                        <option value="" disabled selected>
                                            country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('country'))
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                @endif

                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic" class="form-label">city</label>
                                    <select id="city-select"
                                        class="select2 city form-select form-select-lg {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="city">
                                        <option value="" disabled selected>
                                            city</option>

                                    </select>
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif
                                </div>



                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-address">العنوان بالتفصيل</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                        id="basic-default-address"
                                        placeholder="{{ trans('customers/customers_trans.Address') }}" name="address"
                                        value="{{ old('address') }}" />
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>



                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-phone">{{ trans('customers/customers_trans.Phone') }}</label>
                                    <input type="text" id="basic-default-phone"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                        placeholder="658 799 8941" name="phone" value="{{ old('phone') }}" />
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ trans('customers/customers_trans.Submit') }}</button>
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
<script>
    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            var country = $(this).val();
            if (country) {
                $.ajax({
                    url: "{{ URL::to('get_states') }}/" + country,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                    }
                });
            } else {
                console.log('Country not selected');
            }
        });
    });
</script>
@endsection
