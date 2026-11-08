<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukuController extends Controller
{
    public function daftarbuku()
    {
        $buku = Buku::all();

        return view('buku.index', ['buku' => $buku]);
    }

    public function show($id)
    {
        $buku = Buku::find($id);

        if ($buku) {
            return view('buku.show', ['item' => $buku]);
        }

        return view('buku.show', ['item' => null]);

    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
