<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{

    public function _construct()
    {
        /* 仅允许游客访问登录页面 */
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    public function create()
    {
    	return view('sessions.create');
    }

    public function store(Request $request)
    {
    	$credentials = $this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    	]);

    	if (Auth::attempt($credentials, $request->has('remember'))) {
    		session()->flash('success','欢迎回来！');
    		return redirect()->intended(route('users.show', [Auth::user()]));  
    		//Auth::user() gives the current user's info to the router
    	} else {
    		session()->flash('danger', '邮箱与密码不匹配。');
    		return redirect()->back();
    	}

    	return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }
}
