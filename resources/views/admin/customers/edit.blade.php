@extends('layouts.master')
@section('title', 'تعديل سائق')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('customers/customers_trans.edit') }}
                    /</span>{{ trans('customers/customers_trans.edit customer') }}</h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('customers/customers_trans.edit customer') }}</h5>
                            <small
                                class="text-muted float-end">{{ trans('customers/customers_trans.edit customer') }}</small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.customer.edit', $customer->user_id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-firstname">{{ trans('customers/customers_trans.first Name') }}</label>
                                    <input type="text" value="{{ old('first_name', $customer->first_name) }}"
                                        class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname"
                                        placeholder="{{ trans('customers/customers_trans.first Name') }}"
                                        name="first_name" />
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-lastname">{{ trans('customers/customers_trans.last Name') }}</label>
                                    <input type="text" value ="{{ old('last_name', $customer->last_name) }}"
                                        class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-lastname"
                                        placeholder="{{ trans('customers/customers_trans.last Name') }}"
                                        name="last_name" />
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-address">{{ trans('customers/customers_trans.Address') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                        id="basic-default-address"
                                        placeholder="{{ trans('customers/customers_trans.Address') }}" name="address"
                                        value="{{ old('address', $customer->address) }}" />
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>


                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic" class="form-label">country</label>
                                    <select id="category-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="country">
                                        <option value="{{ $customer->country }}" disabled selected>
                                            {{ $customer->country }}</option>
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

                                        <option value="{{ $customer->city }}" disabled selected>
                                            {{ $customer->city }}</option>

                                    </select>
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif
                                </div>


                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-phone">{{ trans('customers/customers_trans.Phone') }}</label>
                                    <input type="text" id="basic-default-phone"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                        placeholder="658 799 8941" name="phone"
                                        value="{{ old('phone', $customer->phone) }}" />
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>

                                <button type="submit"
                                    class="btn btn-primary">{{ trans('customers/customers_trans.Submit') }}</button>
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
