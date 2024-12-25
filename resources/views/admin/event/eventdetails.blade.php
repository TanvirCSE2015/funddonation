@extends('layouts.admin_template')
@section('title')
<title>Event Details | Donation</title>
@endsection
@section('main_content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-sm-4">
            <h6>তারিখ ও সময়ঃ {{$event->event_date}}</h6>
            <h6>ইভেন্টের নামঃ {{$event->event_title}}</h6>
        </div>
        <div class="col-sm-8">
            <form action="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row mb-3">
                        
                        <label class="col-sm-1 col-form-label text-right pt-0" for="basic-default-name">বিবরন<span class="text-danger" style="font-size: large;">*</span></label>
                        <div class="col-sm-11">
                            <textarea name="event_description" disabled class="form-control" id="event_description" cols="30" rows="1">{{$event->event_description}}</textarea>
                            @error('event_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                
            </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="row">
            <div class="col-sm-2">
                <h5 class="card-header">ইভেন্ট মেম্বার</h5>
            </div>
            @php 
            $message=DB::table('message_templates')->where('id',$event->message_id )->first();
            @endphp
            <div class="col-sm-8">
                <form action="{{route('admin.sendsmsall')}}" method="post">
                @csrf
                @if(empty($message))
                <a href="{{route('admin.templateselect',$event->event_id)}}" class="btn btn-success mt-3">বার্তা টেমপ্লেট সিলেক্ট করুন</a>
                @else
                <input type="hidden" name="ev_id" value="{{$event->event_id}}">
                <input type="hidden" name="message_id" value="{{$message->id}}">
                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label text-right pt-0" for="basic-default-name">বার্তা <span class="text-danger" style="font-size: large;">*</span></label>
                    <div class="col-sm-7">
                        <textarea name="body" class="form-control" id="body" cols="30" rows="2">{{$message->body}}</textarea>
                        @error('body')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <input type="submit" class="btn btn-info" value="পাঠান">
                           <!-- <a type="submit" class="btn btn-info"><i class='bx bx-mail-send'></i></a> -->
                        </div>
                    </div>
                </div>
                @endif
                </form>
            </div>
            <div class="col-sm-2 pull-right mt-3">
                <a href="{{route('admin.getdonars',[$event->event_id])}}" class="btn btn-info text-white" style="width:152px;" >নতুন যোগ করুন</a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table" id="table">
                <thead>
                    <th>ছবি</th>
                    <th>নাম</th>
                    <th>মোবাইল</th>
                    <th>নোট</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($members as $row)
                    <tr>
                        <td><img class="w-px-40 h-auto rounded-circle" src="{{asset('assets/img/avatars/donar.png')}}" alt="avatar" srcset=""></td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->phone}}</td>
                        @if($row->ev_id=="" || $row->ev_id==null)
                        <td></td>
                        @else
                        <td class=""> <span class="badge bg-warning">{{$row->note}}</span></td>
                        @endif
                        <td>
                            <div class="btn-group">
                            <a href="#" id="{{$row->id}}" onclick="openModel(this.id)" class="btn btn-success"  data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title="<i class='bx bxs-send'></i> <span>নোট লিখুন</span>"><i class='bx bx-notepad'></i></a>
                                <a href="{{route('admin.removemember',$row->member_id)}}" class="btn btn-danger"data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="" data-bs-original-title=" <span>ডিলিট করুন </span>"><i class="bx bx-trash"></i></a>
                            </div>
                        </td>
                    </tr>
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
            <div class="row">
                <div class="col-sm-6">
                    <div id="user_info"></div>
                </div>
                <div class="col-sm-6">
                    <h6>{{$event->event_title}}</h6>
                    <h6>{{$event->event_date}}</h6>
                </div>
            </div>
            
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
                <form action="{{route('admin.inserteventnote')}}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="ev_id" id="ev_id" value="{{$event->event_id}}">
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
                $('#table_modal').append(output['table_html']);
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