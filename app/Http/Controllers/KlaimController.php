<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klaim;
use Illuminate\Support\Facades\DB;

class KlaimController extends Controller
{
    public function index()
    {
        $klaim = Klaim::all();
        return view('klaim.index', compact('klaim'));
    }

    public function backupData()
    {
        $klaimData = DB::connection('mysql')->table('klaim')->get();

        foreach ($klaimData as $item) {
            DB::connection('mysql2')->table('rekap_klaim')->updateOrInsert(
                ['id' => $item->id],
                [
                    'LOB' => $item->sub_cob,
                    'penyebab_klaim' => $item->penyebab_klaim,
                    'periode' => $item->periode,
                    'nilai_beban_klaim' => $item->nilai_beban_klaim,
                    'created_at'=> date('Y-m-d'),
                ]
            );
        }

        return redirect()->route('klaim.index')->with('status', 'Data backup completed successfully!');
    }

    public function sendClaim()
    {
        $data = Klaim::whereIn('LOB', ['KUR', 'PEN'])->get();

        foreach ($data as $item) {
            DB::connection('mysql2')->table('rekap_klaim')->insert([
                'LOB' => $item->LOB,
                'penyebab_klaim' => $item->penyebab_klaim,
                'periode' => $item->periode,
                'nilai_beban_klaim' => $item->nilai_beban_klaim,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    // Log proses pengiriman
    DB::table('logs')->insert([
        'tanggal_proses' => now(),
        'jumlah_data_dikirim' => $data->count(),
        'status_pengiriman' => 'sukses',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'Data berhasil dikirim']);
}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'LOB' => 'required|string|max:255',
            'penyebab_klaim' => 'required|string|max:255',
            'periode' => 'required|date',
            'nilai_beban_klaim' => 'required|numeric',
        ]);

        $klaim = Klaim::create($validatedData);

        return response()->json($klaim, 201);
    }

    public function show($id)
    {
        return Klaim::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'LOB' => 'required|string|max:255',
            'penyebab_klaim' => 'required|string|max:255',
            'periode' => 'required|date',
            'nilai_beban_klaim' => 'required|numeric',
        ]);

        $klaim = Klaim::findOrFail($id);
        $klaim->update($validatedData);

        return response()->json($klaim, 200);
    }

    public function destroy($id)
    {
        Klaim::destroy($id);

        return response()->json(null, 204);
    }
}
