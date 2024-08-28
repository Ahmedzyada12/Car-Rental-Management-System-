@extends('layouts.master')
@section('title', 'اضافة مدير')

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('managers/managers_trans.add') }}  /</span> {{ trans('managers/managers_trans.New manager') }} </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ trans('managers/managers_trans.Add a manager') }}</h5>
                        <small class="text-muted float-end">{{ trans('managers/managers_trans.Add a manager') }}</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.mang.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-firstname">{{ trans('managers/managers_trans.first Name') }}</label>
                                <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="basic-default-firstname" placeholder="{{ trans('managers/managers_trans.first Name') }}" name="first_name" value="{{ old('first_name') }}" />
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-lastname">{{ trans('managers/managers_trans.last Name') }}</label>
                                <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="basic-default-lastname" placeholder="{{ trans('managers/managers_trans.last Name') }}" name="last_name" value="{{ old('last_name') }}" />
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-address">{{ trans('managers/managers_trans.Address') }}</label>
                                <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="basic-default-address" placeholder="{{ trans('managers/managers_trans.Address') }}" name="address" value="{{ old('address') }}" />
                                @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">{{ trans('managers/managers_trans.Email') }}</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="text"
                                        id="basic-default-email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        placeholder="{{ trans('managers/managers_trans.Email') }}"
                                        name="email"
                                        value="{{ old('email') }}"
                                        aria-describedby="basic-default-email2" />
                                    <span class="input-group-text" id="basic-default-email2">email@example.com</span>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="multicol-password">{{ trans('managers/managers_trans.password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="multicol-password"
                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-password2" />
                                    <span class="input-group-text cursor-pointer" id="multicol-password2"><i class="ti ti-eye-off"></i></span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="multicol-password-confirmation">{{ trans('managers/managers_trans.password confirmation') }}</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="multicol-password-confirmation"
                                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-password2" />
                                    <span class="input-group-text cursor-pointer" id="multicol-password2-confirmation"><i class="ti ti-eye-off"></i></span>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">{{ trans('managers/managers_trans.Phone') }}</label>
                                <input
                                    type="text"
                                    id="basic-default-phone"
                                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                    placeholder="658 799 8941"
                                    name="phone"
                                    value="{{ old('phone') }}" />
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">{{ trans('managers/managers_trans.Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Form -->
        </div>
    </div>
</div>
@endsection
