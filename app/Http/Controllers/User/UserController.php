<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public $module = 'user';
    //public $parent_module = 'sys_analysis';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
	$users = User::paginate(10);

	return view('user.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required',
			'email' => 'required',
			'level' => 'required',
			'password' => 'required',
			'password_confirmation' => 'required',
		]);
		$user_name = $request->input('name');
		$user_level = $request->input('level');
		$user_email = $request->input('email');
		$user_pwd = $request->input('password');
		$user_pwd_conf = $request->input('password_confirmation');
		
		if($user_pwd != $user_pwd_conf){
			return Redirect::back()->withInput()->withErrors('两次输入密码不一致');
		}
		
		$new_user = new User;
		
		$new_user->name = $user_name;
		$new_user->level = $user_level;
		$new_user->email = $user_email;
		$new_user->password = bcrypt($user_pwd);
		$new_user->save();
		
		return Redirect::to('user');
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
