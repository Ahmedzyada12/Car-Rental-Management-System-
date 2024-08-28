@extends('layouts.master')
@section('title', 'قائمة العملاء')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('customers/customers_trans.List of customers') }}</h5>
                {{-- <a href="{{ route('admin.customer.export') }}" style="height: 30px; margin: 2%" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('customers/customers_trans.New Record') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label" for="basicFullname">{{ trans('customers/customers_trans.first Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="first_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="first_name" class="form-control dt-first_name" name="first_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="last_name">{{ trans('customers/customers_trans.last Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="last_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="last_name" class="form-control dt-last_name" name="last_name"
                                aria-describedby="last_name2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('drivers/drivers_trans.Address') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="address" name="address" class="form-control dt-address"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('customers/customers_trans.Phone') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="phone" name="phone" class="form-control dt-phone"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicEmail">{{ trans('customers/customers_trans.Email') }}</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="text" id="email" name="email" class="form-control dt-email" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="password">{{ trans('customers/customers_trans.password') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="password" class="input-group-text"><i class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password" id="password" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="password_confirmation">{{ trans('drivers/drivers_trans.password confirmation') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="password_confirmation" class="input-group-text"><i class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password_confirmation" id="password_confirmation"
                                name="password_confirmation" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('customers/customers_trans.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('customers/customers_trans.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic10 table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('managers/managers_trans.Name') }}</th>
                            <th>{{ trans('customers/customers_trans.Email') }}</th>
                            <th>{{ trans('customers/customers_trans.Address') }}</th>
                            <th>{{ trans('customers/customers_trans.Phone') }}</th>
                            <th>{{ trans('customers/customers_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>
    </div>
@endsection
