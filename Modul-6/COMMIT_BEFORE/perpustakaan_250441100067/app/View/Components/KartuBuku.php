<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KartuBuku extends Component
{
    public $id;
    public $judul;
    public $penulis;
    public $tahun;

    public function __construct($id, $judul, $penulis, $tahun)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahun = $tahun;
    }

    public function render(): View|Closure|string
    {
        return view('components.kartu-buku');
    }
}