<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelajaran;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Guru;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class PembelajaranController extends Controller
{
    // 🟩 Halaman utama
    public function dataPembelajaran()
    {
        $pembelajaran = Pembelajaran::with(['mapel', 'kelas', 'guru'])
            ->orderBy('id_pembelajaran', 'desc')
            ->get();

        // Ambil data untuk dropdown
        $mapel = MataPelajaran::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $guru  = Guru::orderBy('nama_guru')->get();

        return view('dashboard.data_pembelajaran', compact('pembelajaran', 'mapel', 'kelas', 'guru'));
    }

    // 🟦 Simpan data pembelajaran
    public function store(Request $request)
    {
        $request->validate([
            'id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_guru'  => 'required|exists:guru,id_guru',
        ]);

        Pembelajaran::create([
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'id_guru'  => $request->id_guru,
        ]);

        return redirect()->route('dashboard.data_pembelajaran')
            ->with('success', 'Data pembelajaran berhasil ditambahkan.');
    }

    // 🟨 Update data pembelajaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_guru'  => 'required|exists:guru,id_guru',
        ]);

        $pembelajaran = Pembelajaran::findOrFail($id);
        $pembelajaran->update([
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas,
            'id_guru'  => $request->id_guru,
        ]);

        return redirect()->route('dashboard.data_pembelajaran')
            ->with('success', 'Data pembelajaran berhasil diperbarui.');
    }

    // 🟥 Hapus data pembelajaran
    public function destroy($id)
    {
        $pembelajaran = Pembelajaran::findOrFail($id);
        $pembelajaran->delete();

        return redirect()->route('dashboard.data_pembelajaran')
            ->with('success', 'Data pembelajaran berhasil dihapus.');
    }

    public function exportPdf()
{
    $pembelajaran = Pembelajaran::with(['mapel', 'kelas', 'guru'])
        ->orderBy('id', 'asc')
        ->get();

    $pdf = Pdf::loadView('exports.data_pembelajaran_pdf', compact('pembelajaran'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('data_pembelajaran.pdf');
}


public function exportCsv()
{
    $pembelajaran = Pembelajaran::with(['mapel', 'kelas', 'guru'])
        ->orderBy('id', 'asc')
        ->get();

    $filename = 'data_pembelajaran.csv';
    $handle = fopen($filename, 'w+');

    // Header kolom
    fputcsv($handle, ['No', 'Mata Pelajaran', 'Tingkat', 'Kelas', 'Jurusan', 'Guru Mapel']);

    foreach ($pembelajaran as $i => $p) {
        fputcsv($handle, [
            $i + 1,
            $p->mapel->nama_mapel ?? '-',
            $p->kelas->tingkat ?? '-',
            $p->kelas->nama_kelas ?? '-',
            $p->kelas->jurusan ?? '-',
            $p->guru->nama_guru ?? '-',
        ]);
    }

    fclose($handle);

    return Response::download($filename)->deleteFileAfterSend(true);
    }

}
