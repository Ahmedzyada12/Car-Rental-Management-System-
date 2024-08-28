@extends('layouts.master')
@section('title', 'قائمة الفواتير')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        {{-- <div class="offcanvas offcanvas-end" id="add-new-record">

            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicFullname">{{ trans('vehicles sections/vehicles_trans.section name') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="ssss" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="section_name" class="form-control dt-section_name" name="section_name"
                                aria-describedby="basicFullname2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label"
                            for="last_name">{{ trans('vehicles sections/vehicles_trans.Hourly price') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="hourprice" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="hourprice" class="form-control dt-hourprice" name="hourprice"
                                aria-describedby="hourprice2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label"
                            for="basicPost">{{ trans('vehicles sections/vehicles_trans.Price per day') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class="ti ti-briefcase"></i></span>
                            <input type="text" id="dayprice" name="dayprice" class="form-control dt-dayprice"
                                aria-describedby="basicPost2" />
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-primary data-submit me-sm-3 me-1">{{ trans('vehicles sections/vehicles_trans.add') }}</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('vehicles sections/vehicles_trans.cancle') }}</button>
                    </div>
                </form>
            </div>
        </div> --}}

        <div class="card">
            @if (session('mail'))
                <div class="alert alert-success" role="alert">
                    {{ session('mail') }}
                </div>
            @endif
            @if (session('not_found'))
                <div class="alert alert-danger" role="alert">
                    {{ session('not_found') }}
                </div>
            @endif
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic50 table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('invoices/invoices_trans.customer') }}</th>
                            <th>{{ trans('invoices/invoices_trans.due date') }}</th>
                            <th>{{ trans('invoices/invoices_trans.amount') }}</th>
                            <th>{{ trans('invoices/invoices_trans.paid') }}</th>
                            <th>{{ trans('invoices/invoices_trans.Remaining') }}</th>
                            <th>{{ trans('invoices/invoices_trans.status') }}</th>
                            <th>{{ trans('vehicles sections/vehicles_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->

        <div class="modal fade" id="invoicemodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">

                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <form action="{{ route('admin.invoice.changeStatus') }}" method="post" id="residualCustodyForm"
                            class="row g-3">
                            @csrf
                            <div class="text-center mb-4">
                                <h3 class="mb-2">{{ trans('invoices/invoices_trans.change status') }}</h3>
                            </div>
                            <input type="hidden" id="invoice_id" name="invoice_id" value="">
                            {{-- <input type="hidden" class="employeeAmount" name="employeeAmount" value=""> --}}

                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="basic-default-firstname">{{ trans('invoices/invoices_trans.status') }}</label>
                                    <select id="status-select" style="padding: 5px 10px"
                                        class="form-select form-select-lg {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="status">
                                        <option value="2">{{ trans('invoices/invoices_trans.Unpaid') }}</option>
                                        <option value="1">{{ trans('invoices/invoices_trans.paid') }}</option>
                                        <option value="3">{{ trans('invoices/invoices_trans.Partially paid') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" id="on_simi_paid"
                                style="display: none; {{ session('more_than') ? 'display:flex;' : '' }}">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="paid">{{ trans('invoices/invoices_trans.paid') }}</label>
                                        <input type="text"
                                            class="form-control {{ $errors->has('paid') ? 'is-invalid' : '' }}"
                                            id="paid" placeholder="99" name="paid" value="{{ old('paid') }}" />
                                        @if (session('more_than'))
                                            <span class="text-danger">{{ session('more_than') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="due-paid">{{ trans('invoices/invoices_trans.Remaining') }}</label>
                                        <input type="text" disabled class="form-control" id="due-paid" value="" />
                                        @if ($errors->has('more_than'))
                                            <span class="text-danger">{{ $errors->first('more_than') }}</span>
                                        @endif
                                    </div>
                                </div>
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

    </div>
@endsection
@section('js')
    <script>
        $(window).ready(function() {

            $("body").on('click', '.invoiceclass', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var amount = $(this).data('amount');
                var paid = $(this).data('paid');
                var remaining = $(this).data('remaining');
                console.log([id, status, amount, paid, remaining]);

                $('#invoice_id').val(id);
                $('#due-paid').data('total', remaining);
                console.log($('#due-piad').data('total'))
                // var staus_select = $('#status-select').val();
                $('#status-select option').each(function() {
                    if ($(this).val() == status) {
                        $(this).prop('selected', true);
                        if (status == 3) {
                            $('#on_simi_paid').show()
                        } else {
                            $('#on_simi_paid').hide()
                        }
                    }
                });
                // $('#paid').val(paid);
                $('#due-paid').val(remaining);

            })
            // var remaining = $('#due-paid').val();
            $('#paid').on('change', function() {
                var remaining = $('#due-paid').val();
                console.log(remaining);
                console.log($(this).val());
                if (parseFloat($(this).val()) > parseFloat(remaining)) {
                    alert('Paid amount cannot be greater than the total remaining');
                    $(this).val('');
                } else {
                    // var price = $('#due-paid').data(amount);
                    console.log(parseFloat(remaining) - parseFloat($(this).val()))
                    $('#due-paid').val(parseFloat(remaining) - parseFloat($(this).val()));
                }
            });
        });
    </script>
    <script>
        $('#status-select').on('change', function() {
            var value = $(this).val()
            // console.log(value)
            if (value == 3) {
                $('#on_simi_paid').show()
            } else {
                $('#on_simi_paid').hide()
            }
        })
    </script>
@endsection
