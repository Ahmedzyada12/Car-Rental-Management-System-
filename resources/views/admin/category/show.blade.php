@extends('layouts.master')
@section('title', 'تعديل قسم')

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('managers/managers_trans.edit') }}  /</span> {{ trans('vehicles sections/vehicles_trans.edit section') }} </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ trans('vehicles sections/vehicles_trans.edit section') }}</h5>
                        <small class="text-muted float-end">{{ trans('vehicles sections/vehicles_trans.edit section') }}</small>
                    </div>
                    <div class="card-body">

                    @if (auth()->user()->role==0)
                    <form action="{{ route('admin.category.edit', ['id' => $category->category_id]) }}" method="post">

                    @elseif (auth()->user()->role==4)
                    <form action="{{ route('vendor.category.update', ['id' => $category->category_id]) }}" method="post">
                    @endif
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-name">{{ trans('vehicles sections/vehicles_trans.section name') }}</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="basic-default-name" placeholder="sidan" name="name" value="{{ $category->name }}" />
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-hourlyprice"> {{ trans('vehicles sections/vehicles_trans.Hourly price') }}</label>
                                <input type="text" class="form-control {{ $errors->has('hourlyprice') ? 'is-invalid' : '' }}" id="basic-default-price" placeholder="500" name="hourlyprice" value="{{ $category->hourlyprice }}" />
                                @if ($errors->has('hourlyprice'))
                                    <span class="text-danger">{{ $errors->first('hourlyprice') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-dailyprice"> {{ trans('vehicles sections/vehicles_trans.Price per day') }}</label>
                                <input type="text" class="form-control {{ $errors->has('dailyprice') ? 'is-invalid' : '' }}" id="basic-default-dailyprice" placeholder="500" name="dailyprice" value="{{ $category->dailyprice }}" />
                                @if ($errors->has('dailyprice'))
                                    <span class="text-danger">{{ $errors->first('dailyprice') }}</span>
                                @endif
                            </div>









                            <button type="submit" class="btn btn-primary">{{ trans('customers/customers_trans.Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Form -->
        </div>
    </div>
</div>
@endsection
