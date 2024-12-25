@extends('layouts.admin_template')
@section('title')
<title>SMS Template | Donation</title>
@endsection
@section('main_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                @foreach($templates as $row)
                <div class="col-sm-6 mb-3">
                    <div class="card p-2">
                        <h6 class="card-header p-0">টেমপ্লেটঃ &nbsp; {{$row->id}}</h6>
                        <form action="{{route('admin.updatemessagebody',$row->id)}}" method="post">
                            @csrf
                            <div class="mb-3">
                               
                                <label class="form-label" for="basic-default-fullname">বার্তা</label>
                                <textarea name="body"  id="body" cols="30" rows="3" class="form-control">{{$row->body}}</textarea>
                                @error('body')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-info" value="হালনাগাদ করুন">
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card  p-4">
                <h6 class="card-header">নতুন বার্তা টেমপ্লেট যোগ করুন</h6>
                <form action="{{route('admin.messagebody')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">বার্তা লিখুন</label>
                        <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
                        @error('body')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-info" value="সরক্ষন করুন">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection