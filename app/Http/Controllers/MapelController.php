<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class MapelController extends Controller
{
   // Halaman Data Mapel
    public function dataMapel()
    {
        $mapel = MataPelajaran::orderBy('nama_mapel', 'asc')->get();
        return view('dashboard.data_mapel', compact('mapel'));
    }

    // 🔹 Simpan mapel baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'nama_singkat' => 'required|string|max:20',
        ]);

        MataPelajaran::create([
            'nama_mapel' => $request->nama_mapel,
            'nama_singkat' => $request->nama_singkat,
        ]);

        return redirect()->route('dashboard.data_mapel')->with('success', 'Data mapel berhasil ditambahkan.');
    }

    // 🔹 Update mapel
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'nama_singkat' => 'required|string|max:20',
        ]);

        $mapel = MataPelajaran::findOrFail($id);
        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
            'nama_singkat' => $request->nama_singkat,
        ]);

        return redirect()->route('dashboard.data_mapel')->with('success', 'Data mapel berhasil diperbarui.');
    }

    // 🔹 Hapus mapel
    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();

        return redirect()->route('dashboard.data_mapel')->with('success', 'Data mapel berhasil dihapus.');
    }

    public function exportPdf()
{
    $mapel = \App\Models\MataPelajaran::with('guru')->orderBy('nama_mapel', 'asc')->get();

    $pdf = Pdf::loadView('exports.data_mapel_pdf', compact('mapel'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('data_mapel.pdf');
}

    public function exportCsv()
{
    $mapel = \App\Models\MataPelajaran::with('guru')->orderBy('nama_mapel', 'asc')->get();

    $filename = 'data_mapel.csv';
    $handle = fopen($filename, 'w+');

    // Header kolom
    fputcsv($handle, ['No', 'Nama Mapel', 'Nama Singkat', 'Guru Pengampu']);

    foreach ($mapel as $i => $m) {
        fputcsv($handle, [
            $i + 1,
            $m->nama_mapel,
            $m->nama_singkat,
            $m->guru->nama_guru ?? '-',
        ]);
    }

    fclose($handle);

    return Response::download($filename)->deleteFileAfterSend(true);
    
}
}