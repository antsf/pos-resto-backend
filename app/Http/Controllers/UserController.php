<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index
    public function index(Request $request) 
    {
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'DESC')->paginate(10);
        // $users = DB::table('users')
        // ->when($request->input('name'). function ($query, $name, $email) {
        //     $query->where('name'.'like', '%'.$name.'%')
        //     ->  orWhere('email'.'like', '%'.$email.'%');
        // })
        // ->paginate(10);
        return view('pages.users.index', ['type_menu' => 'users'], compact('users'));
    }

    // create
    public function create() 
    {
        return view('pages.users.create', ['type_menu' => 'users']);
    }

    // store
    public function store(Request $request) 
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,staff,user',
        ]);

        // store the request
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'User create successfully');
    }

    // show
    public function show($id) 
    {
        return view('pages.users.show', ['type_menu' => 'users']);
    }

    // edit
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('pages.users.edit', ['type_menu' => 'users'], compact('user'));
    }

    // update
    public function update(Request $request, $id) 
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email|unique:users' .$id,
            'email' => 'required',
            'role' => 'required|in:admin,staff,user',
        ]);

        // update the request
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        $password = $request->password;
        // if password not empty
        if ($password) {
            $user->password = Hash::make($password);
            $user->save();
        }
        
        return redirect()->route('users.index')->with('success', 'User update successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the request
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User delete successfully');
    }
}
