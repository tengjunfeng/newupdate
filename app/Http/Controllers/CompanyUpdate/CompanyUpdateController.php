<?php

namespace App\Http\Controllers\CompanyUpdate;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CompanyUpdate;
use App\DevInfo;
use Input,Redirect,Auth,DB;

class CompanyUpdateController extends Controller
{
	public $module = 'company_update';
    public $parent_module = 'sys_analysis';
	
    public function index()
	{
		return view('company_update.index');
	}
	
	public function query(Request $request)
    {
		$dev_sn_all = DB::table('sunya_dev_info')->whereNotNull('oem_code')->whereNotNull('T_DEVICE_SN')->select('oem_code',DB::raw('count(*) as total'))->groupBy('oem_code')->get();
		$dev_sn_week = DB::table('sunya_dev_info')->whereNotNull('oem_code')->where('updated_at','>',date("Y-m-d H:i:s",time()-(7 * 24 * 60 * 60)))->whereNotNull('T_DEVICE_SN')->select('oem_code',DB::raw('count(*) as total'))->groupBy('oem_code')->get();
		//$dev_sn_week = $dev_sn_all::where('updated_at','>',date("Y-m-d H:i:s",time()-(30 * 24 * 60 * 60)))->get();
		$dev_sn_month = DB::table('sunya_dev_info')->whereNotNull('oem_code')->where('updated_at','>',date("Y-m-d H:i:s",time()-(30 * 24 * 60 * 60)))->whereNotNull('T_DEVICE_SN')->select('oem_code',DB::raw('count(*) as total'))->groupBy('oem_code')->get();
		$dev_sn_year = DB::table('sunya_dev_info')->whereNotNull('oem_code')->where('updated_at','>',date("Y-m-d H:i:s",time()-(365 * 24 * 60 * 60)))->whereNotNull('T_DEVICE_SN')->select('oem_code',DB::raw('count(*) as total'))->groupBy('oem_code')->get();
		//$dev_sn_all= json_encode($dev_sn_all);
				
		foreach($dev_sn_all as $sn){
			$cps = CompanyUpdate::where('code',$sn->oem_code)->first();
			$cps->num_all = $sn->total;
			$cps->save();
		}
		foreach($dev_sn_week as $sn){
			$cps = CompanyUpdate::where('code',$sn->oem_code)->first();
			$cps->num_week = $sn->total;
			$cps->save();
		}
		foreach($dev_sn_month as $sn){
			$cps = CompanyUpdate::where('code',$sn->oem_code)->first();
			$cps->num_month = $sn->total;
			$cps->save();
		}
		foreach($dev_sn_year as $sn){
			$cps = CompanyUpdate::where('code',$sn->oem_code)->first();
			$cps->num_year = $sn->total;
			$cps->save();
		}
		
		//$cps->save();
		$cps = CompanyUpdate::all();
		return $cps->toJson();
    }
}
