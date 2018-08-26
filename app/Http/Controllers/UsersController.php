<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

	public function _construct()
	{
		/* 不允许游客访问个人资料编辑页面  */
		$this->middleware('auth', [
			'except' => ['create', 'show', 'store','index']
		]);

		/* 仅允许游客访问注册页面 */
		$this->middleware('guest', [
			'only', ['create']
		]);
	}

    public function create()
    {
    	return view('users.create');
    }

    public function show(User $user)
    {
    	return view('users.show',compact('user'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);

    	$user = User::create([
    		'name'=> $request->name,
    		'email'=> $request->email,
    		'password'=> bcrypt($request->password)
    	]);

    	Auth::login($user);

    	session()->flash('success','欢迎进驻拉莱耶。请您注意保持清醒。');
    	return redirect()->route('users.show',[$user]); //COC
    }

    public function edit(User $user)
    {
    	$this->authorize('update', $user);
    	return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
    	$this-> validate($request, [
    		'name' => 'required|max:50',
    		'password' => 'nullable|confirmed|min:6'
    	]);

    	$this->authorize('update', $user);

    	$data = [];
    	$data['name'] = $request->name;
    	if ($request->password) {
    		$data['password'] = bcrypt($request->password);
    	}
    	$user->update($data);

    	session()->flash('success','个人资料更新成功');

    	return redirect()->route('users.show', $user->id);

    }

    public function index()
    {
    	$users = User::paginate(10);
    	return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
    	$this->authorize('destroy', $user);
    	$user->delete();
    	session()->flash('success','成功删除该用户！');
    	return back();
    }

}
