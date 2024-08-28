@extends('layouts.master')
@section('title', 'قائمة الاقسام')
@section('css')

@endsection
@section('content')
    <!-- Bootstrap Table with Header - Light -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Modal to add new record -->


        <!--/ DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic12 table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{ trans('drivers/drivers_trans.Driver name') }}</th>
                            <th>{{ trans('drivers/drivers_trans.Maintenance time') }}</th>
                            <th>{{ trans('managers/managers_trans.Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
    </div>
@endsection
