<?php

namespace App\Http\Controllers\UpdateLog;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DevInfo;
use App\Company;
use Input,Redirect,Auth;
use App\FileTypes;

class UpdateLogController extends Controller
{
    public $module = 'update_log';
    public $parent_module = 'dev_analysis';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cps = Company::All();
	$fts = FileTypes::All(); 
	$key = $request->input('key');
	$company = $request->input('company');
	$ip = $request->input('ip');
	$sys_id = $request->input('sys_id');
	if (isset($key)) {
		$devs = DevInfo::where('T_DEVICE_SN', 'like', '%'.$key.'%');
		if (isset($company) && $company != '') {
			$devs = $devs->where('oem_name',  $company);
		}
		if (isset($ip) && $ip != '') {
			$devs = $devs->where('T_DEVICE_IP', $ip);
		}
		if (isset($sys_id) && $sys_id != '') {
			$devs = $devs->where('T_REQ_PACK_ID', $sys_id);
		}
		$devs = $devs->latest('id')->paginate(15);
	} else {
		$devs = DevInfo::latest('id')->paginate(15);
	}
	return view('update_log.index')->withDevs($devs)->withCps($cps)->withFts($fts)->withInput(Input::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
