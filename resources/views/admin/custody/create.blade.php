@extends('layouts.master')
@section('title', trans('custodies/custodies_trans.add custody')  )

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('companies/companies_trans.add') }}  /</span> {{ trans('custodies/custodies_trans.new custody') }}  </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ trans('custodies/custodies_trans.add custody') }} </h5>
                        <small class="text-muted float-end">{{ trans('custodies/custodies_trans.add custody') }} </small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store.custody') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-firstname">{{ trans('custodies/custodies_trans.amount') }}</label>
                                <input type="text" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" id="basic-default-firstname" placeholder="{{ trans('custodies/custodies_trans.amount') }}" name="amount" value="{{ old('amount') }}" />
                                @if ($errors->has('amount'))
                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>

                              <div class="col-md-12 mb-4">
                                <label for="select2Basic" class="form-label">{{ trans('discounts/discounts_trans.Choose the employee') }}</label>
                                <select id="admin-select"
                                    class="select2 form-select form-select-lg {{ $errors->has('employee_id') ? 'is-invalid' : '' }}"
                                    data-allow-clear="true" name="employee_id">
                                    @if($employees)
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>



                            <div class="mb-3">
                                <label class="form-label" for="basic-default-firstname">{{ trans('custodies/custodies_trans.notes') }}</label>
                                <textarea  id="" cols="10" rows="3"class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" id="basic-default-firstname" placeholder="{{ trans('custodies/custodies_trans.notes') }}" name="notes" value="{{ old('notes') }}"></textarea>
                                @if ($errors->has('notes'))
                                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                                @endif
                            </div>


                            <button type="submit" class="btn btn-primary">{{ trans('companies/companies_trans.Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Form -->
        </div>
    </div>
</div>

@endsection
