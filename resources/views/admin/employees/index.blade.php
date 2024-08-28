@extends('layouts.master')
@section('title', trans('employees/employees_trans.list employees'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{  trans('employees/employees_trans.list employees') }}</h5>
                {{-- <a href="{{ route('admin.customer.export') }}" style="height: 30px; margin: 2%" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record1">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('employees/employees_trans.Add an employee') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record1 pt-0 row g-2" id="form-add-new-record1" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label" for="basicFullname">{{ trans('employees/employees_trans.name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="name" class="form-control dt-name" name="name"
                                aria-describedby="name2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="last_name">{{ trans('employees/employees_trans.phone number') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="phone" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="phone" class="form-control dt-phone" name="phone"
                                aria-describedby="phone2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('employees/employees_trans.the address') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="address" name="address" class="form-control dt-address"
                                aria-describedby="address2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="email">{{ trans('employees/employees_trans.E-mail') }}</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-email"></i></span>
                            <input type="text" id="email" name="email" class="form-control dt-email" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('employees/employees_trans.job') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="job2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="job" name="job" class="form-control dt-job"
                                aria-describedby="job2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="salary">{{ trans('employees/employees_trans.Salary') }}</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-salary"></i></span>
                            <input type="text" id="salary" name="salary" class="form-control dt-salary" />
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
        {{-- <div class="card">


            <div class="row">

                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>email</th>
                                <th>phone</th>
                                <th>address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $customer->first_name }} {{ $customer->last_name }}</span>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td><span class="badge bg-label-primary me-1">{{ $customer->phone }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.customer.show', ['id' => $customer->user_id]) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('admin.customer.delete', ['id' => $customer->user_id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="ti ti-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  --}}
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic13 table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('employees/employees_trans.name') }}</th>
                            <th>{{ trans('employees/employees_trans.phone number') }}</th>
                            <th>{{ trans('employees/employees_trans.the address') }}</th>
                            <th>{{ trans('employees/employees_trans.E-mail') }}</th>
                            <th>{{ trans('employees/employees_trans.job') }}</th>
                            <th>{{ trans('employees/employees_trans.Salary') }}</th>
                            <th>created_at</th>
                        </tr>
                    </thead>
                </table>

                <table class="dt_basic_table_employee_drivers table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('drivers/drivers_trans.Name') }}</th>
                            <th>{{ trans('vendors/vendors_trans.vendor') }}</th>
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
