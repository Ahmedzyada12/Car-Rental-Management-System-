@extends('layouts.master')
@section('title', 'قائمة الاقسام')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="offcanvas offcanvas-end" id="add-new-record-vendor-section">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record-vendor-section pt-0 row g-2" id="form-add-new-record-vendor-section" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullname">{{ trans('vehicles sections/vehicles_trans.section name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="ssss" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="section_name" class="form-control dt-section_name" name="section_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label"
                            for="last_name">{{ trans('vehicles sections/vehicles_trans.Hourly price') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="hourprice" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="hourprice" class="form-control dt-hourprice" name="hourprice"
                                aria-describedby="hourprice2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicPost">{{ trans('vehicles sections/vehicles_trans.Price per day') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="dayprice" name="dayprice" class="form-control dt-dayprice"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('vehicles sections/vehicles_trans.add') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('vehicles sections/vehicles_trans.cancle') }}</button>
                    </div>
                </form>
            </div>
        </div>





        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic-vendor_categories table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('vehicles sections/vehicles_trans.name') }}</th>
                            <th>{{ trans('vehicles sections/vehicles_trans.Hourly price') }}</th>
                            <th>{{ trans('vehicles sections/vehicles_trans.Price per day') }}</th>
                            <th>{{ trans('vehicles sections/vehicles_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->

    </div>
@endsection
