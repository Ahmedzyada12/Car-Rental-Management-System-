{{-- @extends('layouts.master')
@section('title', trans('custodies/custodies_trans.filter custodies'))

@section('css')
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> تصفيه عهده/</span> </h4>
            <div class="row">
                <!-- Basic Layout -->
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">تصفيه عهده </h5>
                            <small class="text-muted float-end">تصفيه عهده</small>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-firstname">المتبقي من العهده</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname" placeholder="مبلغ العهده" name="amount"
                                        value="{{ $residual }}" disabled />
                                    @if ($errors->has('amount'))
                                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-residual_custody">المبلغ المراد
                                        تصفيته</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('residual_custody') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname" placeholder="المبلغ المراد تصفيته"
                                        name="residual_custody" value="{{ old('amount') }}" />
                                    @if ($errors->has('residual_custody'))
                                        <span class="text-danger">{{ $errors->first('residual_custody') }}</span>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-firstname">ملاحظات</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}"
                                        id="basic-default-firstname" placeholder="ملاحظات" name="notes"
                                        value="{{ old('notes') }}" />
                                    @if ($errors->has('notes'))
                                        <span class="text-danger">{{ $errors->first('notes') }}</span>
                                    @endif
                                </div>

                                <button type="submit"
                                    class="btn btn-primary">{{ trans('companies/companies_trans.Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end Form -->
            </div>
        </div>
    </div>

@endsection --}}
