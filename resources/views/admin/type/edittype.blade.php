@extends('layouts.admin_template')
@section('title')
<title>Edit Type | Admin </title>
@endsection
@section('main_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Horizontal Layouts</h4> -->

        <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">ডোনারের ধরণ যোগ করার ফর্ম</h5>
                <small class="text-muted float-end">Default label</small>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.updatetype') }}" method="post">
                    @csrf
                    <input type="hidden" name="type_id" value="{{$type->type_id}}">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">নাম  (ডোনারের ধরণ)</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="type_name" name="type_name" placeholder="মাসিক" value="{{$type->type_name}}" />
                    @error('type_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">হালনাগাদ করুন</button>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection