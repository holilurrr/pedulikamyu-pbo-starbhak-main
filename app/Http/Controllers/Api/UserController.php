<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $user = User::latest()->paginate(5);
        return new UserResource(true, 'List Data Posts', $user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'   => 'required',
            'role'   => 'required',
            'telp'   => 'required',
            'alamat'   => 'required',
            'nik'   => 'required',
            'password'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $datauser = User::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'role'   => $request->role,
            'telp'   => $request->telp,
            'alamat'   => $request->alamat,
            'nik'   => $request->nik,
            'password'   => $request->password,
        ]);

        //return response
        return new UserResource(true, 'Data Post Berhasil Ditambahkan!', $datauser);
    }

    public function show(User $user)
    {
        return new UserResource(true, 'Data Post Ditemukan!', $user);
    }

    public function update(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'   => 'required',
            'role'   => 'required',
            'telp'   => 'required',
            'alamat'   => 'required',
            'nik'   => 'required',
            'password'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'name'     => $request->name,
            'email'   => $request->email,
            'role'   => $request->role,
            'telp'   => $request->telp,
            'alamat'   => $request->alamat,
            'nik'   => $request->nik,
            'password'   => $request->password,
        ]);

        //return response
        return new UserResource(true, 'Data Post Berhasil Diubah!', $user);
    }
    
    public function destroy(User $user)
    {
        //delete post
        $user->delete();

        //return response
        return new UserResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
