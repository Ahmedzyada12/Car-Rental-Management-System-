@extends('layouts.master')
@section('title',trans('employees/employees_trans.Add an employee') )

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
                            <h5 class="mb-0">{{ trans('employees/employees_trans.Add an employee') }}</h5>
                            <small class="text-muted float-end">{{ trans('employees/employees_trans.Add an employee') }}</small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.employee') }}" method="post">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">{{ trans('employees/employees_trans.name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-name" placeholder="{{ trans('employees/employees_trans.name') }}" name="name"
                                        value="{{ old('name') }}" />
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
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

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-address">{{ trans('customers/customers_trans.Address') }}</label>
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
                                        for="basic-default-email">{{ trans('customers/customers_trans.Email') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basic-default-email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            placeholder="email@example.com" name="email" value="{{ old('email') }}"
                                            aria-describedby="basic-default-email2" />
                                        <span class="input-group-text" id="basic-default-email2">email@example.com</span>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="multicol-password">{{ trans('employees/employees_trans.job') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="job"
                                            class="form-control {{ $errors->has('job') ? 'is-invalid' : '' }}"
                                            name="job" placeholder="الوظيفه" aria-describedby="job2" />
                                        <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                    @if ($errors->has('job'))
                                        <span class="text-danger">{{ $errors->first('job') }}</span>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-salary">{{ trans('employees/employees_trans.Salary') }}</label>
                                    <input type="text" id="basic-default-salary"
                                        class="form-control {{ $errors->has('salary') ? 'is-invalid' : '' }}"
                                        placeholder="الراتب" name="salary" value="{{ old('salary') }}" />
                                    @if ($errors->has('salary'))
                                        <span class="text-danger">{{ $errors->first('salary') }}</span>
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
