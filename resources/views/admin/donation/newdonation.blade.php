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
                <h5 class="mb-0">নতুন হাদিয়ার ফর্ম</h5>
                <small class="text-muted float-end">Default label</small>
            </div>
            <div class="card-body">
                <form action="{{route('admin.insertnewdonation')}}" method="post" id="donation_form">
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
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label text-right pt-0" for="basic-default-name">আদায়কৃত <span class="text-danger" style="font-size: large;">*</span></label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select name="instalment" id="instalment" class="form-control">
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="donation" name="donation" placeholder="আদায়কৃত হাদিয়ার পরিমান লিখুন(টাকায়)" />
                                        @error('donation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>

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
    <div id="printDiv">
        <div class="col-sm-4">
            <div class="card">
                <h6 class="card-header text-center">জামিয়া নিযামিয়া মাদ্রাসা, মধ্যবাড়েরা,ময়মনসিংহ</h6>
                <p class="text-center mb-0">(দাঁতার কপি)</p>
                <p class="text-center border-bottom">তারিখঃ {{date('d-m-Y')}}</p>
            
                <p class='text-center mb-0' id="d_name"></p>
                <p class='text-center' id="d_type">( )</p>
                <p class='text-center' id="d_phone">মোবাইলঃ </p>
                <p class='text-center' >হাদিয়ার পরিমানঃ <span id="d_amount"></span> টাকা</p>
            
            </div>
            
        </div>

        <div class="col-sm-4 mt-2">
            <div class="card">
                <h6 class="card-header text-center">জামিয়া নিযামিয়া মাদ্রাসা, মধ্যবাড়েরা,ময়মনসিংহ</h6>
                <p class="text-center mb-0">(প্রাতিষ্ঠানিক কপি)</p>
                <p class="text-center border-bottom">তারিখঃ {{date('d-m-Y')}}</p>
            
                <p class='text-center mb-0' id="p_name"></p>
                <p class='text-center' id="p_type">( )</p>
                <p class='text-center' id="p_phone">মোবাইলঃ </p>
                <p class='text-center'>হাদিয়ার পরিমানঃ <span id="p_amount"></span> টাকা</p>
            
            </div>
            
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
         $("#name").on("change",function(){
          var value=$(this).val();
          document.getElementById('d_name').innerText=value;
          document.getElementById('p_name').innerText=value;
         });
         
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
            var name= document.getElementById('name').value;
            var phone= document.getElementById('phone').value;
            var type= document.getElementById('donar_type').value;
            var donation= document.getElementById('donation').value;

            document.getElementById('d_name').innerText=name;
            document.getElementById('p_name').innerText=name;

            document.getElementById('d_type').innerText=type;
            document.getElementById('p_type').innerText=type;

            document.getElementById('d_phone').innerText=phone;
            document.getElementById('p_phone').innerText=phone;

            document.getElementById('d_amount').innerText=donation;
            document.getElementById('p_amount').innerText=donation;
            
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
        })
    })
</script>
@endsection