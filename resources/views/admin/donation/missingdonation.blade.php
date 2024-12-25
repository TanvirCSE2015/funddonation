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
                <h5 class="card-header">বাকি হাদিয়া</h5>
            </div>
            <div class="col-sm-6 pull-right" style="padding:1rem 2rem;text-align:right;">
                <a href="{{route('admin.newdonation')}}" class="btn btn-info text-white">নতুন হাদিয়া সংগ্রহ</a>
            </div>
        </div>
        <div style="text-align: center;">
            
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{route('admin.missingdonation',1)}}" class="btn btn-outline-secondary {{$num==1 ? 'secondary-active' : ''}}">মাসিক</a>
                <a href="{{route('admin.missingdonation',3)}}" class="btn btn-outline-secondary {{$num==3 ? 'secondary-active' : ''}}">ত্রৈমাসিক</a>
                <a href="{{route('admin.missingdonation',6)}}" class="btn btn-outline-secondary {{$num==6 ? 'secondary-active' : ''}}">অর্ধবার্ষিক</a>
                <a href="{{route('admin.missingdonation',12)}}" class="btn btn-outline-secondary {{$num==12 ? 'secondary-active' : ''}}">বার্ষিক</a>
            </div>
                          
        </div>
        <div class="table-responsive text-nowrap p-1">
           
            <table class="table" id="table">
            <thead>
                <tr>
                <th>ছবি</th>
                <th>নাম</th>
                <th>মোবাইল</th>
                
                <th>সর্বশেষ</th>
                <th>হাদিয়া</th>
                <th>বাকি</th>
                <th>নোট</th>                 
                <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            
            @foreach($donations as $row)
            @if($row->donar_type!='admin')
            <tr>
                <td><img class="w-px-40 h-auto rounded-circle" src="{{asset('assets/img/avatars/donar.png')}}" alt="avatar" srcset=""></td>
                <td>{{$row->name }}</td>
                <td>{{$row->phone }}</td>
                <td>{{$row->last_date }}</td>
                 @php
                  $note=DB::table('notes')->where(['user_id'=>$row->id,'note_month'=>date('m')])
                  ->orderBy('note_id','DESC')->first();
                  @endphp
                <td>{{  $numberToBangla->bnNum($row->amount) }}</td>
                <td>{{$numberToBangla->bnNum($row->num) }}</td>
                @if($note!=null)
                <td>{{$note->note}}</td>
                @else
                <td></td>
                @endif
                <td style="text-align:right;">
                    <div class="btn-group">
                        <a href="#" id="{{$row->id}}" onclick="openModel(this.id)" class="btn btn-success"  data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<i class='bx bxs-send'></i> <span>নোট লিখুন</span>"><i class='bx bx-notepad'></i></a>
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
 <!-- Extra Large Modal -->
 <div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            
            <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            ></button>
        </div>
        
        <div class="modal-body">
            <div id="user_info"></div>
            <div class="row g-2">
            <div class="col-sm-6 mb-0 border">
                <div class="table-responsive">
                    <table class="table" id="table_modal">
                        <thead>
                            <th>তারিখ</th>
                            <th>নোট</th>
                        </thead>
                        <tbody id="table_data">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-6 mb-0 pl-2">
                <form action="{{route('admin.insertnote')}}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="note_date" id="note_date" value="{{ date('d-m-Y') }}">
                    <input type="hidden" name="note_month" id="note_month" value="{{ date('m') }}">
                    <label for="dobExLarge" class="form-label">নোট লিখুন</label>
                    <textarea name="note" id="note" class="form-control" cols="30" rows="2"></textarea>
                    @error('note')
                    <div class="text-danger" id="error">{{ $message }}</div>
                    @enderror
                    <input type="submit" class="btn btn-info text-white mt-2" value="সংরক্ষন করুন">
                </form>
            </div>
            </div>
        </div>
        
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        var error=document.getElementById('error').innerText;
    if(error=='অনুগ্রহপূর্বক নোট লিখুন'){
        document.getElementById('user_id').value="{{Session::get('user_id')}}";
        $('#noteModal').modal('show');
    }
    })
    new DataTable('#modal_table');
    function openModel(id){
        document.getElementById('user_id').value=id;
       
        $.ajax({
            url:"{{ route('admin.notes') }}",
            type:'GET',
            data:{'id':id},
            success:function(output){
                
                if(output['code']==1){
                $('#user_info').html(output['user_html']);
                }else{
                    $('#user_info').html(output['user_html']);
                    
                    $('#table_modal').html(output['table_html']);
                }
                //
            }
        })
        $('#noteModal').modal('show');
    }
</script>
@endsection