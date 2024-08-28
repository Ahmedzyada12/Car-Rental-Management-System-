@extends('layouts.master')
@section('title', trans('discounts/discounts_trans.discounts list'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('discounts/discounts_trans.discounts list') }}</h5>
                {{-- <a href="{{ route('admin.customer.export') }}" style="height: 30px; margin: 2%" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record3">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('discounts/discounts_trans.Add a discount') }}
                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record3 pt-0 row g-2" id="form-add-new-record3" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullamount">{{ trans('custodies/custodies_trans.amount') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="amount" class="input-group-text"><i></i></span>
                            <input type="text" id="amount" class="form-control dt-amount" name="amount"
                                aria-describedby="amount2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="">
                            <label class="form-label"
                                for="basicFullemployee_id">{{ trans('custodies/custodies_trans.Select employee') }}</label>
                            <select class="select2 form-select form-select-lg dt-employee_id" name="employee_id"
                                aria-describedby="employee_id2">
                                <option value="choose" selected disabled>
                                    {{ trans('custodies/custodies_trans.Select employee') }}</option>
                                @if ($employees)
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullnotes">{{ trans('discounts/discounts_trans.the reason') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="notes" class="input-group-text"><i class="ti ti-notes"></i></span>
                            <textarea name="notes" id="notes" cols="5" class="form-control dt-notes" rows="5"
                                aria-describedby="notes2"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('customers/customers_trans.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('customers/customers_trans.Cancel') }}</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic15 table">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>id</th>
                            <th>{{ trans('discounts/discounts_trans.name') }}</th>
                            <th>{{ trans('discounts/discounts_trans.Discount amount') }}</th>
                            <th>{{ trans('companies/companies_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('discounts/discounts_trans.discounts list driver') }}</h5>
                {{-- <a href="{{ route('admin.customer.export') }}" style="height: 30px; margin: 2%" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record40">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">
                    {{ trans('discounts/discounts_trans.Add a discount driver') }}
                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record3 pt-0 row g-2" id="form-add-new-record40" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullamount">{{ trans('custodies/custodies_trans.amount') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="amount" class="input-group-text"><i></i></span>
                            <input type="text" id="amount" class="form-control dt-amount" name="amount"
                                aria-describedby="amount2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="">
                            <label class="form-label"
                                for="basicFullemployee_id">{{ trans('discounts/discounts_trans.Add driver') }}</label>
                            <select class="select2 form-select form-select-lg dt-driver_id" name="driver_id"
                                aria-describedby="driver_id2">
                                <option value="choose" selected disabled>
                                    {{ trans('discounts/discounts_trans.Add driver') }}</option>
                                @if ($users)
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->first_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullnotes">{{ trans('discounts/discounts_trans.the reason') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="notes" class="input-group-text"><i class="ti ti-notes"></i></span>
                            <textarea name="notes" id="notes" cols="5" class="form-control dt-notes" rows="5"
                                aria-describedby="notes2"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('customers/customers_trans.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('customers/customers_trans.Cancel') }}</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic40 table">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
                            <th>id</th>
                            <th>{{ trans('discounts/discounts_trans.name') }}</th>
                            <th>{{ trans('discounts/discounts_trans.Discount amount') }}</th>
                            <th>{{ trans('companies/companies_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>
    </div>
@endsection
