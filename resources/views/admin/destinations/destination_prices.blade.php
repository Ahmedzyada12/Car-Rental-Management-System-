@extends('layouts.master')
@section('title', 'destinations price')
@section('css')

@endsection
@section('content')
    <!-- Bootstrap Table with Header - Light -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Table Basic</h5>
            @if (session('success'))
                <div style="margin-left: 20px; margin-right: 20px;" class="alert alert-primary" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <a style="width: 200px; margin-left: 20px;" class="btn btn-primary"
                href="{{ route('admin.destination.price.create') }}">add destinations price</a>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>company</th>
                            <th>price</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($destinations as $destination)
                            <tr>
                                <td>
                                    <i style="font-size: 20px" class="fa-solid fa-location-dot text-danger me-3"></i>
                                    <span class="fw-medium">{{ $destination->company->first_name }}</span>
                                </td>
                                <td>{{ $destination->price }}</td>
                                <td>{{ $destination->destination->from }}</td>
                                <td>{{ $destination->destination->to }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#editDestination" data-id="{{ $destination->id }}"
                                                data-price="{{ $destination->price }}"
                                                data-company="{{ $destination->company_id }}"
                                                data-dest="{{ $destination->destination_id }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </button>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.destination.price.delete', $destination->id) }}"><i
                                                    class="ti ti-trash me-1"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal edit destination -->
    <div class="modal fade" id="editDestination" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.destination.price.update') }}" method="post">
                        @csrf
                        <input class="dest-id" type="hidden" name="id" value="">
                        <div class="mb-4">
                            <label for="dest" class="form-label">destination</label>
                            <select id="dest"
                                class="select2 form-select form-select-lg {{ $errors->has('destination') ? 'is-invalid' : '' }}"
                                data-allow-clear="true" name="destination_id">
                                @foreach ($dest_lists as $dest)
                                    <option value="{{ $dest->id }}">
                                        {{ $dest->from . '->' . $dest->to }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="cars-select"
                                class="form-label">{{ trans('reservations/reservation_trans.Choose the company') }}</label>
                            <select id="company"
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
                                class="price form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                id="basic-default-lastname" placeholder="price" name="price"
                                value="{{ old('price') }}" />
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.dropdown-item').click(function() {
            // Get data attributes from the clicked button
            var dataId = $(this).data('id');
            var dataPrice = $(this).data('price');
            var dataCompany = $(this).data('company');
            var dataDest = $(this).data('dest');
            // Set values in the modal
            $('#editDestination .dest-id').val(dataId);
            $('#editDestination .price').val(dataPrice);
            // $('#editDestination select[name="company_id"]')
            //     .find('option[value="' + dataCompany + '"]').prop('selected', true);
            // $('#editDestination select[name="destination_id"]')
            //     .find('option[value="' + dataDest + '"]').prop('selected', true);

            var companySelect = $('#editDestination select[name="company_id"]');
            companySelect.find('option[value="' + dataCompany + '"]').prop('selected', true);
            var selectedCompanyText = companySelect.find('option:selected').text();


            var destSelect = $('#editDestination select[name="destination_id"]');
            destSelect.find('option[value="' + dataDest + '"]').prop('selected', true);
            var selectedDestText = destSelect.find('option:selected').text();

            // Trigger Select2 update
            companySelect.trigger('change.select2');
            destSelect.trigger('change.select2');
        });
    </script>
@endsection
