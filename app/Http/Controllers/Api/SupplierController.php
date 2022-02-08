<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use DB;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required',
            'phone' => 'required|unique:suppliers',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().".".$ext;
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/imagenes/supplier/';
            $image_url = $upload_path.$name;
            $img->save($image_url);

            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->shopname = $request->shopname;
            $supplier->address = $request->address;
            $supplier->photo = $image_url;

            $supplier->save();
        }else{
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->shopname = $request->shopname;
            $supplier->address = $request->address;

            // Para que tenga una foto que diga NO-IMAGEN
            $name = "no-image.png";
            $upload_path = 'backend/img/';
            $image_url = $upload_path.$name;
            $supplier->photo = $image_url;

            $supplier->save();
        }

    }

    public function show($id)
    {
        $supplier = DB::table('suppliers')->where('id',$id)->first();
        return response()->json($supplier);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['shopname'] = $request->shopname;
        $data['address'] = $request->address;
        $image = $request->newphoto;

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/imagenes/supplier/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);
            
            if ($success) {
                $data['photo'] = $image_url;
                $img = DB::table('suppliers')->where('id',$id)->first();
                $image_path = $img->photo;
                 // Para que No borre NO-IMAGEN del disco
                 if ($image_path != 'backend/img/no-image.png') {
                    $done = unlink($image_path);
                }
                $user = DB::table('suppliers')->where('id',$id)->update($data);
            }
        }else{
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('suppliers')->where('id',$id)->update($data);
        }
    }

    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        $photo = $supplier->photo;
        if ($photo) {
            unlink($photo);
            DB::table('suppliers')->where('id', $id)->delete();
        }else{
            DB::table('suppliers')->where('id', $id)->delete();
        }
    }

}
