@extends('layouts.master')
@section('title', 'تعديل سيارة')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('cars/cars_trans.edit') }} /</span>
                {{ trans('cars/cars_trans.car') }} </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('cars/cars_trans.edit car') }} </h5>
                            <small class="text-muted float-end">{{ trans('cars/cars_trans.edit car') }}</small>
                        </div>
                        <div class="card-body">
                            @if (auth()->user()->role == 0)
                                <form action="{{ route('admin.cars.edit', $cars->car_id) }}" method="post">
                                @elseif(auth()->user()->role == 4)
                                    <form action="{{ route('vendor.cars.update', $cars->car_id) }}" method="post">
                            @endif
                            @csrf
                            <div class="col-md-6 mb-4">
                                <label for="select2Basic" class="form-label">
                                    {{ trans('cars/cars_trans.choose section') }} </label>
                                <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true"
                                    name="category_id">
                                    @foreach ($categories as $category_val)
                                        <option value="{{ $category_val->category_id }}"
                                            @if ($cars->category_id == $category_val->category_id) selected @endif>
                                            {{ $category_val->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    for="basic-default-name">{{ trans('cars/cars_trans.car name') }}</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="basic-default-name" placeholder="sidan" name="name"
                                    value="{{ $cars->name }}" />
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-hourlyprice">
                                    {{ trans('cars/cars_trans.Hourly price') }} </label>
                                <input type="text"
                                    class="form-control {{ $errors->has('hourlyprice') ? 'is-invalid' : '' }}"
                                    id="basic-default-price" placeholder="500" name="hourlyprice"
                                    value="{{ $cars->hourlyprice }}" />
                                @if ($errors->has('hourlyprice'))
                                    <span class="text-danger">{{ $errors->first('hourlyprice') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-dailyprice">
                                    {{ trans('cars/cars_trans.Price per day') }} </label>
                                <input type="text"
                                    class="form-control {{ $errors->has('dailyprice') ? 'is-invalid' : '' }}"
                                    id="basic-default-dailyprice" placeholder="500" name="dailyprice"
                                    value="{{ $cars->dailyprice }}" />
                                @if ($errors->has('dailyprice'))
                                    <span class="text-danger">{{ $errors->first('dailyprice') }}</span>
                                @endif
                            </div>








                            <button type="submit" class="btn btn-primary">{{ trans('cars/cars_trans.edit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end Form -->
            </div>
        </div>
    </div>
@endsection
