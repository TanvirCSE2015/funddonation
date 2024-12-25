@extends('layouts.admin_template')
@section('title')
<title>User List | Donation</title>
@endsection
@section('main_content')
@php $sum=0;             
use lemonpatwari\BanglaNumber\NumberToBangla;
$numberToBangla = new NumberToBangla();
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="card-header">ডোনারের তালিকা</h5>
            </div>
            <div class="col-sm-6 pull-right" style="padding:1rem 2rem;text-align:right;">
                <a href="{{route('admin.adduser')}}" class="btn btn-info text-white" style="width:152px;" >নতুন যোগ করুন</a>
            </div>
        </div>
        <div style="text-align: center;">
            
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{route('admin.userlist',1)}}" class="btn btn-outline-secondary {{$num==1 ? 'secondary-active' : ''}}">মাসিক</a>
                <a href="{{route('admin.userlist',3)}}" class="btn btn-outline-secondary {{$num==3 ? 'secondary-active' : ''}}">ত্রৈমাসিক</a>
                <a href="{{route('admin.userlist',6)}}" class="btn btn-outline-secondary {{$num==6 ? 'secondary-active' : ''}}">অর্ধবার্ষিক</a>
                <a href="{{route('admin.userlist',12)}}" class="btn btn-outline-secondary {{$num==12 ? 'secondary-active' : ''}}">বার্ষিক</a>
                <a href="{{route('admin.userlist',0)}}" class="btn btn-outline-secondary {{$num==0 ? 'secondary-active' : ''}}">সাময়িক</a>
            </div>
                          
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table" id="table">
            <thead>
                <tr>
                <th>ছবি</th>
                <th>নাম</th>
                <th>মোবাইল</th>
                <th>ডোনারের ধরণ</th>
                <th>ঠিকানা</th>
                <th>চাঁদা</th>
                <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($users as $row)
            @if($row->donar_type!='admin')
            <tr>
                <td><a href="{{route('admin.userdetails',$row->id)}}"><img class="w-px-40 h-auto rounded-circle" src="{{asset('assets/img/avatars/donar.png')}}" alt="avatar" srcset=""></a></td>
                <td>{{$row->name }}</td>
                <td>{{$row->phone }}</td>
                <td>{{$row->donar_type }}</td>
                <td>{{$row->village . ", " . $row->upzila }}</td>
                <td>{{$numberToBangla->bnNum($row->amount) }}</td>
                <td style="text-align:right;">
                    <div class="btn-group">
                    <a href="{{route('admin.adddonation',$row->id)}}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>পেমেন্ট করুন</span>"><i class='bx bxl-paypal'></i></a>
                        <a href="{{route('admin.edituser',$row->id)}}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>আপডেট করুন</span>"><i class="bx bx-edit"></i></a>
                       
                        <a href="{{route('admin.deleteuser',$row->id)}}" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>ডিলিট করুন</span>"><i class="bx bx-trash"></i></a>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection