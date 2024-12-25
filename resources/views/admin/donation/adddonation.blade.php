@extends('layouts.admin_template')
@section('title')
<title>User List | Donation</title>
@endsection
@section('main_content')
@php 
    use lemonpatwari\BanglaNumber\NumberToBangla;
    $numberToBangla = new NumberToBangla();

@endphp
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
                <h5 class="mb-0">হাদিয়া ফর্ম(নিয়মিত)</h5>
                @if($num < 0)
                <div class="btn-group float-end" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary">এডভান্সঃ {{$numberToBangla->bnNum(-$num)}}</button>
                    <button type="button" class="btn btn-secondary">চাঁদাঃ {{$numberToBangla->bnNum(intdiv($donation->donation_amount,$donation->installment_no))}} টাকা</button>
                    <button type="button" class="btn btn-secondary">মোট হাদিয়াঃ {{$numberToBangla->bnNum(-$num*intdiv($donation->donation_amount,$donation->installment_no))}} টাকা</button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <form action="{{route('admin.insertdonation',$user->id)}}" method="post" id="donation_form">
                    @csrf
                    <input type="hidden" name="donar_type" value="{{ $user->donar_type }}">
                    <input type="hidden" name="last_month" value="{{ $user->last_month }}">
                    <input type="hidden" name="last_year" value="{{ $user->last_year }}">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">ডোনারের নাম </label>
                                <div class="col-sm-9">
                                    <input type="text" readonly value="{{$user->name}} ({{($user->donar_type. ' দাঁতা')}})" class="form-control" id="name" name="name" placeholder="নাম লিখুন" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">মোবাইল </label>
                                <div class="col-sm-9">
                                    <input type="text" readonly value="{{$user->phone}}" class="form-control" id="phone" name="phone" placeholder="মোবাইল নাম্বার লিখুন" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                @if($num<=0)
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">এডভান্স </label>
                                @else
                                <label class="col-sm-3 col-form-label text-right" for="basic-default-name">বাকি </label>
                                @endif
                                <div class="col-sm-5">
                                    <select name="instalment" id="instalment" readonly class="form-select">
                                        <!-- <option id="defaultSelect" value="">শ্রেনী নির্বাচন করুন</option> -->
                                        @for($i=1; $i<=12; $i++)
                                        @if($i==$num)
                                        <option selected value="{{$i}}">{{$i}}</option>
                                        @else
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endif
                                        @endfor
                                    </select>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    
                                </div>
                                <div class="col-sm-4">
                                        <input type="text" disabled value="{{$user->amount}}" class="form-control" id="amount" name="amount" placeholder="চাঁদার পরিমান লিখুন">
                                    </div>
                                
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-right pt-0" for="basic-default-name">আদায়কৃত <span class="text-danger" style="font-size: large;">*</span></label>
                                <div class="col-sm-9">
                                    @if($num>0)
                                    <input type="text" value="{{$user->amount * $num}}" class="form-control" id="donation" name="donation" placeholder="হাদিয়া লিখুন (টাকায়)" style="border-color: rebeccapurple;" />
                                    @else
                                    <input type="text" value="{{$user->amount}}" class="form-control" id="donation" name="donation" placeholder="হাদিয়া লিখুন (টাকায়)" style="border-color: rebeccapurple;" />
                                    @endif
                                    @error('donation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                   
                <div class="row">
                    <div class="col-sm-6">
                       
                    </div>
                    <div class="col-sm-6">
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">হালনাগাদ করুন</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    
        
    <!-- <div class="col-3">
            <button type="button" class="btn btn-primary" onclick=printDiv();>Print</button>
    </div> -->
    <div id="printDiv" style="display: none;">
        <div class="col-sm-4">
            <div class="card">
                <h6 class="card-header text-center">জামিয়া নিযামিয়া মাদ্রাসা, মধ্যবাড়েরা,ময়মনসিংহ</h6>
                <p class="text-center mb-0">(দাঁতার কপি)</p>
                <p class="text-center border-bottom">তারিখঃ {{date('d-m-Y')}}</p>
            
                <p class='text-center mb-0'>{{$user->name}}</p>
                <p class='text-center'>({{$user->donar_type}} দাঁতা)</p>
                <p class='text-center'>মোবাইলঃ {{$user->phone}}</p>
                <p class='text-center'>হাদিয়ার পরিমানঃ <span id="d_amount">{{$numberToBangla->bnNum($user->amount * $num)}}</span> টাকা</p>
            
            </div>
            
        </div>

        <div class="col-sm-4 mt-2">
            <div class="card">
                <h6 class="card-header text-center">জামিয়া নিযামিয়া মাদ্রাসা, মধ্যবাড়েরা,ময়মনসিংহ</h6>
                <p class="text-center mb-0">(প্রাতিষ্ঠানিক কপি)</p>
                <p class="text-center border-bottom">তারিখঃ {{date('d-m-Y')}}</p>
            
                <p class='text-center mb-0'>{{$user->name}}</p>
                <p class='text-center'>({{$user->donar_type}} দাঁতা)</p>
                <p class='text-center'>মোবাইলঃ {{$user->phone}}</p>
                <p class='text-center'>হাদিয়ার পরিমানঃ <span id="p_amount">{{$numberToBangla->bnNum($user->amount * $num)}}</span> টাকা</p>
            
            </div>
            
        </div>
    </div>
   
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
         $("#donation").on("keyup",function(){
          var amount=$(this).val();
          document.getElementById('d_amount').innerText=amount;
          document.getElementById('p_amount').innerText=amount;
         });
         $('#instalment').on('change',function(){
            var num = this.value;
            var total=num * {{$user->amount}};
            document.getElementById('p_amount').innerText=total;
            document.getElementById('d_amount').innerText=total;
            document.getElementById('donation').value=total;
            
         })
      });
    
      function printDiv(){
        var printContents = document.getElementById("printDiv").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

            window.print();   
        
      }
</script>
<script>
    $(document).ready(function(){
        $('#donation_form').submit(function(e){
            e.preventDefault();
            var href=this.action;
            var formData= new FormData(this)
            $.ajax({
                url: href,
                type:'POST',
                data:formData,
                processData: false,
                contentType: false,
                success:function(output){
                    printDiv();
                    
                    localStorage.setItem("message", "হাদিয়া সফলভাবে যোগ হয়েছে");
                    window.location="{{route('admin.dailydonation')}}";
                   
                }
            });
        });
    });
</script>
@endsection