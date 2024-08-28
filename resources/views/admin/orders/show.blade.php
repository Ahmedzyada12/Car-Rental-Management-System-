@extends('layouts.master')
@section('title', 'تعديل قسم')

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> تعديل  /</span> قسم جديد </h4>
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">تعديل قسم</h5>
                        <small class="text-muted float-end">تعديل قسم</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.category.edit', ['id' => $category->category_id]) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-name">اسم القسم</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="basic-default-name" placeholder="sidan" name="name" value="{{ $category->name }}" />
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-hourlyprice"> السعر بالساعه</label>
                                <input type="text" class="form-control {{ $errors->has('hourlyprice') ? 'is-invalid' : '' }}" id="basic-default-price" placeholder="500" name="hourlyprice" value="{{ $category->hourlyprice }}" />
                                @if ($errors->has('hourlyprice'))
                                    <span class="text-danger">{{ $errors->first('hourlyprice') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-dailyprice"> السعر باليوم</label>
                                <input type="text" class="form-control {{ $errors->has('dailyprice') ? 'is-invalid' : '' }}" id="basic-default-dailyprice" placeholder="500" name="dailyprice" value="{{ $category->dailyprice }}" />
                                @if ($errors->has('dailyprice'))
                                    <span class="text-danger">{{ $errors->first('dailyprice') }}</span>
                                @endif
                            </div>









                            <button type="submit" class="btn btn-primary">إرسال</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end Form -->
        </div>
    </div>
</div>
@endsection
