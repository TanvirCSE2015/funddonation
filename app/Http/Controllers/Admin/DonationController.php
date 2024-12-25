<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Type;
use App\Models\Admin\Donation;
use App\Models\Admin\Installment;
use App\Models\User;
use lemonpatwari\BanglaNumber\NumberToBangla;
use App\Helpers\Converter;
use App\Helpers\Helpers;
use Carbon\Carbon;
class DonationController extends Controller
{
    public function NewDonation(){
        $types=Type::all();
        return view('admin.donation.newdonation',compact('types'));
    }

    public function AddDonation($id){
        $user=User::find($id);
        $total_month=0;
        $num=0;

        date_default_timezone_set('Asia/Dhaka');
        $end_month=date('m');
        $end_year=date('Y');
        $last_year=$user->last_year;
        $last_month=$user->last_month;
        if($last_year>$end_year){
           $total_month=$end_month-($last_month+12); 
        }else{
            $total_month=$end_month-$last_month;
        }
        
        if($user->donar_type=="মাসিক"){
            $num=intdiv($total_month,1);
        }elseif($user->donar_type=="ত্রৈমাসিক"){
            $num=intdiv($total_month,3);
        }elseif($user->donar_type=="অর্ধ বার্ষিক"){
            $num=intdiv($total_month,6);
        }elseif($user->donar_type=="বার্ষিক"){
            $num=intdiv($total_month,12);
        }elseif($user->donar_type=="সাময়িক"){
            $num=0;
        }
        
        $types=Type::all();
        $donation=Donation::where(['donation_date'=>$user->last_date,'user_id'=>$id])
        ->orderBy('id','DESC')->first();
        return view('admin.donation.adddonation',compact('user','types','num','donation'));
    }

    public function InsertNewDonation(Request $request){
        $request->validate([
            'name'=>'required','phone'=>'required','donar_type'=>'required','donation'=>'required'
        ],
        [
            'name.required' => 'অনুগ্রহপূর্বক নাম দিন',
            'phone.required' => 'অনুগ্রহপূর্বক মোবাইল নাম্বার দিন',
            'donar_type.required' => 'অনুগ্রহপূর্বক সিলেক্ট করুন',
            'donation.required' => 'অনুগ্রহপূর্বক হাদিয়ার পরিমান দিন'
           
        ]);
        unset($request['_token']);
       
        $instalment=$request->instalment;
        
        unset($request['instalment']);
        $phone=$request->phone;
        $amount=Converter::bn2en($request->donation);
        $donation['donation_amount']=Converter::bn2en($request->donation);
        unset($request['donation']);
        $data=$request->all();
        $data['phone']=Converter::en2bn($phone);
        $data['amount']=$amount;
        Helpers::send_sms(Converter::bn2en($request->phone),'আপনি ' . Converter::en2bn($amount) . 'টাকা হাদিয়া দিয়েছেন'. '<br>'.
    'জামিয়া নিযামিয়া ময়মনসিংহ');
        $id=User::insertGetId($data);


        date_default_timezone_set('Asia/Dhaka');
        $donation['user_id']=$id;
        $donation['donation_date']=date('d-m-Y');
        $donation['month']=date('m');
        $donation['donation_time']=date('h:i:s a');
        $donation['donation_year']=date('Y');
        $donation['installment_no']=$instalment;
        $donation_id=Donation::insertGetId($donation);

        
        $num=0;
        if($request->donar_type=="মাসিক"){
            $num=1;
        }elseif($request->donar_type=="ত্রৈমাসিক"){
            $num=3;
        }elseif($request->donar_type=="অর্ধ বার্ষিক"){
            $num=6;
        }elseif($request->donar_type=="বার্ষিক"){
            $num=12;
        }elseif($request->donar_type=="সাময়িক"){
            $num=1;
        }
        $ins_data=array();
        $cal_month=date('m') ;
        $last_year=date('Y');
        for($i=1;$i<=$instalment;$i++){
            $temp['user_id']=$id;
            $temp['ins_date']=date('d-m-Y');
            $temp['ins_amount']=intdiv($amount,$instalment);
            $temp['donation_id']=$donation_id;
            
                if($i>1){
                    $cal_month=$cal_month + $num;
                }
                if($cal_month>12){
                    $cal_month=$cal_month-12;
                    $temp['ins_month']=$cal_month;
                    $temp['ins_year']=date('Y')+1;
                    $last_year=date('Y')+1;
                }else{
                   
                    $temp['ins_month']=$cal_month;
                    $temp['ins_year']=date('Y');
                }
            
                $ins_data[]=$temp;
           
        }
        Installment::insert($ins_data);

        User::find($id)->update(['last_date'=>date('d-m-Y'),
        'amount'=>intdiv($amount,$instalment),'last_month'=> $cal_month,'last_year'=>$last_year]);
        // return 'dailydonation';
        return redirect()->route('admin.dailydonation')->with(['alert_type'=>'success','message'=>'হাদিয়া সফলভাবে যোগ হয়েছে']);
        

    }

