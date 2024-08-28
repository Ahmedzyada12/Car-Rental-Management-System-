@extends('layouts.master')
@section('title', 'add destination price')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('managers/managers_trans.add') }} /</span> new
                destination price </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">add destination price</h5>
                            <small class="text-muted float-end">add destination price</small>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-primary" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('admin.destination.price.store') }}" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="cars-select" class="form-label">destination</label>
                                    <select id="cars-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('destination') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="destination_id">
                                        @foreach ($destinations as $destination)
                                            <option value="{{ $destination->id }}"
                                                {{ request('id') == $destination->id ? 'selected' : '' }}>
                                                {{ $destination->from . '->' . $destination->to }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="cars-select"
                                        class="form-label">{{ trans('reservations/reservation_trans.Choose the company') }}</label>
                                    <select id=""
                                        class="select2 form-select form-select-lg {{ $errors->has('company') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="company_id">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->user_id }}">
                                                {{ $company->first_name . ' ' . $company->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-lastname">{{ trans('reservations/reservation_trans.price') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                        id="basic-default-lastname"
                                        placeholder="{{ trans('managers/managers_trans.last Name') }}" name="price"
                                        value="{{ old('price') }}" />
                                    @if ($errors->has('price'))
                                        <span class="text-danger">{{ $errors->first('price') }}</span>
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
