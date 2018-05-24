<?php

namespace App\Http\Controllers\UpdateMap;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UpdateMap;
use App\IpInfo;
use Input,Redirect,Auth,DB;

class UpdateMapController extends Controller
{
	public $module = 'update_map';
    public $parent_module = 'sys_analysis';
	
	public function index()
	{
		return view('update_map.baidu');
	}
/*
	public function query(Request $request)
    {
		//$ip_info_all = DB::table('sunya_ip_info')->select('city',DB::raw('count(*) as total'))->groupBy('city')->get();
		$ip_info_all = DB::table('sunya_ip_info')->select('*',DB::raw('count(*) as total'))->groupBy('sn')->get();
		return $ip_info_all;

    }*/
    public function query(Request $request)
    {
		
		$key = $request->input('key');
		$city = $request->input('city');
		

		if (isset($key)) {
			$ip_info_all = DB::table('sunya_ip_info')->where('sn','like', '%'.$key.'%');
			
			if (isset($city) && $city != '') {
				$ip_info_all = $ip_info_all->where('city', 'like', '%'.$city.'%');
			}
		
			$ip_info_all = $ip_info_all->select('*',DB::raw('count(*) as total'))->groupBy('sn')->get();
			
		} else {
			$ip_info_all = DB::table('sunya_ip_info')->select('*',DB::raw('count(*) as total'))->groupBy('sn')->get();
		}

		return  $ip_info_all;

    }
}
