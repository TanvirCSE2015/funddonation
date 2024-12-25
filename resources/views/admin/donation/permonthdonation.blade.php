@extends('layouts.admin_template')
@section('title')
<title>DailyDonation | Donation</title>
@endsection
@section('main_content')
@php 
    use lemonpatwari\BanglaNumber\NumberToBangla;
    $numberToBangla = new NumberToBangla();
   $year1=2022;
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="card-header">{{$numberToBangla->bnMonth($month)}} মাসের হাদিয়াঃ {{' '.$numberToBangla->bnNum($sum)}} টাকা</h5>
            </div>
            <div class="col-sm-3" style="padding:1rem 2rem;text-align:left;">
                <select name="year" id="year" class="form-select">
                    @for($i=10; $i>1;$i--)
                    @if($year==($year1+10-$i))
                    <option value="{{route('admin.permonthdonation',[date('m'),$year1+10-$i])}}" selected>{{$year1+10-$i}}</option>
                    @elseif(date('Y')==($year1+10-$i))
                    <option value="{{route('admin.permonthdonation',[date('m'),$year1+10-$i])}}">{{$year1+10-$i}}</option>
                    @else
                    <option value="{{route('admin.permonthdonation',[1,$year1+10-$i])}}">{{$year1+10-$i}}</option>
                    @endif
                    @endfor
                </select>
            </div>
            <div class="col-sm-3 pull-right" style="padding:1rem 2rem;text-align:right;">
                
                <a href="{{route('admin.newdonation')}}" class="btn btn-info text-white">নতুন হাদিয়া সংগ্রহ</a>
            </div>
        </div>
        
        <div class="table-responsive text-nowrap p-1">
            <div style="text-align:center">
                <div class="btn-group mb-2" role="group" aria-label="Basic example">
                    <a href="{{route('admin.permonthdonation',1)}}" class="btn btn-secondary btn-padding {{$month ==1 ? 'btn-active' : ''}}">January</a>
                    <a href="{{route('admin.permonthdonation',2)}}" class="btn btn-secondary btn-padding {{$month ==2 ? 'btn-active' : ''}}">February</a>
                    <a href="{{route('admin.permonthdonation',3)}}" class="btn btn-secondary btn-padding {{$month ==3 ? 'btn-active' : ''}}">March</a>
                    <a href="{{route('admin.permonthdonation',4)}}" class="btn btn-secondary btn-padding {{$month ==4 ? 'btn-active' : ''}}">April</a>
                    <a href="{{route('admin.permonthdonation',5)}}" class="btn btn-secondary btn-padding {{$month ==5 ? 'btn-active' : ''}}">May</a>
                    <a href="{{route('admin.permonthdonation',6)}}" class="btn btn-secondary btn-padding {{$month ==6 ? 'btn-active' : ''}}">June</a>
                    <a href="{{route('admin.permonthdonation',7)}}" class="btn btn-secondary btn-padding {{$month ==7 ? 'btn-active' : ''}}">July</a>
                    <a href="{{route('admin.permonthdonation',8)}}" class="btn btn-secondary btn-padding {{$month ==8 ? 'btn-active' : ''}}">August</a>
                    <a href="{{route('admin.permonthdonation',9)}}" class="btn btn-secondary btn-padding {{$month ==9 ? 'btn-active' : ''}}">September</a>
                    <a href="{{route('admin.permonthdonation',10)}}" class="btn btn-secondary btn-padding {{$month ==10 ? 'btn-active' : ''}}">October</a>
                    <a href="{{route('admin.permonthdonation',11)}}" class="btn btn-secondary btn-padding {{$month ==11 ? 'btn-active' : ''}}">November</a>
                    <a href="{{route('admin.permonthdonation',12)}}" class="btn btn-secondary btn-padding {{$month ==12 ? 'btn-active' : ''}}">December</a>
                </div>
            </div>
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