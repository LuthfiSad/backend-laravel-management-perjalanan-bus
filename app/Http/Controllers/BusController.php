<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    public function indexAll()
    {
        $buses = Bus::all();
        return response()->json($buses);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $buses = DB::table('buses')
            ->where(function ($query) use ($q) {
                $query->where('plat_number', 'like', '%' . $q . '%')
                    ->orWhere('bus_number', 'like', '%' . $q . '%')
                    ->orWhere('distributor', 'like', '%' . $q . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(5);

        return response()->json($buses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plat_number' => 'required',
            'bus_number' => 'required',
            'distributor' => 'required',
            'ukuran' => 'required|int'
        ]);

        $bus = Bus::create([
            'plat_number' => $request->plat_number,
            'bus_number' => $request->bus_number,
            'distributor' => $request->distributor,
            'ukuran' => $request->ukuran
        ]);

        return response()->json($bus);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bus $bus)
    {
        return response()->json($bus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'plat_number' => 'required',
            'bus_number' => 'required',
            'distributor' => 'required',
            'ukuran' => 'required|int'
        ]);

        $bus->update($validated);

        return response()->json($bus);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $bus)
    {
        $bus->delete();
        return response()->json();
    }
}
