@extends('layouts.master')
@section('title', 'تعديل عميل')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('companies/companies_trans.edit') }} /</span>
                {{ trans('companies/companies_trans.edit customer') }} </h4>
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
                            <h5 class="mb-0">{{ trans('companies/companies_trans.edit customer') }}</h5>
                            <small
                                class="text-muted float-end">{{ trans('companies/companies_trans.edit customer') }}</small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('company.customer.edit') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $customer->user_id }}">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-firstname">
                                        {{ trans('companies/companies_trans.first Name') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname" placeholder="John Doe" name="first_name"
                                        value="{{ old('first_name', $customer->first_name) }}" />
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-lastname">
                                        {{ trans('companies/companies_trans.last Name') }} </label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                        id="basic-default-lastname" placeholder="John Doe" name="last_name"
                                        value="{{ old('last_name', $customer->last_name) }}" />
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-address">{{ trans('companies/companies_trans.Address') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                        id="basic-default-address" placeholder="address" name="address"
                                        value="{{ old('address', $customer->address) }}" />
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-email">{{ trans('companies/companies_trans.Email') }} </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basic-default-email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            placeholder="email@example.com" name="email"
                                            value="{{ old('email', $customer->email) }}"
                                            aria-describedby="basic-default-email2" />
                                        <span class="input-group-text" id="basic-default-email2">email@example.com</span>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-phone">{{ trans('companies/companies_trans.Phone') }} </label>
                                    <input type="text" id="basic-default-phone"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                        placeholder="658 799 8941" name="phone"
                                        value="{{ old('phone', $customer->phone) }}" />
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
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
