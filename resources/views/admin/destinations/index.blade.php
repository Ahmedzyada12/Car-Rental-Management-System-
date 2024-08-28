@extends('layouts.master')
@section('title', 'destinations list')
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
                href="{{ route('admin.destination.create') }}">Add destination</a>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($destinations as $destination)
                            <tr>
                                <td>
                                    {{-- <i class="ti ti-brand-angular ti-lg text-danger me-3"></i> --}}
                                    <i style="font-size: 20px" class="fa-solid fa-location-dot text-danger me-3"></i>
                                    <span class="fw-medium">{{ $destination->from }}</span>
                                </td>
                                <td>{{ $destination->to }}</td>
                                <td>
                                    @if ($destination->prices->isEmpty())
                                        <a class="btn btn-warning" style="margin-bottom: 3px"
                                            href="{{ route('admin.destination.price.create') }}?id={{ $destination->id }}">
                                            add price
                                        </a>
                                    @endif
                                    <div class="dropdown" style="display: inline-block; margin-left: 15px">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            {{-- <a class="dropdown-item"
                                                href="{{ route('admin.destination.show', $destination->id) }}"><i
                                                    class="ti ti-pencil me-1"></i>
                                                Edit</a> --}}
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#editDestination" data-from="{{ $destination->from }}"
                                                data-to="{{ $destination->to }}" data-id="{{ $destination->id }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </button>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.destination.delete', $destination->id) }}"><i
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
                    <form action="{{ route('admin.destination.update') }}" method="post">
                        @csrf
                        <input class="dest-id" type="hidden" name="id" value="">
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-6">
                                <input class="form-control dest-from" type="text" name="from" placeholder="from">
                            </div>
                            <div class="col-6">
                                <input class="form-control dest-to" type="text" name="to" placeholder="to">
                            </div>
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
            var dataFrom = $(this).data('from');
            var dataTo = $(this).data('to');
            // Set values in the modal
            $('#editDestination .dest-id').val(dataId);
            $('#editDestination .dest-from').val(dataFrom);
            $('#editDestination .dest-to').val(dataTo);
        });
    </script>
@endsection
