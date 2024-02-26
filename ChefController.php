<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Http\Requests\StoreChefRequest;
use App\Http\Requests\UpdateChefRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ChefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request ->katakunci;
        $jumlahbaris=4;
        if(strlen($katakunci)){
            $chef=Chef::where('id','like',"%$katakunci%")
            ->orWhere('name','like',"%$katakunci%")
            ->orWhere('posisi','like',"%$katakunci%")
            ->orWhere('instagram','like',"%$katakunci%")
            ->paginate($jumlahbaris);
        }else{
            $chef = Chef::orderBy('id','desc')->paginate($jumlahbaris);
        }
        return view('admin.pages.chef.index')->with('chef',$chef);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.chef.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'posisi' => 'required',
        'instagram' => 'required',
        'img' => 'required|image',
    ], [
        'name.required' => 'Name harus diisi',
        'posisi.required' => 'Posisi harus diisi',
        'instagram.required' => 'Instagram harus diisi',
        'img.required' => 'Img harus diisi',
        'img.image' => 'File harus berupa gambar (jpeg, png, bmp, gif, atau svg)',
    ]);

    $imageName = $request->file('img')->hashName();

    $request->file('img')->move(public_path('/chef-images'), $imageName);

    // Simpan hanya nama file dalam sesi
    session()->flash('name', $request->name);
    session()->flash('posisi', $request->posisi);
    session()->flash('instagram', $request->instagram);
    session()->flash('img', $imageName);

    Chef::create([
        'name' => $request->name,
        'posisi' => $request->posisi,
        'instagram' => $request->instagram,
        'img' => $imageName,
    ]);

    return redirect()->to('chef')->with('success', 'Data Berhasil Disimpan');
}


    /**
     * Display the specified resource.
     */
    public function show(Chef $chef)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $chef=Chef::where('id',$id)->first();
        return view('admin.pages.chef.edit')->with('data',$chef);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'=>['sometimes'],
            'posisi'=>['sometimes'],
            'instagram'=>['sometimes'],
            'img'=>['sometimes'],
        ],[
            'name.required'=>'Name harus diisi',
            'posisi.required'=>'Posisi harus diisi',
            'instagram.required'=>'Instagram harus diisi',
            'img.required'=>'Img harus diisi',
        ]);
        $chef = Chef::find($id);
    
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            File::delete(public_path() . "/chef-images/$chef->img");
    
            $imageName = $request->file('img')->hashName();
            $validatedData['img'] = $imageName;
            $chefDirectory = public_path() . '/chef-images';
            $request->file('img')->move($chefDirectory, $imageName);
        }
    
        $chef->update($validatedData);
    
        return redirect()->to('chef')->with('success', 'Data Berhasil Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        Chef::where('id',$id)->delete();
        return redirect()->to('chef')->with('success','Data Berhasil Dihapus');
    }
}