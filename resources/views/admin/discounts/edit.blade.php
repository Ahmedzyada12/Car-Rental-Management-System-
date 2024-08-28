@extends('layouts.master')
@section('title', trans('discounts/discounts_trans.edit discount'))

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('drivers/drivers_trans.edit') }} /</span>
                {{ trans('discounts/discounts_trans.edit discount') }} </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('discounts/discounts_trans.edit discount') }} </h5>
                            <small class="text-muted float-end">{{ trans('discounts/discounts_trans.edit discount') }}
                            </small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update.discounts',$discount->id) }}" method="post">
                                @csrf
                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('discounts/discounts_trans.Choose the employee') }}</label>
                                    <select id="admin-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('employee_id') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="employee_id">
                                        @if ($employees)
                                            <option value="" selected disabled>Select an employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ $employee->id == $discount->employee_id ? 'selected' : '' }}>
                                                    {{ $employee->name }}
                                                </option>
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
                                        name="amount" value="{{ $discount->amount }}" />
                                    @if ($errors->has('amount'))
                                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-firstname">السبب</label>
                                    <textarea name="reason" id="" cols="10"
                                        rows="3"class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" id="basic-default-firstname"
                                        placeholder="{{ $discount->reason }}" name="reason" value="{{ $discount->reason }}">{{ $discount->reason }}</textarea>
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
