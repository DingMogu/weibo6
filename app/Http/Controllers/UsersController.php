<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    //显示个人页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    //用户注册验证
    public function store(Request $request)
    {
        $this->validate($request,[
           'name' => 'required|unique:users|max:50',
           'email' => 'required|email|unique:users|max:255',
           'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
