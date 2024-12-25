@extends('layouts.admin_template')
@section('title')
<title>Donar List | Donation</title>
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
                <a href="{{route('admin.eventdetails',$ev_id)}}" class="btn btn-info text-white" style="width:152px;" >ইভেন্টের বিবরন</a>
            </div>
        </div>
        <div style="text-align: center;">
            
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{route('admin.getdonars',[$ev_id])}}" class="btn btn-outline-secondary {{$type=='মাসিক' ? 'secondary-active' : ''}}">মাসিক</a>
                <a href="{{route('admin.getdonars',[$ev_id,'ত্রৈমাসিক'])}}" class="btn btn-outline-secondary {{$type=='ত্রৈমাসিক' ? 'secondary-active' : ''}}">ত্রৈমাসিক</a>
                <a href="{{route('admin.getdonars',[$ev_id,'অর্ধ বার্ষিক'])}}" class="btn btn-outline-secondary {{$type=='অর্ধ বার্ষিক' ? 'secondary-active' : ''}}">অর্ধবার্ষিক</a>
                <a href="{{route('admin.getdonars',[$ev_id,'বার্ষিক'])}}" class="btn btn-outline-secondary {{$type=='বার্ষিক' ? 'secondary-active' : ''}}">বার্ষিক</a>
                <a href="{{route('admin.getdonars',[$ev_id,'সাময়িক'])}}" class="btn btn-outline-secondary {{$type=='সাময়িক' ? 'secondary-active' : ''}}">সাময়িক</a>
            </div>
                          
        </div>
        <div class="table-responsive text-nowrap">
        <form action="{{route('admin.assignevent')}}" method="post">
            @csrf
            <input type="hidden" name="ev_id" value="{{$ev_id}}"> 
            <table class="table" id="table">
            <thead>
                <tr>
                <th>ছবি</th>
                <th>নাম</th>
                <th>মোবাইল</th>
                <th>ডোনারের ধরণ</th>
                <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            
            @foreach($donars as $row)
            @if($row->donar_type!='admin')
            <tr>
                <td><img class="w-px-40 h-auto rounded-circle" src="{{asset('assets/img/avatars/donar.png')}}" alt="avatar" srcset=""></td>
                <td>{{$row->name }}</td>
                <td>{{$row->phone }}</td>
                <td>{{$row->donar_type }}</td>
                <td>
                    @php
                    $find=DB::table('event_members')->where(['user_id'=>$row->id,'event_id'=>$ev_id])->first();
                     @endphp
                     @if($find)
                     <div class="form-check mt-3">
                        <input type="hidden" name="donarlist[]" value="{{$row->id}}">
                        <input class="form-check-input" type="checkbox" value="add" checked="" disabled name="donar[{{$row->id}}]" id="defaultCheck1">
                        
                    </div>
                     @else
                    <div class="form-check mt-3">
                        <input type="hidden" name="donarlist[]" value="{{$row->id}}">
                        <input class="form-check-input" type="checkbox" value="add" name="donar[{{$row->id}}]" id="defaultCheck1">
                        
                    </div>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
            </tbody>
            </table>
               <div class="text-center">
                <div class="btn-group">
                    <input type="submit" class="btn btn-info mb-2" value="ডোনার ইভেন্টে যোগ করুন">
                    <a href="{{route('admin.assignall',[$ev_id,$type])}}" class="btn btn-success mb-2"><i class='bx bx-plus-medical'></i>&nbsp;সব ডোনার যোগ করুন</a>
                </div>
               </div>

            </form>
        </div>
    </div>
</div>
@endsection