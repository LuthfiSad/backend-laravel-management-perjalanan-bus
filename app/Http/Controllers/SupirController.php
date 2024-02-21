<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupirController extends Controller
{
    public function indexAll()
    {
        $supirs = Supir::all();
        return response()->json($supirs);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $supirs = DB::table('supirs')
            ->where(function($query) use($q) {
                $query->where('no_reg', 'like', '%'.$q.'%')
                    ->orWhere('nama_lengkap', 'like', '%'.$q.'%');
            })
            ->orderByDesc('created_at')
            ->paginate(5);
        return response()->json($supirs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_reg' => 'required',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'jk' => 'required|in:P,L'
        ]);

        $supir = Supir::create($request->all());
        return response()->json($supir);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supir $supir)
    {
        return response()->json($supir);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supir $supir)
    {
        $validated = $request->validate([
            'no_reg' => 'required',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'jk' => 'required|in:L,P'
        ]);

        $supir->update($validated);

        return response()->json($supir);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supir $supir)
    {
        $supir->delete();
        return response()->json(['message' => 'supir berhasil dihapus']);
    }
}
