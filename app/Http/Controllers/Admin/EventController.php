<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Event;
use App\Models\Admin\Type;
use App\Models\Admin\EventMember;
use App\Models\Admin\Note;
use App\Models\Admin\MessageTemplate;
use lemonpatwari\BanglaNumber\NumberToBangla;
use App\Helpers\Converter;
use App\Helpers\Helpers;
use App\Models\User;
use Carbon\Carbon;

class EventController extends Controller
{
    public function CreateEvent(){
        $types=Type::all();
        $templates=MessageTemplate::all();
        return view('admin.event.createevent',compact('types','templates'));
    }
    public function InsertEvent(Request $request){
        $request->validate([
            'event_title'=>'required','event_date'=>'required','event_description'=>'required'
        ],
        ['event_title.required'=>'ইভেন্টের নাম দিন',
        'event_date.required'=>'ইভেন্টের তারিখ ও সময় দিন',
        'event_description.required'=>'ইভেন্টের বিবরন দিন']);
        $date=Carbon::createFromFormat('d-m-Y h:m a',$request->event_date);
        $month=$date->format('m');
        unset($request['_token']);
        $data=$request->all();
        $data['event_month']= $month;
        if(isset($data['event_message'])){
        $message=MessageTemplate::where('body',$data['event_message'])->first();
        if($message){
            $data['message_id']= $message->id;
            }
        }
        Event::insert($data);
        
        return redirect()->route('admin.eventlist')->with(['alert_type'=>'success','message'=>'ইভেন্ট সফলভাবে যোগ হয়েছে']);
    }

    public function EditEvent($id){
        $event=Event::where('event_id',$id)->first();
        $templates=MessageTemplate::all();
        return view('admin.event.editevent',compact('event','templates'));
    }

    public function UpdateEvent(Request $request){
        $id=$request->id;
        unset($request['id']);
        $request->validate([
            'event_title'=>'required','event_date'=>'required','event_description'=>'required'
        ],
        ['event_title.required'=>'ইভেন্টের নাম দিন',
        'event_date.required'=>'ইভেন্টের তারিখ ও সময় দিন',
        'event_description.required'=>'ইভেন্টের বিবরন দিন']);
        $date=Carbon::createFromFormat('d-m-Y h:m a',$request->event_date);
        $month=$date->format('m');
        unset($request['_token']);
        
        $data=$request->all();
        $data['event_month']= $month;
        if(isset($data['event_message'])){
            $message=MessageTemplate::where('body',$data['event_message'])->first();
            if($message){
                $data['message_id']= $message->id;
                }
            }
        Event::where('event_id',$id)->update($data);
        
        return redirect()->route('admin.eventlist')->with(['alert_type'=>'success','message'=>'ইভেন্ট সফলভাবে হালনাগাদ হয়েছে']);
    }

    public function EventDetails($id,$recent=null){
        if($recent==null){
            $event=Event::where('event_id',$id)->first();
            $members=EventMember::join('users','event_members.user_id','users.id')
            ->leftJoin('notes',function($left){
                $left->on('event_members.user_id','notes.user_id')->on('event_members.event_id','notes.ev_id');
            })
            ->select('users.id','users.name','users.phone','users.donar_type','event_members.*','notes.note','notes.ev_id')
            ->where('event_members.event_id',$id,)->orderBy('member_id','DESC')->get();
        }else{
            $event=Event::orderBy('event_id','DESC')->first();
            $members=EventMember::join('users','event_members.user_id','users.id')
            ->leftJoin('notes',function($left){
                $left->on('event_members.user_id','notes.user_id')->on('event_members.event_id','notes.ev_id');
            })
            ->select('users.id','users.name','users.phone','users.donar_type','event_members.*','notes.note','notes.ev_id')
            ->where('event_id',$event->event_id)->orderBy('member_id','DESC')->get();
        }
       
        return view('admin.event.eventdetails',compact('event','members'));
    }
    
    public function EventList(){
        $events=Event::orderBy('event_id','DESC')->get();
        return view('admin.event.eventlist',compact('events'));
    }

