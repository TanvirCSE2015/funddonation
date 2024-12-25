@extends('layouts.admin_template')
@section('title')
<title>Update Event | Donation</title>
@endsection
@section('main_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form action="{{route('admin.updateeventsms')}}" method="post">
        @csrf
        <input type="hidden" name="ev_id" value={{$ev_id}}>
        <div class="row">
            <div class="col-sm-12">
                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label text-right" for="basic-default-name" style="min-width:8rem;">বার্তা সিলেক্ট <span class="text-danger" style="font-size: large;">*</span></label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach($templates as $template)
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="message_id" id="message_id" value="{{$template->id}}">
                                        <label class="form-check-label" for="message_id">{{$template->body}}</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1" style="min-width:8rem;">
                    
                   </div> 
                    <div class="col-sm-6">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">সংরক্ষন করুন</button>
                            </div>
                        
                    </div>  
                </div>
            </div>
        </div>
    </form>
</div>
@endsection