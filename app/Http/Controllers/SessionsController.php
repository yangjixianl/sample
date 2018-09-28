<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    //创建登录界面
    public function create()
    {
    	return view('sessions.create');
    }

    //验证保存用户信息
    public function store(Request $request)
    {
    	$credentials = $this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    	]);
    	//dump($credentials);die;
    	if(Auth::attempt($credentials, $request->has('remember'))){
    		//登录成功
    		session()->flash('success', '欢迎回来');
    		return redirect() -> route('users.show', [Auth::user()]);
    	} else {
    		//登录失败
    		session()->flash('danger', '很抱歉，你的邮箱和密码不匹配');
    		return redirect()->back();
    	}
    }

    //退出
    public function destroy()
    {
    	Auth::logout();
    	session() -> flash('success', '你已成功退出');
    	return redirect('login');
    }
}
