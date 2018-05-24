<?php

namespace App\Http\Controllers\DeviceInfo;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DevInfo;
use App\IpInfo;
use App\Company;
use Input,Redirect,Auth;

class DeviceInfoController extends Controller
{
	public $module = 'device_info';
	public $parent_module = 'dev_analysis';
	
	public function index(Request $request)
	{
		$cps = Company::All();
		$key = $request->input('key');
		$company = $request->input('company');
		$ip = $request->input('ip');
		$version= $request->input('version');
		if (isset($key)) {
			$ip_info = IpInfo::where('sn', 'like', '%'.$key.'%');
			if (isset($company) && $company != '') {
				$ip_info = $ip_info->where('oem',  $company);
			}
			if (isset($ip) && $ip != '') {
				$ip_info = $ip_info->where('dev_ip', $ip);
			}
			if (isset($version) && $version != '') {
				$ip_info = $ip_info->where('version', $version);
			}
			$ip_info = $ip_info->latest('updated_at')->paginate(15);
		} else {
			$ip_info = IpInfo::latest('updated_at')->paginate(15);
		}
		return view('device_info.index')->withIp_info($ip_info)->withCps($cps)->withInput(Input::all());
	}
	
}
