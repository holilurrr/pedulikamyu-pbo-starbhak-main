<?php

namespace App\Http\Controllers\Api;

use App\Models\Pap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PapResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PapController extends Controller
{
    public function index()
    {
        $pap = Pap::with('user')->get();

        //return collection of posts as a resource
        return new PapResource(true, 'List Data Posts', $pap);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name_id'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $datapap = Pap::create([
            'image'     => $image->hashName(),
            'name_id'     => $request->name_id,
        ]);

        //return response
        return new PapResource(true, 'Data Post Berhasil Ditambahkan!', $datapap);
    }

    public function show($datapap)
    {
        $pap = Pap::with('user')->where('id', $datapap)->first();
        return new PapResource(true, 'Data Post Ditemukan!', $pap);
    }

    public function update(Request $request, Pap $pap)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name_id'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$pap->image);

            //update post with new image
            $pap->update([
                'image'     => $image->hashName(),
                'nama_id'     => $request->nama_id,
            ]);

        } else {

            //update post without image
            $pap->update([
                'nama_id'     => $request->nama_id,
            ]);
        }

        //return response
        return new PapResource(true, 'Data Post Berhasil Diubah!', $pap);
    }

    public function destroy(Pap $pap)
    {
        //delete image
        Storage::delete('public/posts/'.$pap->image);

        //delete post
        $pap->delete();

        //return response
        return new PapResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
