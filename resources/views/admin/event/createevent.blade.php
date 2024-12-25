@extends('layouts.admin_template')
@section('title')
<title>Create Event | Donation</title>
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
                <h5 class="mb-0"> ইভেন্টের ফর্ম</h5>
                <small class="text-muted float-end">Default label</small>
            </div>
            <div class="card-body">
                <form action="{{route('admin.insertevent')}}" method="post" id="donation_form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label pt-0 text-right" for="basic-default-name">ইভেন্টের নাম <span class="text-danger" style="font-size: large;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="event_title" name="event_title" placeholder="নাম লিখুন" />
                                    @error('event_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right pt-0" for="basic-default-name" >তারিখ ও সময় <span class="text-danger" style="font-size: large;">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="event_date" name="event_date" placeholder="তারিখ ও সময় লিখুন" />
                                    @error('event_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row mb-3">
                            <label class="col-sm-1 col-form-label text-right pt-0" for="basic-default-name" style="min-width:8rem;">ইভেন্টের বর্নণা <span class="text-danger" style="font-size: large;">*</span></label>
                            <div class="col-sm-10">
                                <textarea name="event_description" class="form-control" id="event_description" cols="30" rows="2"></textarea>
                                @error('event_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    
                </div>
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
                                                <input class="form-check-input" type="radio" name="event_message" id="eventmessage" value="{{$template->body}}">
                                                <label class="form-check-label" for="message_id">{{$template->body}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
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
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection