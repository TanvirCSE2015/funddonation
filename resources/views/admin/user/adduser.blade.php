@extends('layouts.admin_template')
@section('title')
<title>New Donation | Donation</title>
@endsection
@section('main_content')
<style>
    .text-right{
        text-align: end;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Horizontal Layouts</h4> -->

        <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">ডোনার ফর্ম</h5>
                <small class="text-muted float-end">Default label</small>
            </div>
            <div class="card-body">
                <form action="{{route('admin.insertuser')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label pt-0 text-right" for="basic-default-name">ডোনারের নাম <span class="text-danger" style="font-size: large;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="নাম লিখুন" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">ইমেইল</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="ইমেইল লিখুন" />
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label pt-0  text-right" for="basic-default-name">মোবাইল <span class="text-danger" style="font-size: large;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="মোবাইল নাম্বার লিখুন" />
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label pt-0  text-right" for="basic-default-name">শ্রেনী ও চাঁদা <span class="text-danger" style="font-size: large;">*</span>  </label>
                                <div class="col-sm-5">
                                    <select name="donar_type" id="donar_type" class="form-select">
                                        <option id="defaultSelect" selected hidden value="">শ্রেনী নির্বাচন করুন</option>
                                        @foreach($types as $row)
                                        <option value="{{$row->type_name}}">{{$row->type_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('donar_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    
                                </div>
                                <div class="col-sm-4">
                                        <input type="text" class="form-control" id="amount" name="amount" placeholder="চাঁদার পরিমান লিখুন">
                                        @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">গ্রাম/মহল্লা/বাসা</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="village" name="village" placeholder="গ্রাম/মহল্লা/বাসা নাম্বার লিখুন" />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">পোস্ট অফিস</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="post" name="post" placeholder="ইমেইল লিখুন" />
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">উপজেলা</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="upzila" name="upzila" placeholder="উপজেলার নাম লিখুন" />
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">জেলা</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="district" name="district" placeholder="জেলার লিখুন" />
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">সংরক্ষন করুন</button>
                            </div>
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