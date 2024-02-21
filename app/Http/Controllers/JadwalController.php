<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Rute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $jadwal = DB::table('jadwals as t_0')
            ->join('buses as t_1', 't_0.bus_id', 't_1.id')
            ->join('supirs as t_2', 't_0.supir_id', 't_2.id')
            ->join('rutes as t_3', 't_0.rute_id', 't_3.id')
            ->select([
                't_0.*',
                't_1.bus_number',
                't_2.no_reg as supir_no_reg',
                't_2.nama_lengkap as supir_nama_lengkap',
                't_3.kode as rute_kode',
                't_3.waktu_tempuh as rute_waktu_tempuh'
            ]);
        if($q == "") {
            $jadwal = $jadwal->whereDate('berangkat', now()->format('Y-m-d'));
        } else {
            $jadwal = $jadwal->whereDate('berangkat', $q);
        }
        $jadwal = $jadwal->paginate(15);
        return response()->json($jadwal);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'supir_id' => 'required|exists:supirs,id',
            'rute_id' => 'required|exists:rutes,id',
            'berangkat' => 'required'
        ]);

        $rute = Rute::find($request->rute_id);
        $berangkat = (new Carbon($request->berangkat))->toImmutable()->setTimezone('Asia/Jakarta');
        $tiba = $berangkat->addMinutes($rute->waktu_tempuh);

        $jadwal = Jadwal::create([
            'bus_id' => $request->bus_id,
            'supir_id' => $request->supir_id,
            'rute_id' => $request->rute_id,
            'berangkat' => $berangkat,
            'tiba' => $tiba,
            'status' => Jadwal::NGY
        ]);

        return response()->json(['data' => $jadwal]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        return response()->json(['data' => $jadwal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'supir_id' => 'required|exists:supirs,id',
            'rute_id' => 'required|exists:rutes,id',
            'berangkat' => 'required',
            'status' => 'required'
        ]);

        $rute = Rute::find($request->rute_id);
        $validated['berangkat'] = (new Carbon($request->berangkat))->toImmutable()->setTimezone('Asia/Jakarta');
        $validated['tiba'] = $validated['berangkat']->addMinutes($rute->waktu_tempuh);
        $jadwal->update($validated);

        return response()->json($jadwal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return response()->json(['message' => 'jadwal deleted']);
    }
}
