<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //中间件 过滤机制 未登录用户访问的动作
    public function __construct()
    {
        $this->middleware('auth',[
           'except' => ['show','create','store']
        ]);

        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
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
    public function store(Request $request,User $user)
    {
        $this->validate($request,[
           'name' => 'required|unique:users|max:50',
           'email' => 'required|email|unique:users|max:255',
           'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
    }

    //编辑用户个人信息页面
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    //编辑资料提交验证
    public function update(User $user, Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data= [];
        $data['name'] = $request->name;
        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success','个人资料更新完成');
        return redirect()->route('users.show',$user);
    }
}
