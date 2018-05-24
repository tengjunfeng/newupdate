<?php

namespace App\Http\Controllers\UpdateTrend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UpdateTrend;
use Input,Redirect,Auth;

class UpdateTrendController extends Controller
{
    public function index()
	{
		return view('update_trend.index');
	}
}
