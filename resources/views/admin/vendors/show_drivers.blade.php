@extends('layouts.master')
@section('title', trans('drivers/drivers_trans.Drivers list'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('drivers/drivers_trans.Drivers list') }}</h5>
                {{-- <a href="{{ route('admin.drivers.export') }}" style="height: 30px;" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>

        <div class="offcanvas offcanvas-end" id="add-new-record-driver">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record-driver pt-0 row g-2" id="form-add-new-record-driver" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullname">{{ trans('drivers/drivers_trans.first Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="first_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="first_name" class="form-control dt-first_name" name="first_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="last_name">{{ trans('drivers/drivers_trans.last Name') }}</label>
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
                        <label class="form-label" for="basicPost">{{ trans('drivers/drivers_trans.Phone') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="phone" name="phone" class="form-control dt-phone"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('drivers/drivers_trans.Price') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="driver_price" name="driver_price" class="form-control dt-driver_price"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicEmail">{{ trans('drivers/drivers_trans.Email') }}</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="text" id="email" name="email" class="form-control dt-email" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="password">{{ trans('drivers/drivers_trans.password') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="password" class="input-group-text"><i class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password" id="password" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="password_confirmation">{{ trans('drivers/drivers_trans.password confirmation') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="password_confirmation" class="input-group-text"><i
                                    class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password_confirmation"
                                id="password_confirmation" name="password_confirmation" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('drivers/drivers_trans.add') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic-vendor_drivers table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('drivers/drivers_trans.Name') }}</th>
                            <th>{{ trans('drivers/drivers_trans.Email') }}</th>
                            <th>{{ trans('drivers/drivers_trans.Address') }}</th>
                            <th>{{ trans('drivers/drivers_trans.Phone') }}</th>
                            <th>{{ trans('drivers/drivers_trans.Price') }}</th>
                            <th>{{ trans('drivers/drivers_trans.Action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>



    </div>
@endsection
