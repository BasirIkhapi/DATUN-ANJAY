<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Tahapan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringController extends Controller
{
    public function show($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        return view('admin.perkara.monitoring', compact('perkara'));
    }

    public function storeTahapan(Request $request)
    {
        $request->validate([
            'perkara_id' => 'required|exists:perkaras,id',
            'tanggal_tahapan' => 'required|date',
            'nama_tahapan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Tahapan::create([
            'perkara_id' => $request->perkara_id,
            'tanggal_tahapan' => $request->tanggal_tahapan,
            'nama_tahapan' => strtoupper($request->nama_tahapan),
            'keterangan' => strtoupper($request->keterangan),
        ]);

        return back()->with('success', 'Tahapan sidang berhasil ditambahkan!');
    }

    /**
     * FUNGSI CETAK PDF
     */
    public function cetakPDF($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        
        // Memanggil file monitoring_pdf.blade.php
        $pdf = Pdf::loadView('admin.perkara.monitoring_pdf', compact('perkara'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Monitoring_Perkara_' . $id . '.pdf');
    }
}