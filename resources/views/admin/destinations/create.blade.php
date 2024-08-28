@extends('layouts.master')
@section('title', 'add destination')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('managers/managers_trans.add') }} /</span> new
                destination </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">add destination</h5>
                            <small class="text-muted float-end">add destination</small>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-primary" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('admin.destination.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-firstname">{{ trans('reservations/reservation_trans.from') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('from') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname"
                                        placeholder="{{ trans('managers/managers_trans.first Name') }}" name="from"
                                        value="{{ old('from') }}" />
                                    @if ($errors->has('from'))
                                        <span class="text-danger">{{ $errors->first('from') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-lastname">{{ trans('reservations/reservation_trans.to') }}</label>
                                    <input type="text" class="form-control {{ $errors->has('to') ? 'is-invalid' : '' }}"
                                        id="basic-default-lastname"
                                        placeholder="{{ trans('managers/managers_trans.last Name') }}" name="to"
                                        value="{{ old('to') }}" />
                                    @if ($errors->has('to'))
                                        <span class="text-danger">{{ $errors->first('to') }}</span>
                                    @endif
                                </div>
                                <button type="submit"
                                    class="btn btn-primary">{{ trans('managers/managers_trans.Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end Form -->
            </div>
        </div>
    </div>
@endsection
