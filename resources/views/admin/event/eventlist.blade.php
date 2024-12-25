@extends('layouts.admin_template')
@section('title')
<title>Event List | Donation</title>
@endsection
@section('main_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="card-header">ইভেন্টের তালিকা</h5>
            </div>
            <div class="col-sm-6 pull-right" style="padding:1rem 2rem;text-align:right;">
                <a href="{{route('admin.createevent')}}" class="btn btn-info text-white">নতুন ইভেন্ট</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" id="table">
            <thead>
                <tr>
                
                <th>ইভেন্টের নাম</th>
                <th>তারিখ ও সময়</th>
                <th>বিবরন</th>
                <th></th>                
                <!-- <th></th> -->
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @php $sum=0;
             
            use lemonpatwari\BanglaNumber\NumberToBangla;
            $numberToBangla = new NumberToBangla();
           
            @endphp
            @foreach($events as $row)
           
            <tr>
                
                <td>{{$row->event_title }}</td>
                <td>{{$row->event_date }}</td>
                <td>{{$row->event_description }}</td>
                
                <td style="text-align:right;">
                    <div class="btn-group">
                        <a href="{{route('admin.editevent',$row->event_id)}}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>হালনাগাদ করুন</span>"><i class="bx bx-edit"></i></a>
                        <a href="{{route('admin.eventdetails',$row->event_id)}}" class="btn btn-info text-white" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<span>বিস্তারিত দেখুন</span>"><i class='bx bx-list-ul'></i></a>
                        <a href="{{route('admin.deleteuser',$row->event_id)}}" class="btn btn-danger"data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title=" <span>ডিলিট করুন </span>"><i class="bx bx-trash"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
           
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection