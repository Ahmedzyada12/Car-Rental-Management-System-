@extends('layouts.master')
@section('title', 'اضافة فاتوره')

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ trans('managers/managers_trans.edit') }} /</span>
                {{ trans('invoices/invoices_trans.add invoice') }} </h4>
            @if (session('success'))
                <div class="alert alert-primary" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans('invoices/invoices_trans.edit invoice') }}</h5>
                            <small class="text-muted float-end">{{ trans('invoices/invoices_trans.edit invoice') }}</small>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.invoice.edit', $invoice->id) }}" method="post">
                                @csrf
                                <div class="col-md-12 mb-4">
                                    <label for="select2Basic"
                                        class="form-label">{{ trans('invoices/invoices_trans.select customer') }}</label>
                                    <select id="admin-select"
                                        class="select2 form-select form-select-lg {{ $errors->has('customer') ? 'is-invalid' : '' }}"
                                        data-allow-clear="true" name="customer">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->user_id }}"
                                                {{ $customer->user_id == $invoice->customer ? 'selected' : '' }}>
                                                {{ $customer->first_name . ' ' . $customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('customer'))
                                        <span class="text-danger">{{ $errors->first('customer') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="how">{{ trans('invoices/invoices_trans.email') }}</label>
                                    <input type="email" class="form-control" value="{{ old('email', $invoice->email) }}"
                                        id="email" name="email" placeholder="email" />
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="basic-default-firstname">{{ trans('invoices/invoices_trans.due date') }}</label>
                                            <input type="date"
                                                class="form-control {{ $errors->has('due_date') ? 'is-invalid' : '' }}"
                                                id="basic-default-firstname" placeholder="due date" name="due_date"
                                                value="{{ old('due_date', $invoice->due_date) }}" />
                                            @if ($errors->has('due_date'))
                                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="amount">{{ trans('invoices/invoices_trans.amount') }}</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                                id="amount" placeholder="due date" name="amount"
                                                value="{{ old('amount', $invoice->amount) }}" />
                                            @if ($errors->has('amount'))
                                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            for="basic-default-firstname">{{ trans('invoices/invoices_trans.status') }}</label>
                                        <select id="status-select" style="padding: 5px 10px" disabled
                                            class="form-select form-select-lg {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                            data-allow-clear="true" name="status">
                                            <option value="2" {{ $invoice->status == 2 ? 'selected' : '' }}>
                                                {{ trans('invoices/invoices_trans.Unpaid') }}
                                            </option>
                                            <option value="1"{{ $invoice->status == 1 ? 'selected' : '' }}>
                                                {{ trans('invoices/invoices_trans.paid') }}
                                            </option>
                                            <option value="3"{{ $invoice->status == 3 ? 'selected' : '' }}>
                                                {{ trans('invoices/invoices_trans.Partially paid') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row" id="on_simi_paid" style="">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="paid">{{ trans('invoices/invoices_trans.paid') }}</label>
                                            <input type="text" disabled
                                                class="form-control {{ $errors->has('paid') ? 'is-invalid' : '' }}"
                                                id="paid" placeholder="99" name="paid"
                                                value="{{ old('paid', $invoice->paid) }}" />
                                            @if (session('more_than'))
                                                <span class="text-danger">{{ session('more_than') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="due-paid">{{ trans('invoices/invoices_trans.Remaining') }}</label>
                                            <input type="text" value="{{ $invoice->amount - $invoice->paid }}" disabled
                                                class="form-control" id="due-paid" />
                                            @if ($errors->has('more_than'))
                                                <span class="text-danger">{{ $errors->first('more_than') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="how">{{ trans('invoices/invoices_trans.payment method') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('payment_method', $invoice->payment_method) }}" id="how"
                                        name="payment_method" />
                                    @if ($errors->has('payment_method'))
                                        <span class="text-danger">{{ $errors->first('payment_method') }}</span>
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

@section('js')
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

        $('#amount').on('change', function() {
            var amount = parseFloat($('#amount').val());
            var paid = parseFloat($('#paid').val());
            if (paid > amount) {
                alert('Paid amount cannot be greater than the total amount');
                $(this).val('');
            } else {
                $('#due-paid').val(amount - paid);
            }
        });
    </script>
@endsection
