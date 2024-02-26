<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Http\Requests\StoreReservasiRequest;
use App\Http\Requests\UpdateReservasiRequest;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => ['required'],
        'email' => ['required'],
        'no_meja' => ['required'],
        'phone' => ['required'],
        'date' => ['required'],
        'orang' => ['required'],
        'message' => ['required'],
    ]);

    Reservasi::create($validatedData);

    return redirect()->route('show')->with('success', 'Selamat anda berhasil reservasi');
}


    /**
     * Display the specified resource.
     */
    public function show(Reservasi $reservasi)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservasi $reservasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservasiRequest $request, Reservasi $reservasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Reservasi::where('id',$id)->delete();
        return redirect()->route('dashboard')->with('success','Data Berhasil Dihapus');
    }
}
