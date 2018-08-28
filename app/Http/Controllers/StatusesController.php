<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function _construct()
    {
    	$this->middleware('auth');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'content' => 'required|max:200'
    	]);

    	Auth::user()->statuses()->create([
    		'content' => $request['content']
    	]);
    	session()->flash('success','您已成功广播！');
    	return redirect()->back();
    }

    public function destroy(Status $status)
    {
    	$this->authorize('destroy', $status);// auth for delete status; otherwise throw 403 exception
    	$status->delete();
    	session()->flash('success', '广播已成功删除');
    	return redirect()->back();
    }
}
