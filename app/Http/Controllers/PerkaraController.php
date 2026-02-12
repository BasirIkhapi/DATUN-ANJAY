<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Jaksa;
use App\Models\Tahapan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PerkaraController extends Controller
{
    /**
     * TAMPILAN UTAMA: Pantauan Perkara
     */
    public function index()
    {
        $perkaras = Perkara::with(['jaksa', 'tahapans'])->latest()->get();
        return view('admin.perkara.index', compact('perkaras'));
    }

    /**
     * REGISTRASI PERKARA & UPLOAD SKK: Khusus Admin
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('perkara.index')->with('error', 'Hanya Admin yang dapat meregistrasi.');
        }
        $jaksas = Jaksa::all();
        return view('admin.perkara.create', compact('jaksas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_perkara' => 'required|unique:perkaras,nomor_perkara',
            'jaksa_id'      => 'required|exists:jaksas,id',
            'penggugat'     => 'required|string|max:255',
            'tergugat'      => 'required|string|max:255',
            'jenis_perkara' => 'required|in:Perdata,Tata Usaha Negara',
            'tanggal_masuk' => 'required|date',
            'file_skk'      => 'required|mimes:pdf|max:5120',
        ]);

        // Proses Upload SKK oleh Admin
        $filenameSKK = 'SKK_' . time() . '_' . Str::random(5) . '.pdf';
        $request->file('file_skk')->storeAs('skk', $filenameSKK, 'public');

        $perkara = Perkara::create([
            'nomor_perkara' => $request->nomor_perkara,
            'jaksa_id'      => $request->jaksa_id,
            'penggugat'     => $request->penggugat,
            'tergugat'      => $request->tergugat,
            'jenis_perkara' => $request->jenis_perkara,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_akhir'  => 'Proses',
            'file_skk'      => $filenameSKK,
            'is_verified'   => false,
            'alasan_penolakan' => null
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Admin meregistrasi perkara & upload SKK baru: " . $perkara->nomor_perkara
        ]);

        return redirect()->route('perkara.index')->with('success', 'Perkara & SKK Berhasil Diregistrasi! Menunggu Verifikasi Staff.');
    }

    /**
     * VERIFIKASI & PENOLAKAN: Khusus Staff (Validator)
     */
    public function verifikasi(Request $request, $id)
    {
        if (Auth::user()->role !== 'staff') {
            return redirect()->back()->with('error', 'Otoritas verifikasi hanya untuk Staff.');
        }

        $perkara = Perkara::findOrFail($id);

        if ($request->status === 'setuju') {
            $perkara->update([
                'is_verified' => true,
                'alasan_penolakan' => null
            ]);
            $msg = 'Akurasi Berkas Telah Terverifikasi! Admin kini dapat menginput progres.';
        } else {
            $perkara->update([
                'is_verified' => false,
                'alasan_penolakan' => $request->alasan_penolakan
            ]);
            $msg = 'Berkas Ditolak. Alasan telah dikirim ke Admin untuk revisi.';
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Staff melakukan verifikasi berkas: " . $perkara->nomor_perkara
        ]);

        return redirect()->to(route('perkara.index', ['open_modal' => $perkara->id]) . '#perkara-' . $perkara->id)
            ->with('success', $msg);
    }

    /**
     * UPLOAD/REVISI SKK DI MODAL: Khusus Admin
     */
    public function uploadSKK(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Otoritas unggah hanya untuk Admin.');
        }

        $request->validate(['file_skk' => 'required|mimes:pdf|max:5120']);
        $perkara = Perkara::findOrFail($id);

        if ($request->hasFile('file_skk')) {
            if ($perkara->file_skk) {
                Storage::disk('public')->delete('skk/' . $perkara->file_skk);
            }
            $filename = 'SKK_REV_' . time() . '_' . Str::slug($perkara->nomor_perkara) . '.pdf';
            $request->file('file_skk')->storeAs('skk', $filename, 'public');

            // Reset status agar divalidasi ulang oleh staff
            $perkara->update([
                'file_skk' => $filename,
                'is_verified' => false,
                'alasan_penolakan' => null
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'perkara_id' => $perkara->id,
                'deskripsi' => "Admin merevisi berkas SKK: " . $perkara->nomor_perkara
            ]);
        }

        return redirect()->to(route('perkara.index', ['open_modal' => $perkara->id]) . '#perkara-' . $perkara->id)
            ->with('success', 'Berkas SKK Berhasil Diperbarui! Menunggu Validasi Ulang Staff.');
    }

    /**
     * OPERASIONAL PROGRES SIDANG: Khusus Admin (Setelah SKK Terverifikasi)
     */
    public function storeTahapan(Request $request)
    {
        $perkara = Perkara::findOrFail($request->perkara_id);

        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Gagal! Hanya Admin yang berhak menginput progres sidang.');
        }

        if (!$perkara->is_verified) {
            return redirect()->back()->with('error', 'Gagal! Progres hanya bisa diinput jika berkas SKK sudah disetujui Staff.');
        }

        $request->validate([
            'perkara_id'      => 'required|exists:perkaras,id',
            'nama_tahapan'    => 'required|string|max:255',
            'tanggal_tahapan' => 'required|date',
            'file_tahapan'    => 'nullable|mimes:pdf|max:5120',
        ]);

        $filename = null;
        if ($request->hasFile('file_tahapan')) {
            $filename = 'SIDANG_' . time() . '_' . Str::random(5) . '.pdf';
            $request->file('file_tahapan')->storeAs('dokumen_tahapan', $filename, 'public');
        }

        Tahapan::create([
            'perkara_id'      => $request->perkara_id,
            'nama_tahapan'    => $request->nama_tahapan,
            'tanggal_tahapan' => $request->tanggal_tahapan,
            'keterangan'      => $request->keterangan,
            'file_tahapan'    => $filename,
        ]);

        if ($request->has('set_selesai')) {
            $perkara->update(['status_akhir' => 'Selesai', 'file_putusan' => $filename]);
            $msg = "Perkara Selesai & Berhasil Diarsipkan!";
        } else {
            $msg = "Tahapan Sidang Berhasil Ditambahkan!";
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Admin memperbarui progres sidang: " . $request->nama_tahapan
        ]);

        return redirect()->to(route('perkara.index', ['open_modal' => $perkara->id]) . '#perkara-' . $perkara->id)
            ->with('success', $msg);
    }

    /**
     * FUNGSI CETAK LABEL (MEMPERBAIKI ERROR 500)
     */
    public function cetakLabel($id)
    {
        $perkara = Perkara::with('jaksa')->findOrFail($id);

        $data = [
            'perkara' => $perkara,
            'tanggal_cetak' => now()->translatedFormat('d F Y'),
        ];

        return Pdf::loadView('admin.perkara.pdf_label', $data)
            ->setPaper([0, 0, 600, 400], 'portrait')
            ->stream('Label_Map_' . Str::slug($perkara->nomor_perkara) . '.pdf');
    }

    /**
     * EDIT & DELETE (ADMIN ONLY)
     */
    public function edit($id)
    {
        $perkara = Perkara::findOrFail($id);
        $jaksas = Jaksa::all();
        return view('admin.perkara.edit', compact('perkara', 'jaksas'));
    }

    public function update(Request $request, $id)
    {
        $perkara = Perkara::findOrFail($id);
        $request->validate([
            'nomor_perkara' => 'required|unique:perkaras,nomor_perkara,' . $id,
            'jaksa_id'      => 'required|exists:jaksas,id',
        ]);

        $perkara->update($request->all());
        return redirect()->route('perkara.index')->with('success', 'Data Master Perkara Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') return redirect()->back();
        $perkara = Perkara::findOrFail($id);
        if ($perkara->file_skk) Storage::disk('public')->delete('skk/' . $perkara->file_skk);
        $perkara->delete();
        ActivityLog::create(['user_id' => Auth::id(), 'deskripsi' => "Admin menghapus data master perkara"]);
        return redirect()->route('perkara.index')->with('success', 'Data Master Berhasil Dihapus.');
    }

    /**
     * LAPORAN & ARSIP
     */
    public function pusatArsip(Request $request)
    {
        $query = Perkara::with(['jaksa', 'tahapans'])->where('status_akhir', 'Selesai');
        if ($request->filled('bulan')) $query->whereMonth('tanggal_masuk', $request->bulan);
        if ($request->filled('tahun')) $query->whereYear('tanggal_masuk', $request->tahun);
        $perkaras = $query->latest()->get();
        return view('admin.arsip.index', compact('perkaras'));
    }

    public function cetakStagnansi()
    {
        $perkaras = Perkara::with(['jaksa', 'tahapans'])->where('status_akhir', 'Proses')->get()
            ->filter(fn($p) => Carbon::parse($p->tahapans->max('tanggal_tahapan') ?? $p->tanggal_masuk)->diffInDays(now()) > 14);
        return Pdf::loadView('admin.arsip.pdf_stagnansi', compact('perkaras'))->setPaper('a4', 'landscape')->stream('Laporan_Stagnansi.pdf');
    }

    public function cetakStatistik()
    {
        $daftar_perkara = Perkara::with('jaksa')->latest()->get();
        $data = [
            'daftar_perkara' => $daftar_perkara,
            'total' => $daftar_perkara->count(),
            'perdata' => $daftar_perkara->where('jenis_perkara', 'Perdata')->count(),
            'tun' => $daftar_perkara->where('jenis_perkara', 'Tata Usaha Negara')->count(),
            'selesai' => $daftar_perkara->where('status_akhir', 'Selesai')->count(),
            'proses' => $daftar_perkara->where('status_akhir', 'Proses')->count(),
        ];
        return Pdf::loadView('admin.arsip.statistik_pdf', $data)->setPaper('a4', 'portrait')->stream('Statistik_Perkara.pdf');
    }

    public function cetakDetail($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        $judulLaporan = "LAPORAN DETAIL MONITORING PERKARA DATUN";
        return Pdf::loadView('admin.perkara.pdf_detail', compact('perkara', 'judulLaporan'))->setPaper('a4', 'portrait')->stream('Detail_Perkara.pdf');
    }

    public function cetakKinerja()
    {
        $jaksas = Jaksa::withCount('perkaras')->get();
        return Pdf::loadView('admin.arsip.pdf_kinerja', compact('jaksas'))->setPaper('a4', 'portrait')->stream('Kinerja_JPN.pdf');
    }

    public function cetakArsip()
    {
        $perkara_selesai = Perkara::with('jaksa')->where('status_akhir', 'Selesai')->latest()->get();
        return Pdf::loadView('admin.arsip.arsip_pdf', compact('perkara_selesai'))->setPaper('a4', 'landscape')->stream('Rekapitulasi_Arsip.pdf');
    }
}
