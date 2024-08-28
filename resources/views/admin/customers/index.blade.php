@extends('layouts.master')
@section('title', 'قائمة العملاء')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('customers/customers_trans.List of customers') }}</h5>
                {{-- <a href="{{ route('admin.customer.export') }}" style="height: 30px; margin: 2%" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('customers/customers_trans.New Record') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="">
                        <label for="parent_id" class="form-label">
                            {{ trans('customers/customers_trans.choose company') }}</label>
                        <select id="parent_id" required class="select2 form-select form-select-lg dt-parent_id"
                            data-allow-clear="true" name="parent_id">
                            <option value="" disabled selected>
                                {{ trans('customers/customers_trans.choose') }}</option>
                            @foreach ($companys as $companys_val)
                                <option value="{{ $companys_val->user_id }}">{{ $companys_val->first_name }}
                                    {{ $companys_val->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullname">{{ trans('customers/customers_trans.first Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="first_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="first_name" class="form-control dt-first_name" name="first_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="last_name">{{ trans('customers/customers_trans.last Name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="last_name" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="last_name" class="form-control dt-last_name" name="last_name"
                                aria-describedby="last_name2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label for="select2Basic" class="form-label">country</label>
                        <select id="category-select"
                            class="select2 form-select dt-country form-select-lg {{ $errors->has('country') ? 'is-invalid' : '' }}"
                            data-allow-clear="true" name="country">
                            <option value="" disabled selected>
                                country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="select2Basic" class="form-label">city</label>
                        <select id="city-select"
                            class="select2 city form-select form-select-lg  dt-city {{ $errors->has('city') ? 'is-invalid' : '' }}"
                            data-allow-clear="true" name="city">
                            <option value="" disabled selected> city</option>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">العنوان بالتفصيل</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="address" name="address" class="form-control dt-address"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">{{ trans('customers/customers_trans.Phone') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="phone" name="phone" class="form-control dt-phone"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('customers/customers_trans.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('customers/customers_trans.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="card">


            <div class="row">

                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>email</th>
                                <th>phone</th>
                                <th>address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $customer->first_name }} {{ $customer->last_name }}</span>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td><span class="badge bg-label-primary me-1">{{ $customer->phone }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.customer.show', ['id' => $customer->user_id]) }}">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('admin.customer.delete', ['id' => $customer->user_id]) }}"
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
            </div>
        </div>  --}}
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic4 table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('managers/managers_trans.Name') }}</th>
                            {{-- <th>{{ trans('customers/customers_trans.Email') }}</th> --}}
                            <th>{{ trans('customers/customers_trans.Address') }}</th>
                            <th>{{ trans('customers/customers_trans.Phone') }}</th>
                            <th>{{ trans('customers/customers_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>
    </div>
@endsection
@section('js')

<script>
    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            var country = $(this).val();
            if (country) {
                $.ajax({
                    url: "{{ URL::to('get_states') }}/" + country,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                    }
                });
            } else {
                console.log('Country not selected');
            }
        });
    });
</script>@endsection