    public function GetDonars($ev_id,$type=null){
        if($type==null){
            $donars=User::where('donar_type','মাসিক')->get();
            $type='মাসিক';
        }else {
            $donars=User::where('donar_type',$type)->get();
        }
        return view('admin.event.getdonars',compact('donars','type','ev_id'));
    }
    public function AssignEvent(Request $request){
        if($request->exists('donar')){
            foreach($request->donar as $key=> $id){
                $find=EventMember::where(['user_id'=>$key,'event_id'=>$request->ev_id])->first();
                if($find){

                }else{
                    unset($request['_token']);
                    $temp['event_id']=$request->ev_id;
                    $temp['user_id']=$key;
                    $temp['add_date']=date('d-m-Y');
                    
                    $data[]=$temp; 
                }
            }
            
            EventMember::insert($data);
            return redirect()->route('admin.eventdetails',$request->ev_id)
            ->with(['alert_type'=>'success','message'=>'মেম্বার সফলভাবে যোগ হয়েছে']);
        }else{
            return redirect()->back()->with(['alert_type'=>'error','message'=>'ডোনার সিলেক্ট করুন']);
        }
    }

    public function RemoveMember($id){
        EventMember::where('member_id',$id)->delete();
        return redirect()->back()->with(['alert_type'=>'success','message'=>'ডোনার সফলভাবে রিমোভ হয়েছে']);
    }

    public function AssignAll($ev_id,$type){
        
        $data=array();
        $donars=User::where('donar_type',$type)->get();
        foreach($donars as $donar){
            $find=EventMember::where(['user_id'=>$donar->id,'event_id'=>$ev_id])->first();
            if($find){

            }else{
                $temp['event_id']=$ev_id;
                $temp['user_id']=$donar->id;
                $temp['add_date']=date('d-m-Y');
                $data[]=$temp;
            }
            
        }
        
        EventMember::insert($data);
        return redirect()->route('admin.eventdetails',$ev_id)
        ->with(['alert_type'=>'success','message'=>'মেম্বার সফলভাবে যোগ হয়েছে']);
    }
    public function InserEventNote(Request $request){
        Session::put('user_id', $request->user_id);
        $request->validate(['note'=>'required'],
        ['note.required'=>'অনুগ্রহপূর্বক নোট লিখুন']);
        unset($request['_token']);
        Note::insert($request->all());
        return redirect()->back()->with(['alert_type'=>'success','message'=>'নোট সফলভাবে যোগ হয়েছে']);
    }
    public function SendMessageAll(Request $request){
        
        $ev_id=$request->ev_id;
        $message_id=$request->message_id;
        unset($request['_token']);
        unset($request['ev_id']);
        unset($request['message_id']);
        $members=EventMember::join('users','event_members.user_id','users.id')
        ->select('users.phone','users.id')->where('event_id',$ev_id)->get();
        date_default_timezone_set('Asia/Dhaka');
        
        
        $note=array();
        foreach($members as $row){
            
            $find=Note::where(['user_id'=>$row->id,'ev_id'=>$ev_id])->get();
           
            if(count($find)==0){
                Helpers::send_sms(Converter::bn2en($row->phone),$request->body.' জামিয়া নিযামিয়া ময়মনসিংহ');
                $temp=['user_id'=>$row->id,'note_date'=>date('d-m-Y'),'note_month'=>date('m'),
                'note'=>'বার্তা পাঠানো হয়েছে','ev_id'=>$ev_id];
                $note[]=$temp;
            }
        }
        
        if(count($note)>0){
            Note::insert($note);
        }else{
            return redirect()->back()->with(['alert_type'=>'warning','message'=>'বার্তা সফলভাবে পাঠানো হয়েছিল']); 
        }
        Event::where('event_id',$ev_id)->update(['event_message',$request->body]);
        return redirect()->back()->with(['alert_type'=>'success','message'=>'বার্তা সফলভাবে পাঠানো হয়েছে']);
    }

    public function TemplateSelect($ev_id){
        $templates=MessageTemplate::all();
        return view('admin.event.selecttemplate',compact('templates','ev_id'));
    }
    public function UpdateEventSms(Request $request){
        
        Event::where('event_id',$request->ev_id)->update(['message_id'=>$request->message_id]);
        return redirect()->route('admin.eventdetails',$request->ev_id)->with(['alert_type'=>'success','message'=>'বার্তা সফলভাবে সিলেক্ট হয়েছে']);

    }
}
