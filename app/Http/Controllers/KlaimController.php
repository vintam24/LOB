<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klaim;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KlaimController extends Controller
{
    public function index()
    {
        $groupedKlaim = DB::table('klaim')
            ->select(
                'sub_cob',
                'penyebab_klaim',
                DB::raw('COUNT(*) as jumlah_nasabah'),
                DB::raw('SUM(nilai_beban_klaim) as beban_klaim')
            )
            ->groupBy('sub_cob', 'penyebab_klaim')
            ->get()
            ->groupBy('sub_cob');

        $totals = [
            'jumlah_nasabah' => $groupedKlaim->sum(function($group) {
                return $group->sum('jumlah_nasabah');
            }),
            'beban_klaim' => $groupedKlaim->sum(function($group) {
                return $group->sum('beban_klaim');
            }),
        ];

        return view('klaim.index', compact('groupedKlaim', 'totals'));
    }

    public function backupData()
    {
        $klaimData = DB::connection('mysql')->table('klaim')->get();

        $countBackupData = 0;
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
            $countBackupData++;
        }

        date_default_timezone_set("Asia/Jakarta");
        Log::channel('backup')->info('Data backup performed', [
            'date' => date('Y-m-d h:i:sa'),
            'backup_data_count' => $countBackupData,
        ]);

        return response()->json(['message' => 'Data backup completed successfully!']);
    }

    public function unitTesting()
    {
        $data = Klaim::whereIn('sub_cob', ['KUR', 'PEN'])->get();

        foreach ($data as $item) {
            DB::connection('mysql2')->table('rekap_klaim')->insert([
                'LOB' => $item->sub_cob,
                'penyebab_klaim' => $item->penyebab_klaim,
                'periode' => $item->periode,
                'nilai_beban_klaim' => $item->nilai_beban_klaim,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Data successfully inserted']);
    }

}
