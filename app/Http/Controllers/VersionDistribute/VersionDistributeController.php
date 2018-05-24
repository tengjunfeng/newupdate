<?php

namespace App\Http\Controllers\VersionDistribute;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\VersionDistribute;
use Input,Redirect,Auth;

class VersionDistributeController extends Controller
{
    public function index()
	{
		return view('version_distribute.index');
	}
}
