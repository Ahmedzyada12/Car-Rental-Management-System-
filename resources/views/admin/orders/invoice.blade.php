@extends('layouts.master')
@section('title', 'print invoice')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div id="print-invoice" class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                            <div class="mb-xl-0 mb-4">
                                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                    <img src="{{ asset('logo/' . $info->logo) }}" alt="logo" width="30px"
                                        height="30px">

                                    <span class="app-brand-text fw-bold fs-4"> Car </span>
                                </div>
                                <p class="mb-2">{{ $info->address }}</p>
                                <p class="mb-0">{{ $info->phone }}</p>
                            </div>
                            <div>
                                <h4 class="fw-medium mb-2">{{ trans('reservations/reservation_trans.invoice') }} #
                                    {{ $order->number }}</h4>
                                <div class="mb-2 pt-1">
                                    <span>{{ trans('reservations/reservation_trans.History issues') }}:</span>
                                    <span class="fw-medium">{{ date('Y-m-d') }}</span>
                                </div>
                                <div class="pt-1">
                                    <span>{{ trans('reservations/reservation_trans.due date') }}:</span>
                                    <span
                                        class="fw-medium">{{ \Carbon\Carbon::parse($order->date_from)->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                <h6 class="mb-3">{{ trans('reservations/reservation_trans.Invoice to') }}:</h6>
                                <p class="mb-1">{{ $order->customer->first_name . ' ' . $order->customer->last_name }}
                                </p>
                                {{-- <p class="mb-1">Shelby Company Limited</p> --}}
                                <p class="mb-1">{{ $order->customer->address }}</p>
                                <p class="mb-1">{{ $order->customer->phone }}</p>
                                <p class="mb-0">{{ $order->customer->email }}</p>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                {{-- <h6 class="mb-4">{{ trans('reservations/reservation_trans.Bill to') }}:</h6> --}}
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">{{ trans('reservations/reservation_trans.total') }}:</td>
                                            <td class="fw-medium">${{ $order->price }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">{{ trans('reservations/reservation_trans.Note') }} :</td>
                                            <td>{{ $order->note }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="pe-4">Country:</td>
                                            <td>United States</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">IBAN:</td>
                                            <td>ETD95476213874685</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">SWIFT code:</td>
                                            <td>BR91905</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border-top">
                        @php
                            $i = 0;
                        @endphp
                        <table class="table m-0">
                            <tr>
                                <td style="width: 30px">{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.Car name') }}</td>
                                <td>{{ $order->car->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.data from') }}</td>
                                <td>{{ $order->date_from }}</td>
                            </tr>
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.data to') }}</td>
                                <td>{{ $order->date_to }}</td>
                            </tr>
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.The destination') }}</td>
                                <td>{{ @$order->destinations->destination->from . '->' . @$order->destinations->destination->to }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.days number') }}</td>
                                <td>{{ $order->days }}</td>
                            </tr>
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.hours number') }}</td>
                                <td>{{ $order->hours }}</td>
                            </tr>
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ trans('reservations/reservation_trans.price') }}</td>
                                <td>{{ $order->price }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="card-body mx-3">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-medium">{{ trans('reservations/reservation_trans.Note') }}:</span>
                                <span>{{ trans('reservations/reservation_trans.note details') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        {{-- <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas"
                            data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="ti ti-send ti-xs me-2"></i>Send Invoice</span>
                        </button>
                        <button class="btn btn-label-secondary d-grid w-100 mb-2">Download</button>
                        <a class="btn btn-label-secondary d-grid w-100 mb-2" target="_blank"
                            href="{{ route('admin.orders.invoice', $order->order_id) }}">
                            Print
                        </a> --}}

                        <button id="downloadButton" class="btn btn-primary d-grid w-100 mb-2">Print</button>

                        {{-- <a href="./app-invoice-edit.html" class="btn btn-label-secondary d-grid w-100 mb-2">
                            Edit Invoice
                        </a>
                        <button class="btn btn-primary d-grid w-100" data-bs-toggle="offcanvas"
                            data-bs-target="#addPaymentOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="ti ti-currency-dollar ti-xs me-2"></i>Add Payment</span>
                        </button> --}}
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
        <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
            <div class="offcanvas-header my-1">
                <h5 class="offcanvas-title">{{ trans('reservations/reservation_trans.Send Invoice') }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-0 flex-grow-1">
                <form>
                    <div class="mb-3">
                        <label for="invoice-from"
                            class="form-label">{{ trans('reservations/reservation_trans.from') }}</label>
                        <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com"
                            placeholder="company@email.com" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">{{ trans('reservations/reservation_trans.to') }}</label>
                        <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com"
                            placeholder="company@email.com" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-subject"
                            class="form-label">{{ trans('reservations/reservation_trans.Subject') }}</label>
                        <input type="text" class="form-control" id="invoice-subject"
                            value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message"
                            class="form-label">{{ trans('reservations/reservation_trans.Message') }}</label>
                        <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">
Dear Queen Consolidated,
      Thank you for your business, always a pleasure to work with you!
      We have generated a new invoice in the amount of $95.59
      We would appreciate payment of this invoice by 05/11/2021</textarea
                  >
                </div>
                <div class="mb-4">
                  <span class="badge bg-label-primary">
                    <i class="ti ti-link ti-xs"></i>
                    <span class="align-middle">{{ trans('reservations/reservation_trans.Invoice Attached') }}</span>
                  </span>
                </div>
                <div class="mb-3 d-flex flex-wrap">
                  <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">{{ trans('reservations/reservation_trans.Submit') }}</button>
                  <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">{{ trans('reservations/reservation_trans.Cancel') }}</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Send Invoice Sidebar -->

          <!-- Add Payment Sidebar -->
          <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">
            <div class="offcanvas-header mb-3">
              <h5 class="offcanvas-title">{{ trans('reservations/reservation_trans.Add Payment') }}</h5>
              <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
              <div class="d-flex justify-content-between bg-lighter p-2 mb-3">
                <p class="mb-0">{{ trans('reservations/reservation_trans.Invoice Balance') }}:</p>
                <p class="fw-medium mb-0">$5000.00</p>
              </div>
              <form>
                <div class="mb-3">
                  <label class="form-label" for="invoiceAmount">{{ trans('reservations/reservation_trans.Payment Amount') }}</label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input
                      type="text"
                      id="invoiceAmount"
                      name="invoiceAmount"
                      class="form-control invoice-amount"
                      placeholder="100" />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment-date">{{ trans('reservations/reservation_trans.Payment Date') }}</label>
                  <input id="payment-date" class="form-control invoice-date" type="text" />
                </div>
                <div class="mb-3">
                  <label class="form-label" for="payment-method">{{ trans('reservations/reservation_trans.Payment Method') }}</label>
                  <select class="form-select" id="payment-method">
                    <option value="" selected disabled>{{ trans('reservations/reservation_trans.Select payment method') }}</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Paypal">Paypal</option>
                  </select>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="payment-note">Internal Payment Note</label>
                  <textarea class="form-control" id="payment-note" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="button" class="btn btn-primary me-3"
                            data-bs-dismiss="offcanvas">{{ trans('reservations/reservation_trans.Submit') }}</button>
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">{{ trans('reservations/reservation_trans.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script>
        document.getElementById('downloadButton').addEventListener('click', function() {
            var printContents = document.getElementById('print-invoice').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        });
    </script>
@endsection
