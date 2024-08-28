@extends('layouts.master')
@section('title', 'طلب تصليح سياره')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('drivers/drivers_trans.add') }} /
                </span>{{ trans('drivers/drivers_trans.add repair') }}</h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('drivers/drivers_trans.add repair') }}</h5>
                            <small class="text-muted float-end">{{ trans('drivers/drivers_trans.add repair') }}</small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('driver.store.repair') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-name">{{ trans('drivers/drivers_trans.date repair') }}</label>
                                    <input type="date" style="width: 400px; max-width: 100%"
                                        class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}"
                                        id="basic-default-date" name="date" value="{{ old('date') }}" />
                                    @if ($errors->has('date'))
                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                    @endif
                                </div>
                                <button type="submit"
                                    class="btn btn-primary">{{ trans('drivers/drivers_trans.Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end Form -->
            </div>
        </div>
    </div>
@endsection
