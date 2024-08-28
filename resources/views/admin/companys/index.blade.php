@extends('layouts.master')
@section('title', 'قائمة الشركات')

@section('content')
    <!-- Bootstrap Table with Header - Light -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('companies/companies_trans.List of companies') }} </h5>
                {{-- <a href="{{ route('admin.companys.export') }}" style="height: 30px;" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('managers/managers_trans.New Record') }} </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label" for="basicFullname">{{ trans('companies/companies_trans.first Name') }}
                        </label>
                        <div class="input-group input-group-merge">
                            <span id="first_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="first_name" class="form-control dt-first_name" name="first_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="last_name">{{ trans('companies/companies_trans.last Name') }}
                        </label>
                        <div class="input-group input-group-merge">
                            <span id="last_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="last_name" class="form-control dt-last_name" name="last_name"
                                aria-describedby="last_name2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('companies/companies_trans.Address') }} </label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="address" name="address" class="form-control dt-address"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('companies/companies_trans.Phone') }} </label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="phone" name="phone" class="form-control dt-phone"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicEmail">{{ trans('companies/companies_trans.Email') }} </label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="text" id="email" name="email" class="form-control dt-email" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="password">{{ trans('companies/companies_trans.password') }} </label>
                        <div class="input-group input-group-merge">
                            <span id="password" class="input-group-text"><i class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password" id="password" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="password_confirmation">{{ trans('companies/companies_trans.password confirmation') }}
                        </label>
                        <div class="input-group input-group-merge">
                            <span id="password_confirmation" class="input-group-text"><i class="ti ti-calendar"></i></span>
                            <input type="password" class="form-control dt-password_confirmation" id="password_confirmation"
                                name="password_confirmation" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('companies/companies_trans.Submit') }}
                        </button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('companies/companies_trans.Cancel') }} </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- <div class="card">
            <div class="d-flex align-items-center">
                <h5 class="card-header">قائمة الشركات</h5>
                <a href="{{ route('admin.companys.export') }}" style="height: 30px;" class="btn btn-success">Export Excel</a>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>الاسم</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @foreach ($companys as $company)
                            <tr>
                                <td>
                                    <span class="fw-medium">{{ $company->first_name }} {{ $company->last_name }}</span>
                                </td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->address }}</td>
                                <td><span class="badge bg-label-primary me-1">{{ $company->phone }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.companys.show', ['id' => $company->user_id]) }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.companys.delete', ['id' => $company->user_id]) }}"
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
        </div> --}}
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic2 table" id="datatables-basic2">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('companies/companies_trans.Name') }} </th>
                            <th>{{ trans('companies/companies_trans.Email') }} </th>
                            <th>{{ trans('companies/companies_trans.Address') }} </th>
                            <th>{{ trans('managers/managers_trans.Phone') }} </th>
                            <th>{{ trans('companies/companies_trans.Actions') }} </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>
@endsection
