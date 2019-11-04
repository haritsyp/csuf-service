<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class LoginController extends Controller
{
	public function login(Request $request)
	{
		$user = User::where('username', $request->username)->where('password', md5($request->password))->first();
		if (isset($user->username)) {
			$user->last_login = Carbon::now();
			$user->save();
			session(['username' => $user->username]);
			return redirect('/#/home');
		}else{
			return back()->with(['failed', 'Username atau Password anda salah']);
		}
	}

	function destroy(Request $request){
		session()->flush();
		return redirect('/');
	}
}
