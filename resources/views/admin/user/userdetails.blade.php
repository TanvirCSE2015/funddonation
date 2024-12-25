@extends('layouts.admin_template')
@section('title')
<title>Donar Details | Donation</title>
@endsection
@section('main_content')
@php
use lemonpatwari\BanglaNumber\NumberToBangla;
$numberToBangla = new NumberToBangla();
$year1=2022;
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row pl-2 pr-2">
        <div class="col-sm-6">
            <h6 class="mb-1">{{$user->name}}</h6>
            <h6 class="mb-1">{{$user['phone']}}</h6>
            <h6>{{$user['donar_type']}} দাতা</h6>
        </div>
        <div class="col-sm-6 text-right mr-2">
            @if($instalment>0)
            <h6 class="mb-1">বাকিঃ {{$numberToBangla->bnNum($instalment)}}</h6>
            @else
            <h6 class="mb-1">এডভান্সঃ {{$numberToBangla->bnNum(-($instalment))}}</h6>
            @endif
            <h6 class="mb-1">চাঁদাঃ {{$numberToBangla->bnNum($user['amount'])}} টাকা</h6>
            @if($instalment>=0)
            <h6 class="mb-1">সর্বমোটঃ {{$numberToBangla->bnNum($instalment * $user['amount'])}} টাকা</h6>
            @else
            <h6 class="mb-1">সর্বমোটঃ {{$numberToBangla->bnNum(-($instalment * $user['amount']))}} টাকা</h6>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 pr-2 pl-2">
            <div class="card">
                <div class="row">
                    <div class="col-sm-8">
                        <h5 class="card-header">সর্বমোট হাদিয়াঃ {{$sum}} টাকা</h5>
                    </div>
                    <div class="col-sm-4 card-header">
                        <select name="year" id="year" class="form-select">
                            @for($i=10; $i>1;$i--)
                            @if($year==($year1+10-$i))
                            <option value="{{route('admin.userdetails',[$user->id,$year1+10-$i])}}" selected>{{$year1+10-$i}}</option>
                            @elseif(date('Y')==($year1+10-$i))
                            <option value="{{route('admin.userdetails',[$user->id,$year1+10-$i])}}">{{$year1+10-$i}}</option>
                            @else
                            <option value="{{route('admin.userdetails',[$user->id,$year1+10-$i])}}">{{$year1+10-$i}}</option>
                            @endif
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead>
                            <th>তারিখ</th>
                            <th>সময়</th>
                            <th>মাস</th>
                            <th>হাদিয়া</th>
                        </thead>
                        <tbody>
                            @foreach($details as $row)
                            <tr>
                                <td>{{$row->donation_date}}</td>
                                <td>{{$row->donation_time}}</td>
                                <td>{{$numberToBangla->bnMonth($row->month)}}</td>
                                <td>{{$numberToBangla->bnNum($row->donation_amount)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <h4 class="card-header">আদায়কৃত</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>মাস</th>
                            <th>চাঁদা</th>
                        </thead>
                        <tbody>
                            @foreach($ins_data as $ins)
                            <tr>
                                @if($num==1)
                                <td>{{$numberToBangla->bnMonth($ins->ins_month)}}</td>
                                @else
                                @php 
                                $month_num=$ins->ins_month+$num;
                                $month=($month_num > 12 ? $month_num-12 : $month_num);
                                @endphp
                                <td>{{$numberToBangla->bnMonth($ins->ins_month)}}-{{$numberToBangla->bnMonth($month)}}</td>
                                @endif
                                <td>{{$numberToBangla->bnNum($ins->ins_amount)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#year').on('change',function(){
            var href =$(this).val();
            window.location=href;
        });
    })
</script>
@endsection