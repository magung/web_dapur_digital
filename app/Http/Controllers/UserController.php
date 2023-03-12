<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->leftJoin('stores', 'stores.id', '=', 'users.store_id')
                ->select('users.*', 'roles.role_name', 'stores.branch_name')
                ->get();
        return view('user.index', compact('users'));
    }
    public function create()
    {
        $roles =  Role::latest()->get();
        $stores = Store::latest()->get();
        return view('user.create', compact('roles', 'stores'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|unique:users,email',
            'password'      => 'required',
            'role_id'       => 'required',
            'phone_number'  => 'required',
            'gender'        => 'required',
            // 'birthday'   => 'required',
            'address'       => 'required',
            'status'       => 'required',
            'photo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $photo = 'PHOTO-PROFILE-'.time().'.'.$request->photo->extension();

        $request->photo->move(public_path('uploads'), $photo);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role_id'       => $request->role_id,
            'phone_number'  => $request->phone_number,
            'gender'        => $request->gender,
            'birthday'      => $request->birthday,
            'address'       => $request->address,
            'status'       => $request->status,
            'store_id'      => $request->store_id,
            'photo'         => $photo,
        ]);

        if ($user) {
            return redirect()
                ->route('user.index')
                ->with([
                    'success' => 'New user has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles =  Role::latest()->get();
        $stores = Store::latest()->get();
        return view('user.edit', compact('user', 'roles', 'stores'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required',
            'role_id'       => 'required',
            'phone_number'  => 'required',
            'gender'        => 'required',
            'address'       => 'required',
            'status'       => 'required'
        ]);

        $datasend = [
            'name'          => $request->name,
            'email'         => $request->email,
            'role_id'       => $request->role_id,
            'phone_number'  => $request->phone_number,
            'gender'        => $request->gender,
            'birthday'      => $request->birthday,
            'address'       => $request->address,
            'store_id'      => $request->store_id,
            'status'       => $request->status,
        ];
        $user = User::findOrFail($id);
        
        if(isset($request->photo)) {
            $photo = 'PHOTO-PROFILE-'.time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads'), $photo);
            $datasend['photo'] = $photo;
            if (file_exists(public_path('uploads').'/'.$user->photo)) {
                unlink(public_path('uploads').'/'.$user->photo);
            } 
        }
        
        
        if(isset($request->pasword)) {
            $datasend['password'] = Hash::make($request->password);
        }
        
        $user->update($datasend);

        if ($user) {
            return redirect()
                ->route('user.index')
                ->with([
                    'success' => 'user has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (file_exists(public_path('uploads').'/'.$user->photo)) {
            unlink(public_path('uploads').'/'.$user->photo);
        } 
        $user->delete();
        
        if ($user) {
            return redirect()
                ->route('user.index')
                ->with([
                    'success' => 'user has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('user.index')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
