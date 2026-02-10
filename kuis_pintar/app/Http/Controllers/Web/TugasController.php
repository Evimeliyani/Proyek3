<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // === BUAT TUGAS (list) ===
    public function indexBuat(Request $request)
    {
        $q = Tugas::query()->where('guru_id', auth()->id());

        if ($request->filled('kategori')) $q->where('kategori', $request->kategori);
        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function($qq) use ($s){
                $qq->where('judul','like',"%$s%")
                   ->orWhere('soal','like',"%$s%")
                   ->orWhere('kunci_jawaban','like',"%$s%");
            });
        }

        $tugas = $q->latest()->paginate(10)->withQueryString();

        return view('web.tugas.buat', compact('tugas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|string|max:100',
            'judul' => 'required|string|max:120',
            'soal' => 'required|string|max:200',
            'kunci_jawaban' => 'required|string|max:120',
        ]);

        $data['guru_id'] = auth()->id();

        Tugas::create($data);

        return back()->with('ok', 'Tugas berhasil dibuat.');
    }

    public function update(Request $request, Tugas $tugas)
    {
        abort_unless($tugas->guru_id === auth()->id(), 403);

        $data = $request->validate([
            'kategori' => 'required|string|max:100',
            'judul' => 'required|string|max:120',
            'soal' => 'required|string|max:200',
            'kunci_jawaban' => 'required|string|max:120',
        ]);

        $tugas->update($data);

        return back()->with('ok', 'Tugas berhasil diupdate.');
    }

    public function destroy(Tugas $tugas)
    {
        abort_unless($tugas->guru_id === auth()->id(), 403);

        $tugas->delete();

        return back()->with('ok', 'Tugas berhasil dihapus.');
    }

    // === TUGAS MASUK ===
    public function indexMasuk(Request $request)
    {
        $q = TugasSubmission::query()
            ->with(['tugas','siswa'])
            ->whereHas('tugas', function($qq){
                $qq->where('guru_id', auth()->id());
            });

        if ($request->filled('kategori')) {
            $q->whereHas('tugas', fn($qq) => $qq->where('kategori', $request->kategori));
        }
        if ($request->filled('tugas_id')) {
            $q->where('tugas_id', $request->tugas_id);
        }
        if ($request->filled('search_siswa')) {
            $s = $request->search_siswa;
            $q->whereHas('siswa', fn($qq) => $qq->where('name','like',"%$s%"));
        }

        $subs = $q->latest('submitted_at')->paginate(10)->withQueryString();

        // dropdown tugas (untuk filter)
        $tugasList = Tugas::where('guru_id', auth()->id())->latest()->get(['id','judul']);

        return view('web.tugas.masuk', compact('subs','tugasList'));
    }

    public function show(TugasSubmission $submission)
    {
        // pastikan hanya guru pembuat tugas yang boleh lihat
        abort_unless($submission->tugas->guru_id === auth()->id(), 403);

        return view('web.tugas.detail', compact('submission'));
    }
}
