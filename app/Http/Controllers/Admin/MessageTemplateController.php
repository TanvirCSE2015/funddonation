<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\MessageTemplate;
use App\Helpers\Converter;
use App\Helpers\Helpers;
class MessageTemplateController extends Controller
{
    public function MessageTemplate(){
        $templates= MessageTemplate::orderBy('id','DESC')->get();
        return view('admin.SMS.message_template',compact('templates'));
    }

    public function MessageBody(Request $request){
        $request->validate(['body'=>'required'],['body.required'=>'অনুগ্রহপূর্বক বার্তা লিখুন']);
        unset($request['_token']);
        $id=MessageTemplate::insertGetId($request->all());
        return redirect()->route('admin.message_template')->with(['alert_type'=>'success','message'=>'টেমপ্লেট সফলভাবে যোগ হয়েছে' . $id]);
    }
    public function UpdateMessageBody(Request $request,$id){
        $request->validate(['body'=>'required'],['body.required'=>'অনুগ্রহপূর্বক বার্তা লিখুন']);
        unset($request['_token']);
        MessageTemplate::where('id',$id)->update($request->all());
        return redirect()->back()->with(['alert_type'=>'success','message'=>'টেমপ্লেট সফলভাবে হালনাগাত হয়েছে' . $id]);
    }
}
