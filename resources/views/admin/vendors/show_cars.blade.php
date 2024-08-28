@extends('layouts.master')
@section('title', 'قائمة السيارات')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        {{-- <div class="card">
            <h5 class="card-header">قائمة الاقسام</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>الاسم</th>
                            <th>السعر بالساعه</th>
                            <th>السعر باليوم</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody class="table-border-bottom-0">
                        @foreach ($category as $category_val)
                            <tr>
                                <td>

                                    <a href="{{ route('admin.cars.index', ['id' => $category_val->category_id]) }}"><span
                                            class="fw-medium">{{ $category_val->name }} </span></a>
                                </td>

                                <td><span class="badge bg-label-primary me-1">{{ $category_val->hourlyprice }}</span></td>
                                <td><span class="badge bg-label-primary me-1">{{ $category_val->dailyprice }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.category.show', ['id' => $category_val->category_id]) }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                            <form
                                                action="{{ route('admin.category.delete', ['id' => $category_val->category_id]) }}"
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
                <table class="datatables-basic-vendor_cars table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('cars/cars_trans.name') }}</th>
                            <th>{{ trans('cars/cars_trans.Hourly price') }}</th>
                            <th>{{ trans('cars/cars_trans.Price per day') }}</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->

    </div>
@endsection
