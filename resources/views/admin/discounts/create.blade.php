@extends('layouts.master')
@section('title', trans('discounts/discounts_trans.Add a discount'))

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('companies/companies_trans.add') }} /</span>
                {{ trans('discounts/discounts_trans.Add a new discount') }} </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('discounts/discounts_trans.Add a discount') }} </h5>
                            <small class="text-muted float-end">{{ trans('discounts/discounts_trans.Add a discount') }}
                            </small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.discount') }}" method="post">
                                @csrf
                                <div class="check-input">
                                    <div class="form-group mb-2">
                                        <input checked type="radio" id="emp" name="type">
                                        <label for="emp">employee</label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="driver" type="radio" name="type">
                                        <label for="driver">driver</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4 employee-input">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('discounts/discounts_trans.Choose the employee') }}</label>
                                    <select id="admin-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('employee_id') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="employee_id">
                                        <option selected disabled value="none">
                                            {{ trans('discounts/discounts_trans.Choose the employee') }}</option>
                                        @if ($employees)
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-4 driver-input">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('discounts/discounts_trans.Choose the driver') }}</label>
                                    <select id="admin-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('driver_id') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="driver_id">
                                        <option selected disabled value="none">
                                            {{ trans('discounts/discounts_trans.Choose the driver') }}</option>
                                        @if ($drivers)
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->user_id }}">{{ $driver->first_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-firstname">{{ trans('discounts/discounts_trans.Discount amount') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname"
                                        placeholder="{{ trans('discounts/discounts_trans.Discount amount') }}"
                                        name="amount" value="{{ old('amount') }}" />
                                    @if ($errors->has('amount'))
                                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-firstname">{{ __('discounts/discounts_trans.the reason') }}</label>
                                    <textarea name="reason" id="" cols="10"
                                        rows="3"class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" id="basic-default-firstname"
                                        placeholder="السبب" name="reason" value="{{ old('reason') }}"></textarea>
                                    @if ($errors->has('reason'))
                                        <span class="text-danger">{{ $errors->first('reason') }}</span>
                                    @endif
                                </div>

                                <button type="submit"
                                    class="btn btn-primary">{{ trans('companies/companies_trans.Submit') }}</button>
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
        $('.employee-input').show();
        $('.driver-input').hide();
        $('#emp').change(function() {
            if ($(this).prop('checked')) {
                $('.employee-input').show();
                $('.employee-input').addClass('select2');

                $('.driver-input').hide();
                $('.employee-input').removeClass('select2');

            } else {
                $('.driver-input').show();
                // $('.driver-input').addClass('select2');

                $('.employee-input').hide();
                // $('.employee-input').removeClass('select2');
            }
        });

        $('#driver').change(function() {
            if ($(this).prop('checked')) {
                $('.driver-input').show();
                // $('.driver-input').addClass('select2');

                $('.employee-input').hide();
                // $('.employee-input').removeClass('select2');

            }
        });
    </script>
@endsection
