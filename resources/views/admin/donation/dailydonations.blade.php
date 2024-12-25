@extends('layouts.admin_template')
@section('title')
<title>DailyDonation | Donation</title>
@endsection
@section('main_content')
@php 
             
    use lemonpatwari\BanglaNumber\NumberToBangla;
    $numberToBangla = new NumberToBangla();

@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="card-header">আজকের হাদিয়াঃ {{$numberToBangla->bnNum($sum)}} টাকা</h5>
            </div>
            <div class="col-sm-6 pull-right" style="padding:1rem 2rem;text-align:right;">
                <a href="{{route('admin.newdonation')}}" class="btn btn-info text-white">নতুন হাদিয়া সংগ্রহ</a>
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
                <th>তারিখ</th>
                <th>হাদিয়া</th>                
                <!-- <th></th> -->
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            
            @foreach($donations as $row)
            @if($row->donar_type!='admin')
            <tr>
            <td><a href="{{route('admin.userdetails',$row->user_id)}}"><img class="w-px-40 h-auto rounded-circle" src="{{asset('assets/img/avatars/donar.png')}}" alt="avatar" srcset=""></a></td>
                <td>{{$row->name }}</td>
                <td>{{$row->phone }}</td>
                <td>{{$row->donar_type }}</td>
                <td>{{$row->donation_date }}</td>
                
                <td>{{  $numberToBangla->bnNum($row->donation_amount) }}</td>
                <!-- <td style="text-align:right;">
                    <div class="btn-group">
                        <a href="{{route('admin.edituser',$row->id)}}" class="btn btn-success"><i class="bx bx-edit"></i></a>
                        <a href="{{route('admin.deleteuser',$row->id)}}" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                    </div>
                </td> -->
            </tr>
            
            @endif
            @endforeach
           
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection