<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Type;

class TypeController extends Controller
{
    public function TypeList(){
      $types=Type::all();
      return view('admin.type.typelist',compact('types'));
    }
    public function AddType(){
        return view('admin.type.addtype');
    }
    public function InserType(Request $request){
        $request->validate(['type_name'=>'required']
        ,[
            'type_name.required' => 'অনুগ্রহপূর্বক নাম(ডোনারের ধরন) দিন'
           
        ]);
        unset($request['_token']);
        Type::insert($request->all());
        return redirect()->route('admin.typelist')->with(["alert_type"=>"success","message"=>"সফল ভাবে সংরক্ষিত হয়েছে"]);
    }

    public function EditType($id){
        $type=Type::where('type_id',$id)->first();
        return view('admin.type.edittype',compact('type'));
    }
    public function UpdateType(Request $request){
        $type=Type::where('type_id',$request->type_id)->first();
        unset($request['_token']); $request=$request->all();
        if($type!="" || $type!=null){
            Type::where('type_id',$request['type_id'])->update($request);
           return redirect()->route('admin.typelist')->with(["alert_type"=>"success","message"=>"সফল ভাবে হালনাগাদ হয়েছে"]); 
        }
    }
    public function DeleteType($id){
        Type::where('type_id',$id)->delete();
        return redirect()->route('admin.typelist')->with(["alert_type"=>"success","message"=>"সফল ভাবে মুছে ফেলা হয়েছে"]);
    }
}
