<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerminalController extends Controller
{
    public function indexAll()
    {
        $terminals = Terminal::all();
        return response()->json($terminals);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $terminals = DB::table('terminals')
            ->where(function($query) use ($q) {
                $query->where('kode', 'like', '%'.$q.'%')
                    ->orWhere('nama', 'like', '%'.$q.'%')
                    ->orWhere('tipe', 'like', '%'.$q.'%');
            })
            ->orderByDesc('created_at')
            ->paginate();

        return response()->json($terminals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'tipe' => 'required|in:'.Terminal::TIPE_CHECKPOINT.','.Terminal::TIPE_TERMINAL.','.Terminal::TIPE_PUL
        ]);

        $terminal = Terminal::create($request->all());
        return response()->json($terminal);
    }

    /**
     * Display the specified resource.
     */
    public function show(Terminal $terminal)
    {
        return response()->json($terminal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terminal $terminal)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'tipe' => 'required|in:'.Terminal::TIPE_CHECKPOINT.','.Terminal::TIPE_TERMINAL.','.Terminal::TIPE_PUL
        ]);

        $terminal->update($validated);

        return response()->json($terminal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Terminal $terminal)
    {
        $terminal->delete();
        return response()->json(['message' => 'terminal berhasil dihapus']);
    }
}
