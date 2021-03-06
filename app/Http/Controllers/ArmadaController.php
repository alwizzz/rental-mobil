<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArmadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        Armada::synchronizeTersedia();
        $armadas = Armada::with('merk')->get();
        return view('dashboard.armada.index', compact('armadas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merks = Merk::all();
        return view('dashboard.armada.create', compact('merks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'merk_id' => 'required',
            'jenis' => 'required',
            'plat_nomor' => 'required|unique:armadas',    
            'transmisi' => "required",
            'tgl_pajak' => 'required|date|date_format:Y-m-d',
            'thn_beli' => 'required|integer',
            'harga_tiga_jam' => 'required|integer',
            'bahan_bakar' => 'required'   
        ];

        $validatedRequest = $request->validate($rules);
        $validatedRequest['tersedia'] = true;
        $validatedRequest['created_by'] = Auth::user()->email;
        $armada = Armada::create($validatedRequest);

        return redirect(route('armada.index'))->with('success_create', 'Data has been added succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Armada  $armada
     * @return \Illuminate\Http\Response
     */
    public function show(Armada $armada)
    {
        $armadas = Armada::with('merk')->get();
        return view('dashboard.armada.detail', compact('armada'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Armada  $armada
     * @return \Illuminate\Http\Response
     */
    public function edit(Armada $armada)
    {
        $merks = Merk::all();
        $this->authorize('superadmin');
        return view('dashboard.armada.edit', compact(['armada', 'merks']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Armada  $armada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Armada $armada)
    {
        $rules = [
            'jenis' => 'required',
            'plat_nomor' => 'required',
            'transmisi' => 'required',
            'tgl_pajak' => 'required',
            'thn_beli' => 'required|integer',
            'harga_tiga_jam' => 'required|integer',
            'bahan_bakar' => 'required'
        ];

        // cek kalo value plat_nomor diedit dengan cara bandingin value plat_nomor
        // versi form sama versi data aslinya. Kalo beda berarti diedit
        if($request->plat_nomor != $armada->plat_nomor){
            $rules['plat_nomor'] = $rules['plat_nomor'] . '|unique:armadas'; // tambahin rule biar value harus unique berdasarkan tabel armadas
        }

        $validatedRequest = $request->validate($rules);

        Armada::where('id', $armada->id)->update($validatedRequest);
        return redirect (route ('armada.index'))->with('success_edit', 'Data has been edited succesfully!');

        // $armada->update([
        //     'merk_id' => $request->get('merk_id'),
        //     'jenis' => $request->get('jenis'),
        //     'plat_nomor' => $request->get('plat_nomor'),
        //     'transmisi' => $request->get('transmisi'),
        //     'tgl_pajak' => $request->get('tgl_pajak'),
        //     'thn_beli' => $request->get('thn_beli'),
        //     'harga_tiga_jam' => $request->get('harga_tiga_jam'),
        //     'tersedia' => $request->get('tersedia'),
        //     'bahan_bakar' => $request->get('bahan_bakar')
        // ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Armada  $armada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Armada $armada)

    { 
      
        $this->authorize('superadmin');
        //delete can only be done if there are no BookingArmada related to this Armada
        if($armada->booking_armadas->isEmpty()){
            $armada->delete();
            return redirect (route('armada.index'))->with('success_remove', 'Data has been removed succesfully!');
        } else {
            return redirect (route('armada.index'))->with('fail_remove', "Failed to delete: delete can only be performed only if there are no BookingArmada related to this Data!");
        }

        // $armada->delete();
        // return redirect (route('armada.index'))->with('success_remove', 'Data has been removed succesfully!');

    }
}
