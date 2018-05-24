<?php

namespace App\Http\Controllers\CompanyDevice;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CompanyDevice;
use Input,Redirect,Auth;

class CompanyDeviceController extends Controller
{
    public function index()
	{
		return view('company_device.index');
	}
}
