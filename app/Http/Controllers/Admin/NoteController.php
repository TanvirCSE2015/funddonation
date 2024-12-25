<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Admin\Note;
use App\Models\User;

class NoteController extends Controller
{
    public function GetNotes(Request $request){
       
        $notes=User::join('notes','users.id','notes.user_id')
        ->select('users.name','users.phone','notes.*')->where('user_id',$request->id)->get();

        $count = count($notes);
        $output=array();
        $table="";
        $user=User::find($request->id);
        $user_html='<h5 class="modal-title" id="exampleModalLabel4">'.$user->name."</h5>"
        ."<p>".$user->phone."</p>";
        if( $count==0){
           $output['code']=1;
           $output['user_html']=$user_html;
           $output['table_html']=$table;
          
        }else{
            foreach($notes as $note){
                $table.='<tr>
                <td>'. $note->note_date .'</td>
                <td>'. $note->note .'</td>
            </tr>';
            }
            $output['code']=2;
            $output['user_html']=$user_html;
            $output['table_html']=$table;
        }
        
        return $output;
    }
    public function InsertNote(Request $request){
        Session::put('user_id', $request->user_id);
        $request->validate(['note'=>'required'],
        ['note.required'=>'অনুগ্রহপূর্বক নোট লিখুন']);
        unset($request['_token']);
        Note::insert($request->all());
        return redirect()->back()->with(['alert_type'=>'success','message'=>'নোট সফলভাবে যোগ হয়েছে']);
    }
}
