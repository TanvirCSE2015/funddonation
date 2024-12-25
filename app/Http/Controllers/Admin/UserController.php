<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Type;
use App\Models\Admin\Donation;
use App\Models\Admin\Installment;

use App\Models\User;
use App\Helpers\Converter;

class UserController extends Controller
{
    public function UserList($num=null){
        $type="";
        if($num==null || $num==1){
            $num=1;
            $type='মাসিক';
        }elseif ($num==3) {
            $type='ত্রৈমাসিক';
        }elseif ($num==6) {
            $type='অর্ধ বার্ষিক';
        }elseif($num==12){
            $type='বার্ষিক';
        }else{
            $type='সাময়িক';
        }
        $users=User::where('donar_type',$type)->get();
        return view('admin.user.userlist',compact('users','num'));
    }
    public function AddUser(){
        $types=Type::all();
        return view('admin.user.adduser',compact('types'));
    }
    public function InsertUser(Request $request){
        unset($request['_token']);
        $request->validate(['name'=>'required','phone'=>'required',
        'donar_type'=>'required','amount'=>'required']
        ,[
            'name.required' => 'অনুগ্রহপূর্বক নাম দিন',
            'phone.required' => 'অনুগ্রহপূর্বক মোবাইল নাম্বার দিন',
            'donar_type.required' => 'অনুগ্রহপূর্বক সিলেক্ট করুন',
            'amount.required' => 'অনুগ্রহপূর্বক চাঁদার পরিমান দিন'
           
        ]);
        $phone=$request->phone;
        $amount=$request->amount;
        $data=$request->all();
        $data['phone']=Converter::en2bn($phone);
        $data['amount']=Converter::bn2en($amount);
        $id=User::insertGetId($data);
        return redirect()->route('admin.userlist')->with(['alert_type'=>'success','message'=>'ডোনার সফলভাবে যোগ হয়েছে' . $id]);
    }
    public function EditUser($id){
        $types=Type::all();
        $user=User::find($id);
        return view('admin.user.edituser',compact('user','types'));
    }
    public function UpdateUser(Request $request,$id){
        unset($request['_token']);
        $phone=$request->phone;
        $amount=$request->amount;
        $data=$request->all();
        $data['phone']=Converter::en2bn($phone);
        $data['amount']=Converter::bn2en($amount);
        $update=User::find($id)->update($data);
        return redirect()->route('admin.userlist')->with(['alert_type'=>'success','message'=>'ডোনার সফলভাবে হালনাগাদ হয়েছে']);
    }
    public function DeleteUser($id){
        User::find($id)->delete(); 
        return redirect()->route('admin.userlist')->with(['alert_type'=>'success','message'=>'ডোনার স্থায়ীভাবে ডিলিট হয়েছে']);
    }

    public function SearchUser(Request $request){
        
        $search=$request->search;
        if($search=="" || $search==null){
            return;
        }
        $data=User::where('name','like','%' . $search . '%')
        ->orwhere('phone','like','%' . $search . '%')->get();
        $output='';
        foreach($data as $row){
            $output.='<a href="'. route('admin.adddonation',$row->id).'" class="list-group-item list-group-item-action">'.'নামঃ- ' . $row->name .
            '<p>'.'মোবাইলঃ- '.$row->phone.'</p>'.'</a>';
        }
        return $output;

    }
    public function UserDetails($id,$year=null){
        if($year==null){
            $year=date('Y');
        }
        $details=User::join('donations','users.id','donations.user_id')
        ->select('users.*','donations.donation_date','donations.donation_amount',
        'donations.donation_time','donations.month')->where(['user_id'=>$id,'donation_year'=>$year])->get();
        $sum=Donation::where('user_id',$id)->sum('donation_amount');
        $user=User::find($id);
        $last_year=$user->last_year;
        $last_month=$user->last_month;
        date_default_timezone_set('Asia/Dhaka');
        $end_year=date('Y');
        $end_month=date('m');
        $total_month=0;
        $num=0;
        if($user->donar_type=="মাসিক"){
            $num=1;
        }elseif($user->donar_type=="ত্রৈমাসিক"){
            $num=3;
        }elseif($user->donar_type=="অর্ধ বার্ষিক"){
            $num=6;
        }elseif($user->donar_type=="বার্ষিক"){
            $num=12;
        }elseif($user->donar_type=="সাময়িক"){
            $num=1;
        }
        if($last_year>$end_year){
            $total_month=$end_month-($last_month+12);
        }else{
            $total_month=$end_month-$last_month;
        }

        $instalment=intdiv($total_month,$num);
        $ins_data=Installment::where(['user_id'=>$id,'ins_year'=>$year])->get();
        return view('admin.user.userdetails',compact('details','sum','instalment','num','ins_data','user','year'));
    }
}