    public function InsertDonation(Request $request,$id){
        $request->validate([
            'donation'=>'required'
        ],
        [
            'donation.required' => 'অনুগ্রহপূর্বক হাদিয়ার পরিমান দিন'
           
        ]);
        $last_month=$request->last_month;
        $end_month=date('m');
        $last_year=$request->last_year;
        date_default_timezone_set('Asia/Dhaka');
        $end_year=date('Y');
        $donation['user_id']=$id;
        $donation['donation_amount']=Converter::bn2en($request->donation);
        
        $donation['donation_date']=date('d-m-Y');
        $donation['month']=date('m');
        $donation['donation_time']=date('h:i:s a');
        $donation['donation_year']=date('Y');
        $donation['installment_no']=$request->instalment;
        
        Helpers::send_sms(Converter::bn2en($request->phone),'আপনি ' . Converter::bn2en($request->donation) . 'টাকা জমা দিয়েছেন জামিয়া নিযামিয়া');
        $donation_id=Donation::insertGetId($donation);
        $instalment_amount=$request->donation/$request->instalment;
        $num=0;
        $amount=Converter::bn2en($request->donation);
        if($request->donar_type=="মাসিক"){
            $num=1;
        }elseif($request->donar_type=="ত্রৈমাসিক"){
            $num=3;
        }elseif($request->donar_type=="অর্ধ বার্ষিক"){
            $num=6;
        }elseif($request->donar_type=="বার্ষিক"){
            $num=12;
        }elseif($request->donar_type=="সাময়িক"){
            $num=1;
        }
        $ins_data=array();
        $cal_month=$request->last_month ;
        for($i=1;$i<=$request->instalment;$i++){
            $temp['user_id']=$id;
            $temp['ins_date']=date('d-m-Y');
            $temp['ins_amount']=intdiv($amount,$request->instalment);
            $temp['donation_id']=$donation_id;
            $cal_month=$cal_month + $num;
            
                if($cal_month>12){
                    $cal_month=$cal_month-12;
                    $temp['ins_month']=$cal_month;
                    $last_year=$last_year+1;
                    $temp['ins_year']=$last_year;
                    
                }else{
                   
                    $temp['ins_month']=$cal_month;
                    $temp['ins_year']=$last_year;
                }
            
            
            $ins_data[]=$temp;
        }
        Installment::insert($ins_data);

        User::find($id)->update(['last_date'=>$donation['donation_date'],
        'last_year'=>$last_year,'last_month'=> $cal_month]);
        //return 'admin.dailydonation';
        return redirect()->route('admin.dailydonation')->with(['alert_type'=>'success','message'=>'হাদিয়া সফলভাবে যোগ হয়েছে']);
    }

    public function DailyDonation(){
        date_default_timezone_set('Asia/Dhaka');
        $today=date('d-m-Y');
        $sum=User::join('donations','users.id','donations.user_id')
        ->where('donation_date',$today)->sum('donation_amount');
        $donations=User::join('donations','users.id','donations.user_id')
        ->select('users.name','users.phone','users.donar_type','donations.*')->where('donation_date',$today)->get();
        //return $diffInDays;
        return view('admin.donation.dailydonations',compact('donations','sum'));
    }

    public function PermonthDonation($month=null,$year=null){
        if($month==null){
            $month=date('m');           
        }
        if($year==null){
            $year=date('Y');
        }
        $donations=Donation::join('users','donations.user_id','users.id')
            ->select('users.name','users.donar_type','users.phone','donations.*')
            ->where(['month'=>$month,'donation_year'=>$year])->get();
            $sum=Donation::join('users','donations.user_id','users.id')->where(['month'=>$month,'donation_year'=>$year])->sum('donation_amount');
        return view('admin.donation.permonthdonation',compact('donations','month','sum','year'));
        
    }

    public function MissingDonation($num=null){
        
        $donations=array();
        date_default_timezone_set('Asia/Dhaka');
        $end=date('d-m-Y');
        $endDate = Carbon::parse( $end);
        $i=0;
        if($num==null || $num==1){
            $num=1;
            $type='মাসিক';
        }elseif ($num==3) {
            $type='ত্রৈমাসিক';
        }elseif ($num==6) {
            $type='অর্ধ বার্ষিক';
        }else{
            $type='বার্ষিক';
        }
        $users=User::where('donar_type',$type)->get();
        
        foreach($users as $key=>$user){
            $date=$user->last_date;
            $startDate = Carbon::parse($date);
            $diffInMonths = $startDate->diffInMonths($endDate);
            if($diffInMonths>=$num){
                $donations[$i]=$user;
                $donations[$i]['num']=intdiv($diffInMonths,$num);
            }
        }
       
        return view('admin.donation.missingdonation',compact('donations','num'));
    }
}
