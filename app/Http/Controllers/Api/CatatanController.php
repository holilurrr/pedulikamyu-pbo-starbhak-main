<?php

namespace App\Http\Controllers\Api;

use App\Models\Catatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CatatanResource;
use Illuminate\Support\Facades\Validator;

class CatatanController extends Controller
{
    public function index()
    {
        $catatan = Catatan::with('user', 'pap')->get();

        return new CatatanResource(true, 'List Data Posts', $catatan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'suhu_tubuh'     => 'required',
            'name_id'     => 'required',
            'image_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $datacatatan = Catatan::create([
            'suhu_tubuh'     => $request->suhu_tubuh,
            'name_id'     => $request->name_id,
            'image_id'     => $request->name_id,
        ]);

        //return response
        return new CatatanResource(true, 'Data Post Berhasil Ditambahkan!', $datacatatan);
    }

    public function show($datacatatan)
    {
        $catatan = Catatan::with('user', 'pap')->where('id', $datacatatan)->first();
        return new CatatanResource(true, 'Data Post Ditemukan!', $catatan);
    }

    public function update(Request $request, Catatan $catatan)
    {
        $validator = Validator::make($request->all(), [
            'suhu_tubuh'     => 'required',
            'name_id'   => 'required',
            'image_id'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $catatan->update([
            'suhu_tubuh'     => $request->suhu_tubuh,
            'name_id'   => $request->name_id,
            'image_id'   => $request->image_id,
        ]);

        return new CatatanResource(true, 'Data Post Berhasil Diubah!', $catatan);
    }

    public function destroy(Catatan $catatan)
    {
        //delete post
        $catatan->delete();

        //return response
        return new CatatanResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
