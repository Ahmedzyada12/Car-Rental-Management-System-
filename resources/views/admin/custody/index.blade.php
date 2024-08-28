@extends('layouts.master')
@section('title', trans('custodies/custodies_trans.custodies list'))

@section('content')
    <!-- Bootstrap Table with Header - Light -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-3">
            <div class="d-flex align-items-center">
                <h5 class="card-header">{{ trans('custodies/custodies_trans.custodies list') }} </h5>
                {{-- <a href="{{ route('admin.companys.export') }}" style="height: 30px;" class="btn btn-success">Export Excel</a> --}}
            </div>
        </div>
        <div class="offcanvas offcanvas-end" id="add-new-record2">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">{{ trans('custodies/custodies_trans.add custody') }} </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record2 pt-0 row g-2" id="form-add-new-record2" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullamount">{{ trans('custodies/custodies_trans.amount') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="amount" class="input-group-text"><i></i></span>
                            <input type="text" id="amount" class="form-control dt-amount" name="amount"
                                aria-describedby="amount2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullemployee_id">{{ trans('custodies/custodies_trans.Select employee') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="employee_id" class="input-group-text"><i class="ti ti-user"></i></span>
                            <select class="form-control dt-employee_id" name="employee_id" aria-describedby="employee_id2">
                                @if ($employees)
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullnotes">{{ trans('custodies/custodies_trans.notes') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="notes" class="input-group-text"><i class="ti ti-notes"></i></span>
                            <textarea name="notes" id="notes" cols="5" class="form-control dt-notes" rows="5"
                                aria-describedby="notes2"></textarea>
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



        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic14 table" id="datatables-basic14">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ trans('custodies/custodies_trans.Employee Name') }} </th>
                            <th>{{ trans('custodies/custodies_trans.custodies') }} </th>
                            <th>{{ trans('custodies/custodies_trans.paid up') }} </th>
                            <th>{{ trans('customers/customers_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->

        <!-- Edit User Modal -->
        <div class="modal fade" id="residualCustody" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">

                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <form action="{{ route('store.residual') }}" method="post" id="residualCustodyForm"
                            class="row g-3">
                            @csrf
                            <div class="text-center mb-4">
                                <h3 class="mb-2">{{ trans('custodies/custodies_trans.filter custodies') }}</h3>
                            </div>
                            <input type="hidden" class="employee_id" name="employee_id" value="">
                            <input type="hidden" class="employeeAmount" name="employeeAmount" value="">

                            <div class="mb-3">
                                <label class="form-label"
                                    for="basic-default-firstname">{{ trans('custodies/custodies_trans.remaining from the custody') }}</label>
                                <input type="text" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                    id="employeeAmount"
                                    placeholder="{{ trans('custodies/custodies_trans.residual custodies') }}"
                                    name="amount" value="" disabled />
                                @if ($errors->has('amount'))
                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    for="basic-default-residual_custody">{{ trans('custodies/custodies_trans.The amount to be liquidated') }}</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('residual_custody') ? 'is-invalid' : '' }}"
                                    id="basic-default-firstname"
                                    placeholder="{{ trans('custodies/custodies_trans.The amount to be liquidated') }}"
                                    name="residual_custody" value="{{ old('amount') }}" />
                                @if ($errors->has('residual_custody'))
                                    <span class="text-danger">{{ $errors->first('residual_custody') }}</span>
                                @endif
                            </div>


                            <div class="mb-3">
                                <label class="form-label"
                                    for="basic-default-firstname">{{ trans('custodies/custodies_trans.notes') }}</label>
                                <textarea id="" cols="10" rows="3"
                                    class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" id="basic-default-firstname"
                                    placeholder="{{ trans('custodies/custodies_trans.notes') }}" name="notes" value="{{ old('notes') }}"></textarea>
                                @if ($errors->has('notes'))
                                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                                @endif


                            </div>

                            <div class="col-12 text-center">
                                <button type="submit"
                                    class="btn btn-primary me-sm-3 me-1">{{ trans('drivers/drivers_trans.Submit') }}</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    {{ trans('companies/companies_trans.Cancel') }}
                                </button>
                            </div>


                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit User Modal -->

    </div>
@endsection
@section('js')
    <script>
        $(window).ready(function() {
            $("body").on('click', '.residualCustodyBtn', function() {
                var employeeId = $(this).attr('data-employee');
                var employeeAmount = $(this).attr('data-amount');
                $("#employeeAmount").val(employeeAmount);
                $(".employee_id").val(employeeId)
                $(".employeeAmount").val(employeeAmount)

                var customRoute = "{!! route('store.residual', ':id') !!}";
                customRoute = customRoute.replace(':id', employeeId);
                $("#residualCustodyForm").attr("action", customRoute);
                $("#residualCustody").modal('show');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#residualCustodyForm').validate({
                rules: {
                    residual_custody: {
                        required: true,
                        number: true,
                        min: 0,
                        max: function() {
                            var inputValue = $('#employeeAmount').val();
                            var floatValue = parseFloat(inputValue);
                            return floatValue;
                        }
                    },
                    notes: {
                        required: true
                    }
                },
                messages: {
                    residual_custody: {
                        required: "{{ trans('custodies/custodies_trans.Please enter the amount you want to filter') }}",
                        number: "{{ trans('custodies/custodies_trans.Please enter a valid numeric value') }}",
                        min: "{{ trans('custodies/custodies_trans.Please enter a value greater than or equal to') }} 0",
                        max: "{{ trans('custodies/custodies_trans.Enter a value less than or equal to') }} " +
                            $('#employeeAmount').val()
                    },
                    notes: {
                        required: "{{ trans('custodies/custodies_trans.Please enter notes') }}"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
