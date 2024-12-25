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

class DashboardController extends Controller
{
    public function index(){
        date_default_timezone_set('Asia/Dhaka');
        $today=date('d-m-Y');
        $monthly=User::where('donar_type','মাসিক')->count();
        $trimonthly=User::where('donar_type','ত্রৈমাসিক')->count();
        $halfyearly=User::where('donar_type','অর্ধ বার্ষিক')->count();
        $yearly=User::where('donar_type','বার্ষিক')->count();
        $onetime=User::where('donar_type','সাময়িক')->count();
        $total_user=User::count();
        $total_donation=Donation::sum('donation_amount');
        $today_donation=Donation::where('donation_date',$today)->sum('donation_amount');
        $month_donation=Donation::where('month',date('m'))->sum('donation_amount');
        $type=Type::count();
        $types=[$monthly,$trimonthly, $halfyearly,$yearly,$onetime,$type];
        $donations=User::join('donations','users.id','donations.user_id')
        ->select('users.name','users.phone','users.donar_type','donations.*')->where('donation_date',$today)->get();
        return view('admin.dashboard',compact('donations','types','total_user','total_donation','today_donation','month_donation'));
    }
    public function EditAdmin(){
        return view('admin.editadmin');
    }
}
