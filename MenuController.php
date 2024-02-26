<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Session;



class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci =$request ->katakunci;
        $jumlahbaris=4;
        if(strlen($katakunci)){
            $menu=Menu::where('id','like',"%$katakunci%")
            ->orWhere('name','like',"%$katakunci%")
            ->orWhere('deskripsi','like',"%$katakunci%")
            ->orWhere('jenis','like',"%$katakunci%")
            ->orWhere('harga','like',"%$katakunci%")
            ->paginate($jumlahbaris);
        }else{
            $menu = Menu::orderBy('id','desc')->paginate($jumlahbaris);
        }
        return view('admin.pages.menu.index')->with('menu',$menu);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    Session()->flash('name', $request->name);
    Session()->flash('deskripsi', $request->deskripsi);
    Session()->flash('harga', $request->harga);
    Session()->flash('jenis', $request->jenis);
    session()->flash('img', $request->file('img')->hashName());

    $validatedData = $request->validate([
        'name' => ['required'],
        'deskripsi' => ['required'],
        'jenis' => ['required'],
        'harga' => ['required'],
        'img' => ['required', 'image'],
    ], [
        'name.required' => 'Name harus diisi',
        'deskripsi.required' => 'Deskripsi harus diisi',
        'jenis.required' => 'Jenis harus diisi',
        'harga.required' => 'Harga harus diisi',
        'img.required' => 'img harus diisi',
        'img.image' => 'File harus berupa gambar (jpeg, png, bmp, gif, atau svg)',
    ]);

    $imageName = $request->file('img')->hashName();

    $validatedData['img'] = $imageName;

    $menuDirectory = public_path() . '/menu-images';
    $request->file('img')->move($menuDirectory, $imageName);

    Menu::create($validatedData);

    return redirect()->to('menu')->with('success', 'Data Berhasil Disimpan');
}


    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu=Menu::find($id);

        return view('admin.pages.menu.edit', compact('menu'))->with('menu',$menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => ['sometimes'],
            'deskripsi' => ['sometimes'],
            'jenis' => ['sometimes'],
            'harga' => ['sometimes'],
            'img' => ['sometimes', 'image'],
        ], [
            'name.sometimes' => 'Name harus diisi',
            'deskripsi.sometimes' => 'Deskripsi harus diisi',
            'jenis.sometimes' => 'Jenis harus diisi',
            'harga.sometimes' => 'Harga harus diisi',
            'img.sometimes' => 'img harus diisi',
            'img.image' => 'File harus berupa gambar (jpeg, png, bmp, gif, atau svg)',
        ]);
    
    
        $menu = Menu::find($id);
    
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            File::delete(public_path() . "/menu-images/$menu->img");
    
            $imageName = $request->file('img')->hashName();
            $validatedData['img'] = $imageName;
            $menuDirectory = public_path() . '/menu-images';
            $request->file('img')->move($menuDirectory, $imageName);
        }
    
        $menu->update($validatedData);
    
        return redirect()->to('menu')->with('success', 'Data Berhasil Diperbaharui');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $menu = Menu::find($id);

        File::delete(public_path() . "/menu-images/$menu->image");

        $menu->delete();
        return redirect()->to('menu')->with('success','Data Berhasil Dihapus');
    }
}


